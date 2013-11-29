<?php
/*
Get file from download server

import file into vSheet
@property CDbCommand $_dbcommand
*/
class Import
{
    private $_tabsModel;
    private $_importLogModel;
    private $_importRoutineModel;
    private $_importRoutineModel2;
    private $_updateDir;
    private $_importFile;
    private $_importSheet2;
    private $_routineModel;
    private $_importModel;
    private $_warehouse = array();
    private $_newField = array();
    private $_columnNum = NULL;
    private $_match = array();
    private $_countData = 0;
    private $_dbcommand;


    function __construct($tabid, $importSheet2)
    {
        $this->init($tabid, $importSheet2);

        $this->run();

    }

    public function init($tabid, $importSheet2)
    {
        $this->_tabsModel = Tabs::model()->findByPk($tabid);

        if ($this->_tabsModel == null)
            throw new CHttpException('500', 'Can\'t find Tabs id.');

        $this->_importLogModel = TabsImportLog::model()->find(array(
            'condition' => 'tabs_id=:tabs_id',
            'params' => array(
                ':tabs_id' => $tabid,
            ),
            'order' => 'id desc',
        ));

        $this->_importRoutineModel = $this->_tabsModel->importRoutine;

        $this->_importRoutineModel2 = $this->_tabsModel->importRoutine2;

        $this->_updateDir = Yii::getPathOfAlias('webroot.upload.updateTemp');

        $this->_importSheet2 = $importSheet2;

        $this->_dbcommand = Yii::app()->db->createCommand();


    }

    public function run()
    {

        $this->importStatus('data_integrity_type', 1);

        if ($this->_tabsModel->supplier->active == 0)
            $this->updateLog('data_integrity_type', 'Supplier is Inactive', true);


        $this->_importLogModel->download_finish_time = date("Y-m-d H:i:s");

        $this->_importLogModel->save();

        $this->clearOldData($this->_importRoutineModel->id);


        $this->importSheet1();


        if ($this->_importSheet2)
            $this->importSheet2();

        $this->_importLogModel->finish_time = date("Y-m-d H:i:s");

        $this->_importLogModel->save();

        $updateUrl = Yii::app()->controller->createAbsoluteUrl("/importRoutine/updateFile", array(
            'id' => $this->_tabsModel->import_routine_id,
        ));

        $command = 'cd /tmp;wget --delete-after -q ' . $updateUrl . ' > /dev/null &';
        exec($command);
//		echo $command;


    }

    public function importSheet1()
    {
        $this->_importFile = $this->_updateDir . DIRECTORY_SEPARATOR . $this->_importRoutineModel->id;

        $this->_routineModel = $this->_importRoutineModel;

        $this->_importModel = $this->_routineModel->getImportModel();

        $this->prepareField();

        $this->getDownloadFile();

        $this->prepareMatch();


        $this->prepareUpdateData();


        $this->importStatus('data_integrity_type', 3);
        if ($this->_importRoutineModel->method_id != 4) {
            $this->importStatus('overall_item', 1);

            $this->checkOverallItem();

            $this->importStatus('overall_item', 3);
        }

    }

    public function importSheet2()
    {

        $this->_importFile = $this->_updateDir . DIRECTORY_SEPARATOR . $this->_importRoutineModel2->id;

        $this->_routineModel = $this->_importRoutineModel2;

        $this->_importModel = $this->_routineModel->getImportModel();

        if ($this->_importRoutineModel->default_price > 0) {
            ImportVsheet::model()->updateAll(
                array(
                    'sheet_type' => 1,
                    'price' => $this->_importRoutineModel->default_price,
                ),
                'import_id=' . $this->_importRoutineModel->id
            );
            return;
        }

        $this->prepareField();

        $this->getDownloadFile();

        $this->prepareMatch();

        $this->prepareUpdateDataSheet2();
    }

    public function prepareUpdateDataSheet2()
    {


        switch ($this->_routineModel->file_id) {
            case 1: //csv
                $this->convertCSVSheet2();
                break;

            case 2: //txt
                break;

            case 3: //xls
                $this->convertXLSSheet2();
                break;
        }
    }

