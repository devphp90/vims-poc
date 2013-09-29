<?php

class SupNewItemController extends Controller
{

    public $tempCounter = 1;

    /**

     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning

     * using two-column layout. See 'protected/views/layouts/column2.php'.

     */
    public $layout = '//layouts/column2';

    /**

     * @return array action filters

     */
    public function filters()
    {

        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**

     * Specifies the access control rules.

     * This method is used by the 'accessControl' filter.

     * @return array access control rules

     */
    public function accessRules()
    {

        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions


                'actions' => array('update', 'admin', 'delete', 'deleteNoMatch', 'deleteAllNoMatch', 'deleteAllMisMatch', 'deleteAll', 'deleteAllMarkedAsMisMatch',
                    'import', 'newitemlink', 'updateMatch', 'noMatch', 'misMatch', 'importedItem', 'updateStatus', 'noMatchExport',
                    'importpage', 'supchecker', 'supchecker2', 'getData', 'groupsupchecker', 'calculate', 'updatePageY', 'index', 'view', 'updatePageN'),
                'users' => array('@'),
            ),
            array('deny', // deny all users

                'users' => array('*'),
            ),
        );
    }

    public function actionNoMatchExport($type)
    {
        Yii::import('application.vendors.*');
        require_once 'PHPExcel.php';

        $export = new Export();
        $results = SupItemsNewNoMatch::model()->findAll();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(Yii::app()->name)
                ->setLastModifiedBy(Yii::app()->name);
        $base = 1;
        /** @var SupItemsNewNoMatch $model  */
        $model = SupItemsNewNoMatch::model();
        $names = $model->attributeNames();
        $char = 'A';
        //Set header
        foreach ($names as $name) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($char . $base, $model->getAttributeLabel($name))
                    ->getColumnDimension($char)->setAutoSize(true);
            $char = chr(ord($char) + 1);
        }
        //Set value
        /** @var SupItemsNewNoMatch $item */
        foreach ($results as $item) {
            $char = 'A';
            $base++;
            foreach ($names as $name) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($char . $base, $item->{$name});
                $char = chr(ord($char) + 1);
            }
        }

        if ($type == 'excel') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="SupItemsNewNoMatch.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        } elseif ($type == 'csv') {
            $fileName = 'SupItemsNewNoMatch.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
            $objWriter->save('php://output');
        }
    }

    public function actionGroupSupChecker($supid)
    {

        $model = new SupItemsNewManage('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SupItemsNewManage']))
            $model->attributes = $_GET['SupItemsNewManage'];



        $this->render('groupsupchecker', array(
            'model' => $model,
            'supid' => $supid,
        ));
    }

    public function actionCalculate()
    {

        $time = time();

        $models = SupItemsNewManage::model()->findAll(array(
            'offset' => '66000',
            'limit' => '3000',
                ));



        foreach ($models as $id => $model) {

            $model->save(false);
        }

        echo time() - $time;
    }

    public function actionSupChecker()
    {
        $request = Yii::app()->request;
        $supplierId = $request->getQuery('supid');

        $model = new SupItemsNewManage('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SupItemsNewManage']))
            $model->attributes = $_GET['SupItemsNewManage'];


        if ($supplierId)
            $model->sup_id = $supplierId;

        $this->render('supchecker', array(
            'model' => $model,
            'supid' => $supplierId,
            'supplier' => Supplier::model()->findByPk($supplierId),
        ));
    }
    
    public function actionSupChecker2()
    {
        $request = Yii::app()->request;
        $supplierId = $request->getQuery('supid');
        
        $this->render('supchecker2', array(
            'supid' => $supplierId,
            'supplier' => Supplier::model()->findByPk($supplierId),
        ));
    }
    
    public function actionGetData()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $request = Yii::app()->request;
            $supplierId = $request->getParam('supid');

            $model = new SupItemsNewManage('search');
            $model->unsetAttributes();  // clear any default values
            $model->sup_id = $supplierId;
            $dataProvider = $model->searchSupchecker();
            $data = '';

            $count = count($dataProvider->data);
            if ($count > 0) {
                $data .= '{"total":' . $count . ',"rows":[';
                foreach ($dataProvider->data as $key => $result) {
                    $matchBy = $result->getMatchByStatus();
                    $match = "";
                    $diff = !is_null($result->ubsinventory) ? ($result->ubsinventory->price == 0 ? "n/a" : sprintf("%.2f", (abs($result->ubsinventory->price - $result->sup_price) / $result->ubsinventory->price) * 100) . "%" ) : "";
                    $ubsItemCost = !is_null($result->ubsinventory) ? $result->ubsinventory->price : "";
                    $suppItemPrice = $result->sup_price;
                    $priceDiff = !empty($result->ubsinventory) ? ($result->ubsinventory->price - $result->sup_price) : "";

                    $ubsSku = !is_null($result->ubsinventory) ? $result->ubsinventory->sku : "";
                    $ubsItemName = !is_null($result->ubsinventory) ? ((strlen($result->ubsinventory->sku_name) > 50) ? "<a href='#' rel='tooltip' title='" . $result->ubsinventory->sku_name . "'>" . substr($result->ubsinventory->sku_name, 0, 50) . "...</a>" : $result->ubsinventory->sku_name) : "";
                    $mfg_part_name = (strlen($result->mfg_part_name) > 10) ? "<a href='#' rel='tooltip' title='". $result->mfg_part_name . "'>" . substr($result->mfg_part_name, 0, 10) . "...</a>" : $result->mfg_part_name;
                    $supp_mfg_name = (strlen($result->mfg_name) > 20) ? "<a href='#' title='" . $result->mfg_name . "' rel='tooltip'>" . substr($result->mfg_name, 0, 20) . "...</a>" : $result->mfg_name;
                    $ubs_mfg_name = !empty($result->ubsinventory) ? $result->ubsinventory->mfg_title : '';
                    $supp_mpn = $result->mfg_sku;
                    $ubs_mpn = !is_null($result->ubsinventory) ? $result->ubsinventory->mfg_name : "";
                    $supp_upc = $result->upc;
                    $ubs_upc = isset($result->ubsinventory->upc) ? $result->ubsinventory->upc : "";
                    $will_auto_accept = ($result->importStatus != 'Will Import' ? CHtml::link("no", "#", array("rel" => "tooltip", "title" => $result->importStatus)) : "yes");
                    $info ="<a href='#' class='checkernum' :checkid='" . $result->id . "' title='ubs_id = " . (!is_null($result->ubsinventory) ? $result->ubsinventory->id : 0) . ",vims_id = " . $result->id . ",vsku =" . $result->sup_vsku . ",import_id=" . $result->import_routine->id . "' rel='tooltip'>info</a>";
                    $delete = "<a href='/index.php/supNewItem/delete/391942' title='Delete' class='delete'><img alt='Delete' src='/assets/3a624659/gridview/delete.png'></a>";
                    
                    $data .= '{"matchby" : "'.$matchBy.'", "match" : "'. $match .'", "diff" : "'.$diff.'", "ubs_item_cost" : "'.$ubsItemCost.'", "supp_item_price" : "'.$suppItemPrice.'", "price_diff" : "'.$priceDiff.'",
                        "ubs_sku" : "'.$ubsSku.'", "ubs_item_name" : "'.$ubsItemName.'", "mfg_part_name" : "'.$mfg_part_name.'", "supp_mfg_name" : "'.$supp_mfg_name.'", "ubs_mfg_name" : "'.$ubs_mfg_name.'", "supp_mpn" : "'.$supp_mpn.'",
                        "ubs_mpn" : "'.$ubs_mpn.'", "supp_upc" : "'.$supp_upc.'", "ubs_upc" : "'.$ubs_upc.'", "will_auto_accept" : "'.$will_auto_accept.'", "info" : "'.$info.'", "delete" : "'.$delete.'"
                    }' . ($key == ($count - 1) ? '' : ',');
                }
                $data .= ']}';
            } else
               $data = '
                    {"total":28,"rows":[
                    {"productid":"FI-SW-01","productname":"Koi","unitcost":10.00,"status":"P","listprice":36.50,"attr1":"Large","itemid":"EST-1"},
                    {"productid":"K9-DL-01","productname":"Dalmation","unitcost":12.00,"status":"P","listprice":18.50,"attr1":"Spotted Adult Female","itemid":"EST-10"},
                    {"productid":"RP-SN-01","productname":"Rattlesnake","unitcost":12.00,"status":"P","listprice":38.50,"attr1":"Venomless","itemid":"EST-11"},
                    {"productid":"RP-SN-01","productname":"Rattlesnake","unitcost":12.00,"status":"P","listprice":26.50,"attr1":"Rattleless","itemid":"EST-12"},
                    {"selected":true,"productid":"RP-LI-02","productname":"Iguana","unitcost":12.00,"status":"P","listprice":35.50,"attr1":"Green Adult","itemid":"EST-13"},
                    {"productid":"FL-DSH-01","productname":"Manx","unitcost":12.00,"status":"P","listprice":158.50,"attr1":"Tailless","itemid":"EST-14"},
                    {"productid":"FL-DSH-01","productname":"Manx","unitcost":12.00,"status":"P","listprice":83.50,"attr1":"With tail","itemid":"EST-15"},
                    {"productid":"FL-DLH-02","productname":"Persian","unitcost":12.00,"status":"P","listprice":23.50,"attr1":"Adult Female","itemid":"EST-16"},
                    {"productid":"FL-DLH-02","productname":"Persian","unitcost":12.00,"status":"P","listprice":89.50,"attr1":"Adult Male","itemid":"EST-17"},
                    {"productid":"AV-CB-01","productname":"Amazon Parrot","unitcost":92.00,"status":"P","listprice":63.50,"attr1":"Adult Male","itemid":"EST-18"}
                    ]}
                ';

            echo $data;
        }
    }

    public function actionUpdateStatus($id, $value)
    {

        $newModel = SupItemsNewManage::model()->findByPk($id);

        $newModel->item_status = $value;

        $newModel->save();
    }

    public function actionUpdatePageY($checkers)
    {

        $checkers = explode(',', rtrim($checkers, ','));

        foreach ($checkers as $value) {

            $newModel = SupItemsNewManage::model()->findByPk($value);

            $newModel->match = 1;

            $newModel->save(false);
        }
    }

    public function actionUpdatePageN($checkers)
    {

        $checkers = explode(',', rtrim($checkers, ','));

        foreach ($checkers as $value) {

            $newModel = SupItemsNewManage::model()->findByPk($value);

            $newModel->match = 0;

            $newModel->save(false);
        }
    }

    public function actionUpdateMatch($id, $value)
    {

        $newModel = SupItemsNewManage::model()->findByPk($id);

        $newModel->match = $value;

        $newModel->save();

        // Update the rest
        if ($value == SupItemsNewManage::MATCH_STATUS_YES) {
            foreach (SupItemsNewManage::model()->findAllByAttributes(array('sup_vsku' => $newModel->sup_vsku)) as $item) {
                if ($item->id == $id)
                    continue;

                $item->match = SupItemsNewManage::MATCH_STATUS_NO;
                $item->save();
            }
        }
    }

    public function actionDeleteAll($id)
    {
        // Get all import id of this supplier
        $cmd = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{import_routine}}')
                ->where('sup_id = ' . $id);

        $importIds = $cmd->queryColumn();

        $criteria = new CDbCriteria;
        $criteria->addInCondition('import_id', $importIds);

        SupItemsNewManage::model()->deleteAll($criteria);

        $this->redirect(array('supChecker', 'supid' => $id));
    }

    /**
     * Delete all no match records of this supplier
     *
     * @author jovani
     * @param $id supplier id
     */
    public function actionDeleteAllNoMatch($id)
    {
        SupItemsNewNoMatch::model()->deleteAllByAttributes(array('sup_id' => $id));

        $this->redirect(array('noMatch', 'sup_id' => $id));
    }

    /**
     * Delete all mis match records of this supplier
     *
     * @author jovani
     * @param $id supplier id
     */
    public function actionDeleteAllMisMatch($id)
    {
        SupItemsNewMisMatch::model()->deleteAllByAttributes(array('sup_id' => $id));

        $this->redirect(array('misMatch', 'sup_id' => $id));
    }

    /**
     * Delete all marked by User as MisMatch on checkers page -- All N
     *
     * @author jovani
     * @param $id supplier id
     */
    public function actionDeleteAllMarkedAsMisMatch($id)
    {
        // Let's just delete from all import routines of this supplier
        // @todo there should only be one routine per supplier
        $cmd = Yii::app()->db->createCommand()
                ->select('id')
                ->from('{{import_routine}}')
                ->where('sup_id = :sup_id', array(':sup_id' => $id));
        $ids = $cmd->queryColumn();
        SupItemsNewManage::model()->deleteAllByAttributes(array('import_id' => $ids,
            'match' => SupItemsNewManage::MATCH_STATUS_NO));

        $this->redirect(array('supChecker', 'supid' => $id));
    }

    public function actionNewItemLink()
    {

        $model = new SupItemsNewManage('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SupItemsNewManage']))
            $model->attributes = $_GET['SupItemsNewManage'];



        $this->render('newitemlink', array(
            'model' => $model,
        ));
    }

    /**
     * List of no match items
     *
     * @author jovani
     */
    public function actionNoMatch()
    {
        $request = Yii::app()->request;
        $supplierId = $request->getQuery('sup_id');
        $model = new SupItemsNewNoMatch('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SupItemsNewNoMatch']))
            $model->attributes = $_GET['SupItemsNewNoMatch'];


        if ($supplierId)
            $model->sup_id = $supplierId;

        $this->render('nomatchitem', array(
            'model' => $model,
            'supplier' => Supplier::model()->findByPk($supplierId),
        ));
    }

    /**
     * List of mis match items
     *
     * @author jovani
     */
    public function actionMisMatch()
    {
        $request = Yii::app()->request;
        $supplierId = $request->getQuery('sup_id');
        $model = new SupItemsNewMisMatch('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SupItemsNewMisMatch']))
            $model->attributes = $_GET['SupItemsNewMisMatch'];


        if ($supplierId)
            $model->sup_id = $supplierId;

        $this->render('mismatch', array(
            'model' => $model,
            'supplier' => Supplier::model()->findByPk($supplierId),
        ));
    }

