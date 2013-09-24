<?php
class Export 
{
	function run($result, $columns = array())
	{

		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename='export.csv';" );
		header("Content-Transfer-Encoding: binary");

		$outstream = fopen("php://output", "w");
		fputcsv($outstream, $columns, ',', '"');
	
	
		foreach($result as $id=>$model){
			$data = array();
			foreach($columns as $cid=>$column)
				$data[] = $model->$column;
			fputcsv($outstream, $data, ',', '"');
		}
	}
}
?>