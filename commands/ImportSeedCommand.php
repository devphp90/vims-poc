<?php
 
class ImportSeedCommand extends CConsoleCommand {

    /**
     * Will import into SupInventory from a given seed file.
     * Currently we will hard code the sheet name and the ftp server
     * @param $args
     */
    public function run($args)
    {
        $supplierId = 132;
        $supplier = Supplier::model()->findByPk($supplierId);
        $filename = 'VIMS-Bradley-seed.xlsx';
//        $dest = Yii::getPathOfAlias('webroot.upload') . '/' . $filename;
        $dest = Yii::app()->basePath . '/../upload/' . $filename;
//        $ftp = Yii::app()->ftp;
//        $ftp->username = 'vimstest';
//        $ftp->password = 't_Ko-9&8^9fN';
//        $ftp->host = 'ftp://vimstest.axeo.net';
//
//        $ftp->setActive(true);
//        if (!$ftp->getActive()) {
//            print "connection to ftp failed";
//            // report to database, add retry count
//            exit(0);
//        }
//
//        $dest = Yii::getPathOfAlias('webroot.upload') . '/' . $filename;
//        echo "downloading $filename to $dest ...please wait\n";
//        $result = $ftp->get($dest, $filename, FTP_BINARY);
//        echo "download complete $result\n";

        $curl = curl_init();
        $file = fopen ($dest, 'w');

        curl_setopt($curl, CURLOPT_URL, 'ftp://vimstest.axeo.net/VIMS-Bradley-seed.xlsx');
        curl_setopt($curl, CURLOPT_USERPWD, 'vimstest:t_Ko-9&8^9fN');
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_FILE, $file);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        $handle = fopen(Yii::getPathOfAlias('webroot') . '/../testlog.php', "w");
        if (substr($info['http_code'], 0, 1) !== '2') {
            print 'Failed connecting to FTP server!';
            fwrite($handle, 'Failed connecting to FTP server!');
            fclose($handle);
            fclose($file);
            curl_close($curl);
            exit(0);
        }

        curl_close($curl);
        fclose($file);

        Yii::import('application.vendors.PHPExcel',true);

        $objPHPExcel = PHPExcel_IOFactory::load($dest);
        $objWorksheet = $objPHPExcel->getActiveSheet();

//        print_r($objWorksheet->toArray()); exit(0);

        // $records = array();
        try {
          foreach ($objWorksheet->toArray() as $i => $row){
            if ($i == 1) continue;

            $item = $row;

            //$records[] = $item;

            // Sanitize
            if (!isset($item[2])) {
              fwrite($handle, '[UbsSku empty] :: ' . implode(' :: ', $item) . ' <br/>');
              print '[UbsSku empty] :: ' . implode(' :: ', $item) . "\n";
              continue;
            }

            if (!isset($item[3])) {
              fwrite($handle, '[Mpn empty] :: ' . implode(' :: ', $item) . ' <br/>');
              print '[Mpn empty] :: ' . implode(' :: ', $item) . "\n";
              continue;
            }

            if (!isset($item[4])) {
              fwrite($handle, '[Upc empty] :: ' . implode(' :: ', $item) . ' <br/>');
              print '[Upc empty] :: ' . implode(' :: ', $item) . "\n";
              continue;
            }

            if (!isset($item[5])) {
              fwrite($handle, '[SupplierSku empty] :: ' . implode(' :: ', $item) . ' <br/>');
              print '[SupplierSku empty] :: ' . implode(' :: ', $item) . "\n";
              continue;
            }

            if (!isset($item[6])) {
              fwrite($handle, '[ItemName empty] :: ' . implode(' :: ', $item) . ' <br/>');
              print '[ItemName empty] :: ' . implode(' :: ', $item) . "\n";
              continue;
            }

            // Skip existing vsku
            $sup_vsku = $item[3] . $item[4];
            if (SupInventory::model()->findByAttributes(array('sup_vsku' => $sup_vsku))) {
              fwrite($handle, '[sup_vsku already exist] :: ' . implode(' :: ', $item) . ' <br/>');
              print '[sup_vsku already exist] :: ' . implode(' :: ', $item) . "\n";
              continue;
            }

            $ubs_sku = $item[2];
            if (!UbsInventory::model()->bySku($ubs_sku)->find()) {
              fwrite($handle, '[UBS not found] :: ' . implode(' :: ', $item) . ' <br/>');
              print '[UBS not found] :: ' . implode(' :: ', $item) . "\n";
              continue;
            }

            $model = new SupInventory;
            $model->supplier_name = $supplier->name;
//          $model->ubs_id       = UbsInventory::model()->bySku($item[2])->find()->id;
            $model->ubs_sku      = $ubs_sku;
            $model->sup_vsku     = $sup_vsku;
            $model->sup_sku      = $item[5];
            $model->mfg_upc      = $item[4];
            $model->mfg_sku      = $item[3];
            $model->mfg_sku_name = strlen($item[6]) > 100 ? substr($item[6], 0, 100) : $item[6];

            if (!$model->save()) {
              fwrite($handle, '[SAVE errors] :: ' . implode(' :: ', $model->errors) . ' <br/>' . implode(' :: ', $item) . '<br/>');
            }
          }
        } catch (Exception $e) {
          fwrite($handle, '[Exception Error] :: ' . $e->__toString() . '<br/>');
          print '[Exception Error] :: ' . $e->__toString();
        }
        fwrite($handle, '<hr><h3>DONE!!!</h3>');
        fclose($handle);
    }
}