//	public function actionNoMatchItem()
//
//	{
//    $request = Yii::app()->request;
//
//    $supplierId = $request->getQuery('sup_id');
//
//		$model=new SupItemsNoMatch('search');
//
//		$model->unsetAttributes();  // clear any default values
//
//		if(isset($_GET['SupItemsNoMatch']))
//
//			$model->attributes=$_GET['SupItemsNoMatch'];
//
//
//    if ($supplierId)
//      $model->sup_id = $supplierId;
//
//		$this->render('nomatchitem',array(
//
//			'model'=>$model,
//      'supplier' => Supplier::model()->findByPk($supplierId),
//
//		));
//
//
//
//	}



    public function actionImportedItem()
    {

        $model = new SupItemsNewManage('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SupItemsNewManage']))
            $model->attributes = $_GET['SupItemsNewManage'];



        $this->render('importeditem', array(
            'model' => $model,
        ));
    }

    /**
     * Process checker items
     * 1. Retrieve all Y, save to SupInventory
     * 2. Retrieve all N, save unique vsheet item (except those from #1) to SupItemsNewNoMatch
     * 3. The rest of all N should go to mismatch
     * 4. Delete at once
     */
    public function actionImportpage($checkers)
    {

        session_write_close();





        // Do some time-expensive stuff here...

        echo '<h1>New Items Transfer Status</h1><pre>';

        echo "id\t\tStatus\t\tReason\n";

        echo "-------------------------------------\n";



        $checkers = explode(',', rtrim($checkers, ','));



//			$modelAll = SupItemsNewManage::model()->findAllByAttributes(array('id'=>$checkers));

        $i = 1;

        // Records unique sup_vsku
        $recordedNoMatchItems = array();
        $recordedMatchItems = array();
        $importId = 0;


        // 1. All Y
        foreach (SupItemsNewManage::model()->findAllByAttributes(array(
            'id' => $checkers,
            'match' => SupItemsNewManage::MATCH_STATUS_YES,
        )) as $checkerItem) {

            $model = new SupInventory;

            //$model->ubs_id = $newModel->ubsinventory->id;

            $model->ubs_sku = $checkerItem->ubsinventory->sku;

            $model->sup_id = $checkerItem->import_routine->sup_id;

            $model->supplier_name = Supplier::model()->findByPk($model->sup_id)->name;

            $model->sup_vsku = $checkerItem->sup_vsku;

            $model->mfg_sku = $checkerItem->mfg_sku;

            $model->mfg_upc = $checkerItem->upc;

            $model->mfg_name = $checkerItem->mfg_name;

            $model->mfg_sku_name = $checkerItem->mfg_part_name;

            $model->sup_sku = $checkerItem->sup_sku;

            $model->sup_sku_name = $checkerItem->sup_sku_name;

            $model->sup_description = $checkerItem->sup_description;

            $model->sup_status = 1;

            $model->sup_price = $checkerItem->sup_price;

            if ($model->save()) {

                $checkerItem->item_status = 1;

                $recordedMatchItems[] = $checkerItem->sup_vsku;

//          if($checkerItem->delete())

                printf("%d\t\t%s\t\t%s", $checkerItem->id, "Success", 'Imported, Item deleted!');

//          else
//
//            echo 'fatal error';
                $importId = $checkerItem->import_id;
            } else {

                $error = '';

                foreach ($model->getErrors() as $attribute => $reason)
                    $error .= $i++ . '. ' . $attribute . ' => ' . implode(',', $reason) . '     ';

                printf("%d\t\t%s\t\t%s", $checkerItem->id, "<font color='red'>Failed</font>", $error);
            }
            echo "<br/>";
        } // All Y
        // 2. All N
        foreach (SupItemsNewManage::model()->findAllByAttributes(array(
            'id' => $checkers,
            'match' => SupItemsNewManage::MATCH_STATUS_NO,
        )) as $checkerItem) {

            // User had this item to Y, should not go to no match items
            if (in_array($checkerItem->sup_vsku, $recordedMatchItems))
                continue;
            // We only need to record a single vsheet item
            if (in_array($checkerItem->sup_vsku, $recordedNoMatchItems))
                continue;

            $noMatch = new SupItemsNewNoMatch;

            $noMatch->ubs_id = $checkerItem->ubsinventory->id;

            $noMatch->sup_id = $checkerItem->import_routine->sup_id;

            $noMatch->sup_vsku = $checkerItem->sup_vsku;

            $noMatch->mfg_sku = $checkerItem->mfg_sku;

            $noMatch->mfg_upc = $checkerItem->upc;

            $noMatch->mfg_name = $checkerItem->mfg_name;

            $noMatch->mfg_sku_name = $checkerItem->mfg_part_name;

            $noMatch->sup_sku = $checkerItem->sup_sku;

            $noMatch->sup_sku_name = $checkerItem->sup_sku_name;

            $noMatch->sup_description = $checkerItem->sup_description;

            $noMatch->sup_price = $checkerItem->sup_price;
            if ($noMatch->save()) {
                $recordedNoMatchItems[] = $checkerItem->sup_vsku;
                $importId = $checkerItem->import_id;
                printf("%d\t\t%s\t\t%s", $checkerItem->id, "success", 'Transferred to No Match table.');
            } else {
                printf("%d\t\t%s\t\t%s", $checkerItem->id, "<font color='red'>Failed</font>", 'Item remain!');
            }
            echo "<br/>";
        }

        // 3. All N with ubs item to mismatch
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $checkers);
        $criteria->addCondition('`match` = ' . SupItemsNewManage::MATCH_STATUS_NO);
        $criteria->addCondition('match_ubs_id > 0');
        foreach (SupItemsNewManage::model()->findAll($criteria) as $checkerItem) {
            $misMatch = new SupItemsNewMisMatch;

            $misMatch->ubs_id = $checkerItem->ubsinventory->id;

            //$modelNoMatch->ubs_sku = $newModel->ubsinventory->sku;

            $misMatch->sup_id = $checkerItem->import_routine->sup_id;

            //$modelNoMatch->supplier_name = Supplier::model()->findByPk($modelNoMatch->sup_id)->name;

            $misMatch->sup_vsku = $checkerItem->sup_vsku;

            $misMatch->mfg_sku = $checkerItem->mfg_sku;

            $misMatch->mfg_upc = $checkerItem->upc;

            $misMatch->mfg_name = $checkerItem->mfg_name;

            $misMatch->mfg_sku_name = $checkerItem->mfg_part_name;

            $misMatch->sup_sku = $checkerItem->sup_sku;

            $misMatch->sup_sku_name = $checkerItem->sup_sku_name;

            $misMatch->sup_description = $checkerItem->sup_description;

            //$modelNoMatch->sup_status = 0;// no match

            $misMatch->sup_price = $checkerItem->sup_price;
            if ($misMatch->save()) {
                printf("%d\t\t%s\t\t%s", $checkerItem->id, "success", 'Transferred to Mis Match table.');
                $importId = $checkerItem->import_id;
            } else {
                printf("%d\t\t%s\t\t%s", $checkerItem->id, "<font color='red'>Failed</font>", 'Item remain!');
            }
            echo "<br/>";
        }

        // Purge checkers table
        $criteria = new CDbCriteria;
        $criteria->addCondition('import_id = :import_id');
        $criteria->addCondition('`match` <> :match');
        $criteria->params = array(
            ':import_id' => $importId,
            ':match' => SupItemsNewManage::MATCH_STATUS_UNDECIDED,
        );
        SupItemsNewManage::model()->deleteAll($criteria);

        // and after that release the lock...
    }

    public function actionImport()
    {



        session_write_close();



        // Do some time-expensive stuff here...

        echo '<h1>New Items Transfer Status</h1><pre>';

        echo "id\t\tStatus\t\tReason\n";

        echo "-------------------------------------\n";

        $modelAll = SupItemsNewManage::model()->findAll(array(
            'condition' => 'item_status=0 and `match`!=2',
                ));

        $i = 1;

        foreach ($modelAll as $id => $newModel) {



            $model = new SupInventory;

            //$model->ubs_id = $newModel->ubsinventory->id;

            $model->ubs_sku = $newModel->ubsinventory->sku;

            $model->sup_id = $newModel->import_routine->sup_id;

            $model->supplier_name = Supplier::model()->findByPk($model->sup_id)->name;

            $model->sup_vsku = $newModel->sup_vsku;

            $model->mfg_sku = $newModel->mfg_sku;

            $model->mfg_upc = $newModel->upc;

            $model->mfg_name = $newModel->mfg_name;

            $model->mfg_sku_name = $newModel->mfg_part_name;

            $model->sup_sku = $newModel->sup_sku;

            $model->sup_sku_name = $newModel->sup_sku_name;

            $model->sup_description = $newModel->sup_description;

            $model->sup_status = 1;

            $model->sup_price = $newModel->sup_price;

            if ($newModel->match == 0) {

                $newModel->item_status = 2;

                if ($newModel->save())
                    printf("%d\t\t%s\t\t%s", $newModel->id, "success", 'No Import!');

                else
                    printf("%d\t\t%s\t\t%s", $newModel->id, "<font color='red'>Failed</font>", 'Item remain!');
            }else if ($newModel->match == 1) {



                if ($model->save()) {

                    $newModel->item_status = 1;

                    if ($newModel->save())
                        printf("%d\t\t%s\t\t%s", $newModel->id, "Success", 'Imported, Item deleted!');
                }else {

                    $error = '';

                    foreach ($model->getErrors() as $attribute => $reason)
                        $error .= $i++ . '. ' . $attribute . ' => ' . implode(',', $reason) . '     ';

                    printf("%d\t\t%s\t\t%s", $newModel->id, "<font color='red'>Failed</font>", $error);
                }
            }

            echo '<br/>';
        }







        echo '<a href="newItemLink">Back to Checkers<a/>';

        //$this->redirect('newItemLink');
    }

    /**

     * Displays a particular model.

     * @param integer $id the ID of the model to be displayed

     */
    public function actionView($id)
    {

        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**

     * Creates a new model.

     * If creation is successful, the browser will be redirected to the 'view' page.

     */
    public function actionCreate()
    {

        $model = new SupItemsNewManage;



        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);



        if (isset($_POST['SupItemsNewManage'])) {

            $model->attributes = $_POST['SupItemsNewManage'];

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }



        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**

     * Updates a particular model.

     * If update is successful, the browser will be redirected to the 'view' page.

     * @param integer $id the ID of the model to be updated

     */
    public function actionUpdate($id)
    {

        $model = $this->loadModel($id);



        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);



        if (isset($_POST['SupItemsNewManage'])) {

            $model->attributes = $_POST['SupItemsNewManage'];

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }



        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**

     * Deletes a particular model.

     * If deletion is successful, the browser will be redirected to the 'admin' page.

     * @param integer $id the ID of the model to be deleted

     */
    public function actionDelete($id)
    {

        if (Yii::app()->request->isPostRequest) {

            // we only allow deletion via POST request

            $this->loadModel($id)->delete();



            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }

        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Deletes a record from the nomatch table
     *
     * @author jovani
     * @param $id
     */
    public function actionDeleteNoMatch($id)
    {
        SupItemsNew::model()->deleteByPk($id);

        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**

     * Lists all models.

     */
    public function actionIndex()
    {

        $dataProvider = new CActiveDataProvider('SupItemsNewManage');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**

     * Manages all models.

     */
    public function actionAdmin()
    {

        $model = new SupItemsNewManage('search');

        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['SupItemsNewManage']))
            $model->attributes = $_GET['SupItemsNewManage'];



        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**

     * Returns the data model based on the primary key given in the GET variable.

     * If the data model is not found, an HTTP exception will be raised.

     * @param integer the ID of the model to be loaded

     */
    public function loadModel($id)
    {

        $model = SupItemsNewManage::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**

     * Performs the AJAX validation.

     * @param CModel the model to be validated

     */
    protected function performAjaxValidation($model)
    {

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sup-new-item-form') {

            echo CActiveForm::validate($model);

            Yii::app()->end();
        }
    }

}

