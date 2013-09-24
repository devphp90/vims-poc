<?php
/**
 * Simple widjet for selecting page size of gridviews
 *
 * @author	Aruna Attanayake <aruna470@gmail.com>
 * @version 1.0
 */

class PageSize extends CWidget
{
	public $mPageSizeOptions = array(10=>10, 25=>25, 50=>50, 75=>75, 100=>100, 500=>500, 1000=>1000);
	public $mPageSize = 10;
	public $mGridId = '';
	public $mDefPageSize = 10;
	
	public function run()
	{
    Yii::log('before :: '.$this->mPageSize, CLogger::LEVEL_ERROR, __CLASS__);
    // Prior on session
		$this->mPageSize = $this->mPageSize ? $this->mPageSize : Yii::app()->user->getState('pageSize');
    // Else default
    $this->mPageSize = $this->mPageSize ? $this->mPageSize : $this->mDefPageSize;

    Yii::app()->user->setState('pageSize', $this->mPageSize);
    Yii::log('after :: '.$this->mPageSize, CLogger::LEVEL_ERROR, __CLASS__);

    $query = array();
    parse_str(Yii::app()->request->queryString, $query);
    unset($query['pageSize']);
    foreach ($query as $key => $item) {
      if (empty($item))
        unset($query[$key]);
      if (is_array($item)) {
        foreach ($item as $i => $value) {
          if (empty($value))
            unset($query[$key][$i]);
        }
      }
    }
//    $query['pageSize'] = "$(this).val()";//$this->mPageSize;
//    Yii::log(json_encode($query), CLogger::LEVEL_ERROR, __CLASS__);
//    Yii::log(http_build_query($query), CLogger::LEVEL_ERROR, __CLASS__);
		$data = str_replace('"', "'", rtrim(ltrim(json_encode($query), "{"), "}"));
    if (!empty($data))
      $data = ',' . $data;
    Yii::log($data, CLogger::LEVEL_ERROR, __CLASS__);

		echo 'Perpage: ';
		echo CHtml::dropDownList('pageSize', $this->mPageSize, $this->mPageSizeOptions,array(
				'onchange'=>"$.fn.yiiGridView.update('$this->mGridId',{ data: {pageSize: $(this).val()".$data."} })",
		));
	}
}
?>