
<?php



echo '<table class="table table-bordered" style="width:400px;">';

foreach($directory as $id=>$directory):

	$filename = preg_replace("/.+[:]*\\d+\\s/", "", $directory);
	$temp = explode(" ", $filename);
	$filename = $temp[0];
	if($filename == '.')
		continue;
	if($filename == '..')
		$filename = str_replace($dir, '', $filename);
	$isDir = preg_match("/^[dl]/", $directory)?true:false;
		echo '<tr>';
		echo '<td>';
		if($isDir)
			echo 'dir';
		else
			echo 'file';
		echo '</td>';
		echo '<td>';
		if($isDir)
			echo '<a href="/index.php/supplier/ftpbrowser/id/'.$importModel->id.'/dir/'. base64_encode($dir.'/'.$filename).'">'.$filename.'</a>';
		else
			echo $filename;
		
		echo '</td>';

	
	echo '<tr>';
endforeach;
echo '</table>';



function ftp_is_dir($ftp, $directory) {
  if ($ftp->chdir(basename($directory))) {
    $ftp->chdir('..');
    return true;
  } else {
    return false;
  }
}

?>