    public function prepareField()
    {
        $this->_warehouse = array(
            '1' => 'ware_1',
            '2' => 'ware_2',
            '3' => 'ware_3',
            '4' => 'ware_4',
            '5' => 'ware_5',
            '6' => 'ware_6',
        );
        $this->_newField = array(
            'mfg_sku' => 'new_mfg_sku',
            'upc' => 'new_upc',
            'mfg_name' => 'new_mfg_name',
            'mfg_part_name' => 'new_mfg_part_name',
            'sup_sku' => 'new_sup_sku',
            'sup_sku_name' => 'new_sup_sku_name',
        );

    }

    public function convertCSVSheet2()
    {

        $delimiter = empty($this->_routineModel->delimiter) ? ',' : $this->_routineModel->delimiter;
        $enclosure = empty($this->_routineModel->enclosure) ? '' : $this->_routineModel->enclosure;

        if ($delimiter == '\t')
            $delimiter = "\t";

        if (($handle = fopen($this->_importFile, "r")) !== FALSE) {
            $id = 0;
            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {

                if ($this->_routineModel->match_startby - 1 > $id++)
                    continue;
                $this->setVsheetPrice($row[$this->_newField['mfg_sku']], $row[$this->_match['price']]);
                $this->setVsheetMAP($row[$this->_newField['map']], $row[$this->_match['map']]);

            }
            fclose($handle);
        }
    }

    public function convertXLSSheet2()
    {

        Yii::import('application.vendors.PHPExcel', true);
        $dir = Yii::getPathOfAlias('ext.phpexcelreader');

        $objPHPExcel = PHPExcel_IOFactory::load($this->_importFile);
        $objWorksheet = $objPHPExcel->getActiveSheet();


        foreach ($objWorksheet->getRowIterator() as $row_id => $rows) {

            if ($this->_routineModel->match_startby > $row_id)
                continue;

            $row = array();
            foreach ($rows->getCellIterator() as $cell_id => $cell)
                $row[$cell_id] = trim($cell->getValue());

            $this->setVsheetPrice($row[$this->_newField['mfg_sku']], $row[$this->_match['price']]);

            $this->setVsheetMAP($row[$this->_newField['mfg_sku']], $row[$this->_match['map']]);
        }
    }

    public function setVsheetPrice($sku, $price)
    {

        $vsheet = ImportVsheet::model()->findByAttributes(array(
            'import_id' => $this->_importRoutineModel->id,
            'mfg_sku' => $sku,
        ));

        if ($vsheet != null) {

            $vsheet->sheet_type = 1;
            $vsheet->price = $this->checkDIcolumnType('price', $price);
            $vsheet->save();
        }

    }

    public function setVsheetMAP($sku, $map)
    {

        $vsheet = ImportVsheet::model()->findByAttributes(array(
            'import_id' => $this->_importRoutineModel->id,
            'mfg_sku' => $sku,
        ));

        if ($vsheet != null) {
            $vsheet->sheet_type = 1;
            $vsheet->map = $this->checkDIcolumnType('MAP', $map);
            $vsheet->save();
        }

    }

    public function importStatus($step, $status)
    {
        $a = $step . '_status';

        $this->_importLogModel->$a = $status;

        $this->_importLogModel->save();
    }

    public function clearOldData($id)
    {
        $command = Yii::app()->db->createCommand();
        $command->delete('vims_import_vsheet', 'import_id=:id', array(':id' => $id));

    }

    public function getDownloadFile()
    {

        if (is_writable($this->_updateDir)) {

            $ch = curl_init();
            $file = fopen($this->_importFile, 'w');


            curl_setopt($ch, CURLOPT_URL, $this->_importModel->import_file_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_FILE, $file);


            $content = curl_exec($ch);
            $info = curl_getinfo($ch);

            curl_close($ch);
            fclose($file);

        } else {
            //echo 'gg';
            $this->updateLog('data_integrity_type', $this->_updateDir . ' unwrittable', true);
        }
        if (!filesize($this->_importFile))
            $this->updateLog('data_integrity_type', 'Download file error', true);
    }

    public function updateLog($step, $reason = '', $isFatal = false)
    {
        $this->_importLogModel->{$step . '_reason'} .= $reason . '<br/>';

        if ($isFatal == true) {
            $this->_tabsModel->supplier->active = 0;
            $this->_tabsModel->supplier->save();
            $this->_importLogModel->{$step . '_status'} = 2;
            $this->_importLogModel->save();
            exit;
        } else
            $this->_importLogModel->save();
    }


