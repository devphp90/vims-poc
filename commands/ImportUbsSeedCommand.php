<?php
 
class ImportUbsSeedCommand extends CConsoleCommand {

    /**
     * Will import into SupInventory from a given seed file.
     * Currently we will hard code the sheet name and the ftp server
     * @param $args
     */
    public function run($args)
    {
        $filename = 'UBS_SKUS.txt';
//        $filename = 'ubs_skus_small_version.csv';
//        $dest = Yii::getPathOfAlias('webroot.upload') . '/' . $filename;
        $dest = Yii::app()->basePath . '/../upload/' . $filename;

        $curl = curl_init();
        $file = fopen ($dest, 'w');

        curl_setopt($curl, CURLOPT_URL, 'ftp://vimstest.axeo.net/' . $filename);
        curl_setopt($curl, CURLOPT_USERPWD, 'vimstest:t_Ko-9&8^9fN');
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_FILE, $file);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        $handle = fopen(Yii::getPathOfAlias('webroot') . '/views/seed/ubs-log.php', "w");
        ftruncate($handle, 0);
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

//        Yii::import('application.vendors.PHPExcel',true);
//
//        $objPHPExcel = PHPExcel_IOFactory::load($dest);
//        $objWorksheet = $objPHPExcel->getActiveSheet();

        try {
          if (($csv = fopen($dest, "r")) !== false) {
            $i = 0;
            $records = array();
            while (($row = fgetcsv($csv)) !== false ) {
              $i++;
//              print '[row] :: ' . implode(' :: ', $row) . "\n";
              if ($i == 1) continue;
              // Sanitize
              if (!isset($row[0])) {
                fwrite($handle, '[SKU empty] :: ' . implode(' :: ', $row) . ' <br/>');
                print '[Sku empty] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

              if (!isset($row[1])) {
                fwrite($handle, '[Name empty] :: ' . implode(' :: ', $row) . ' <br/>');
                print '[Name empty] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

              if (!isset($row[2])) {
                fwrite($handle, '[sale-price empty] :: ' . implode(' :: ', $row) . ' <br/>');
                print '[sale-price empty] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

              if (!isset($row[3])) {
                fwrite($handle, '[manufacturer empty] :: ' . implode(' :: ', $row) . ' <br/>');
                print '[manufacturer empty] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

              if (!isset($row[4])) {
                fwrite($handle, '[manufacturer-part-number empty] :: ' . implode(' :: ', $row) . ' <br/>');
                print '[manufacturer-part-number empty] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

              if (!isset($row[5])) {
                fwrite($handle, '[upc empty] :: ' . implode(' :: ', $row) . ' <br/>');
                print '[upc empty] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

              if (!isset($row[6])) {
                fwrite($handle, '[ourCost empty] :: ' . implode(' :: ', $row) . ' <br/>');
                print '[ourCost empty] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

              // Skip existing sku
              if (UbsInventory::model()->findByAttributes(array('sku' => $row[0]))) {
//                fwrite($handle, '[SKU already exist] :: ' . implode(' :: ', $row) . ' <br/>');
//                print '[SKU already exists] :: ' . implode(' :: ', $row) . "\n";
                continue;
              }

//              $model = new UbsInventory;
//              $model->sku = $row[0];
//              $model->sku_name = $row[1];
//              $model->price = $row[2];
//              $model->mfg_name = $row[3];
//              $model->mfg_part_name = $row[4];
//              $model->upc = $row[5];
//              $model->vprice = $row[6];
//              $model->isCalculated = 1; // bypass
//
//              if (!$model->insert()) {
//                fwrite($handle, '[SAVE errors] :: ' . implode(' :: ', $model->errors) . ' <br/>' . implode(' :: ', $row) . '<br/>');
//              }
              $values = array_map(function($item) {
                return Yii::app()->db->quoteValue($item);
              }, $row);

              $records[] = '(' . implode(',', $values) . ')';

              if (count($records) == 10000) {
                $sql = 'INSERT INTO {{ubs_inventory}} (`sku`, `sku_name`, `price`, `mfg_name`, `mfg_part_name`, `upc`, `vprice`) VALUES ';
                $sql .= implode(',', $records);
                $cmd = Yii::app()->db->createCommand($sql);
                $cmd->execute();
                fwrite($handle, '[NEW ITEMS added] :: ' . count($records) . '<br/>');
                print '[NEW ITEMS added] :: ' . count($records) . "\n";
                $records = array();
              }

            } // while

            if (!empty($records)) {
              $sql = 'INSERT INTO {{ubs_inventory}} (`sku`, `sku_name`, `price`, `mfg_name`, `mfg_part_name`, `upc`, `vprice`) VALUES ';
              $sql .= implode(',', $records);
              $cmd = Yii::app()->db->createCommand($sql);
              $cmd->execute();
              fwrite($handle, '[NEW ITEMS added] :: ' . count($records) . '<br/>');
              print '[NEW ITEMS added] :: ' . count($records) . "\n";
              $records = array();
            }
          }
        } catch (Exception $e) {
          fwrite($handle, '[Exception Error] :: ' . $e->__toString() . '<br/>');
          print '[Exception Error] :: ' . $e->__toString();
        }
        fwrite($handle, '<hr><h3>DONE!!!</h3>');
        fclose($handle);
        fclose($csv);
    }
}