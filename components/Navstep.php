<?php
class Navstep
{
	private $_supplierModel;
	private $_navModel;
	private $_link;
	
	function __construct($supplierid)
	{
		$this->_navModel = new NavSupplier;
	    if ($supplier = Supplier::model()->findByPk($supplierid)) {
	      	if (!$this->_navModel = NavSupplier::model()->bySupplierId($supplier->id)->find()) {
	        	$this->_navModel = new NavSupplier;
				$this->_navModel->supplier_name = $supplier->name;
			}
	    }
	    

	    if(empty($_REQUEST['save-only']))
			$this->run();
	    $this->_navModel->attributes = Yii::app()->request->getPOST('NavSupplier');
		$this->_navModel->save();
	}
	
	function run()
	{
		Yii::import('ext.simpletest.browser', true);
		


      $browser = &new SimpleBrowser();
      $browser->get($this->_navModel->url);

      if ($this->_navModel->username && $this->_navModel->password) {
        $browser->setField($this->_navModel->username_label, $this->_navModel->username);
        $browser->setField($this->_navModel->password_label, $this->_navModel->password);
        $browser->click($this->_navModel->logon_label);
      }

      for ($i=2; $i<=10; $i++) {
        $step = "step{$i}_label";
        $clickableLink = $this->_navModel->{$step};
        \Yii::log($clickableLink, CLogger::LEVEL_ERROR, __CLASS__);
        if ($clickableLink)
          $browser->click($clickableLink);
      }

      $link = $browser->getLink($this->_navModel->download_link);

      if ($link == false)
        throw new CHttpException(404, 'Unable to browse link.');
      $downloadLink = $link->getScheme() . '://' . $link->getHost() . $link->getPath(). $link->getEncodedRequest();
      
      Yii::log($downloadLink, CLogger::LEVEL_ERROR, __CLASS__);
      $uploadedFileName = md5($downloadLink.uniqid("test"));
      Yii::log($uploadedFileName, CLogger::LEVEL_ERROR, __CLASS__);
      $uploadedFilePath = Yii::app()->basePath.DIRECTORY_SEPARATOR.'../upload'.DIRECTORY_SEPARATOR.$uploadedFileName;
      $result = file_put_contents($uploadedFilePath, fopen($downloadLink, 'r'));

      if ($result == false)
        throw new CHttpException(404, 'Unable to download file.');

      $this->_link =  Yii::app()->getBaseUrl(true) . '/upload/' . $uploadedFileName;
		
	}
	
	public function getLink()
	{
		return $this->_link;
	}
}
?>