    public function prepareUpdateData()
    {
        $this->importStatus('data_integrity_type', 1);
        $this->importStatus('data_integrity_count', 1);


        switch ($this->_routineModel->file_id) {
            case 1: //csv
                $this->convertCSV();
                break;

            case 2: //txt
                break;

            case 3: //xls
                $this->convertXLS();
                break;

            default:
                $this->updateLog('prepare', 'File type error(file_id:' . $this->_routineModel->file_id . ')', true);
        }
        $this->_importLogModel->item = $this->_countData;
        $this->_importLogModel->save();

        $this->importStatus('data_integrity_type', 3);
        $this->importStatus('data_integrity_count', 3);

        if ($this->_importRoutineModel->method_id == 4) {
            $this->importStatus('data_integrity_type', 0);
            $this->importStatus('data_integrity_count', 0);
        }


    }

    public function convertCSV()
    {


        $delimiter = empty($this->_routineModel->delimiter) ? ',' : $this->_routineModel->delimiter;
        $enclosure = empty($this->_routineModel->enclosure) ? '' : $this->_routineModel->enclosure;

        if ($delimiter == '\t')
            $delimiter = "\t";
        if (($handle = fopen($this->_importFile, "r")) !== FALSE) {
            $id = 0;
            while (($row = fgetcsv($handle, 0, $delimiter, $enclosure)) !== FALSE) {
                if ($id < 1) {
                    $this->checkColumnNum($row);
                    $this->saveColumnNum($row);
                }

                if ($this->_routineModel->match_startby - 1 > $id++)
                    continue;

                $this->genPureData($row);

            }
            fclose($handle);
        }

    }

    public function saveColumnNum($row)
    {
        $this->_importLogModel->column_count = count($row);
        $this->_importLogModel->save();
    }

    public function checkColumnNum($row)
    {
        if ($this->_importRoutineModel->method_id != 4) {
            if (($this->_columnNum = count($row)) == 0)
                $this->updateLog("data_integrity_type", 'Column Integrity fail(Current column is zero.)', true);

            if ($this->_tabsModel->column_number != 0 && $this->_tabsModel->column_number != $this->_columnNum)
                $this->updateLog("data_integrity_count",
                    'Column Integrity fail (' .
                        'Previous column number : ' . (($this->_tabsModel->column_number) ? $this->_tabsModel->column_number : 0) . ', ' .
                        'Current column number:' . $this->_columnNum . ')', true);

            $this->_tabsModel->column_number = $this->_columnNum;
            $this->_tabsModel->save(false);
        }
    }

    public function checkDIcolumnType($column, $value)
    {

        if (!is_numeric($value))
            $this->updateLog("data_integrity_count",
                'Integrity fail (' .
                    'Column: ' . $column . ', ' .
                    'Value: ' . $value . ', is String must be Integer)', true);
        return $value;
    }

    public function checkOverallItem()
    {
        if ($this->_importRoutineModel->method_id != 4) {

            $itemChange = isset($this->_routineModel->update->getSupplierQaModel($this->_tabsModel->supplier_id)->item_percent) ?

                $this->_routineModel->update->getSupplierQaModel($this->_tabsModel->supplier_id)->item_percent :
                $this->_routineModel->update->getGlobalQaModel($this->_tabsModel->supplier_id)->item_percent;


            if ($this->_tabsModel->overall_item != 0 && $itemChange !== NULL) {

                $tolerant = $this->_tabsModel->overall_item * 0.01 * $itemChange;

                if ($this->_countData < abs($tolerant - $this->_tabsModel->overall_item) ||
                    $this->_countData > $tolerant + $this->_tabsModel->overall_item
                )

                    $this->updateLog('overall_item',
                        $itemChange . '%,previous:' . $this->_tabsModel->overall_item .
                            ',current:' . $this->_countData, true);
            }

            $this->_tabsModel->overall_item = $this->_countData;
            $this->_tabsModel->save(false);
        }
    }

    public function convertXLS()
    {

        Yii::import('application.vendors.PHPExcel', true);


        $objPHPExcel = PHPExcel_IOFactory::load($this->_importFile);
        $objWorksheet = $objPHPExcel->getActiveSheet();


        foreach ($objWorksheet->getRowIterator() as $row_id => $row) {
            if ($row_id <= 1) {
                foreach ($row->getCellIterator() as $cell_id => $cell)
                    $data[$cell_id] = trim($cell->getValue());
                $this->checkColumnNum($data);
                $this->saveColumnNum($data);
            }
            if ($this->_routineModel->match_startby > $row_id)
                continue;

            foreach ($row->getCellIterator() as $cell_id => $cell)
                $data[$cell_id] = trim($cell->getValue());
            $this->genPureData($data);
        }

        /*

                Yii::import('ext.excel.reader',true);

                $data = new Spreadsheet_Excel_Reader();
                $data->read($this->_importFile);

                for ($i = 0; $i < $data->sheets[0]['numRows']; $i++) {

                    if($this->_routineModel->match_startby > $i)
                        continue;
                    $row = array();
                    for ($j = 0; $j < $data->sheets[0]['numCols']; $j++)
                        $row[$j] = $data->sheets[0]['cells'][$i+1][$j+1];
                    $this->genPureData($row);
                }
        */
    }

    public function genPureData($row)
    {
        $this->_countData++;
        $totalQOH = 0;
        $item = 0;
        $result = array();

        @$result['sup_vsku'] = strtolower($row[$this->_match['match1']] .

            $row[$this->_match['match2']] .
            $row[$this->_match['match3']]);


        if (!empty($result['sup_vsku'])) {

            if (!empty($row[$this->_match['price']]))
                $result['price'] = $this->checkDIcolumnType('price', $row[$this->_match['price']]);

            if (!empty($row[$this->_match['map']]))
                $result['map'] = $this->checkDIcolumnType('map', $row[$this->_match['map']]);


            foreach ($this->_warehouse as $ware_id => $ware_value)
                if (!empty($row[$ware_value])) {
                    $result['ware_' . $ware_id] =
                        $this->checkDIcolumnType('ware_' . $ware_id, (int)$this->warehouseYn($row[$ware_value]));
                    $totalQOH += $result['ware_' . $ware_id];
                }

            foreach ($this->_newField as $newfield_id => $newfield_value)
                $result[$newfield_id] = $row[$newfield_value];

//			var_dump($result);
//			exit;

            // Sanitize
            foreach ($result as $key => $value) {
                if (is_string($value))
                    $result[$key] = strip_tags($value);
            }

            $result['sheet_type'] = 0;
            $result['import_id'] = $this->_routineModel->id;

            $result['sup_id'] = $this->_routineModel->sup_id;

            //tuned up, still testing
            /** @var CDbCommand $command  */
            $command = $this->_dbcommand;
            $model = ImportVsheet::model()->findByAttributes(
                array('sup_vsku' => $result['sup_vsku'])
            );
            if($model == null) {
                $command->insert('vims_import_vsheet', $result);
            } else {
                $command->insert('vims_supp_vsheet_dups', $result);
            }
            if ($this->_countData % 1000 == 0)
                $this->_importLogModel->saveCounters(array('item' => +1000));
        }

        return false;
    }

    public function prepareMatch()
    {

        $this->_match = array(
            'match1' => $this->getMatchValue($this->_routineModel->sup_match_column),
            'match2' => $this->getMatchValue($this->_routineModel->sup_match_column_1),
            'match3' => $this->getMatchValue($this->_routineModel->sup_match_column_2),
            'price' => $this->getMatchValue($this->_routineModel->price),
            'map' => $this->getMatchValue($this->_routineModel->min_adv_price),
        );

        foreach ($this->_warehouse as $target => &$field)
            if (($field = $this->getMatchValue($this->_routineModel->$field)) === NULL)
                unset($this->_warehouse[$target]);

        foreach ($this->_newField as $target => &$field)
            if (($field = $this->getMatchValue($this->_routineModel->$field)) === NULL)
                unset($this->_newField[$target]);
    }

    public function getMatchValue($field)
    {
        return empty($field) ? NULL : $field - 1;
    }

    public function warehouseYn($qoh)
    {

        if ($this->_routineModel->qoh_type == 1) {
            $text = strtolower($qoh);

            if ($text == 'y' || $text == 'yes')
                $qoh = $this->_routineModel->default_qty;
            else if ($text == 'n' || $text == 'no')
                $qoh = 0;

        } else {
//			if(!is_numeric($qoh))
//				$qoh = 0;
        }

        return $qoh;
    }
}

?>