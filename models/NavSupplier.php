<?php

/**
 * This is the model class for table "{{nav_supplier}}".
 */
class NavSupplier extends BaseAR
{
  public $supplier_name;
  public $url;
  public $username;
  public $username_label;
  public $password;
  public $password_label;
  public $step2_label;
  public $step3_label;
  public $step4_label;
  public $step5_label;
  public $step6_label;
  public $step7_label;
  public $step8_label;
  public $step9_label;
  public $step10_label;
  public $download_link;
  public $logon_label;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Supplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{nav_supplier}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('supplier_id', 'required'),
			array('steps_meta','safe'),
      array('supplier_name, url, username, username_label, password, password_label,
      step2_label,step3_label,step4_label,step5_label,step6_label,step7_label,step8_label,
      step9_label,step10_label,logon_label, download_link', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
      'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
		);
	}

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return array(
      'url' => 'Step 1: Url',
      'step2_label' => 'Step 2: Clickable link',
      'step3_label' => 'Step 3: Clickable link',
      'step4_label' => 'Step 4: Clickable link',
      'step5_label' => 'Step 5: Clickable link',
      'step6_label' => 'Step 6: Clickable link',
      'step7_label' => 'Step 7: Clickable link',
      'step8_label' => 'Step 8: Clickable link',
      'step9_label' => 'Step 9: Clickable link',
      'step10_label' => 'Step 10: Clickable link',
    );
  }

  /**
   * @inheritdoc
   */
  protected function beforeValidate()
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition('name = :name');
    $criteria->params = array(':name' => $this->supplier_name);

    $this->supplier_id = Supplier::model()->find($criteria)->id;
//    $meta = $this->attributes;
//    unset($meta['id']);
//    unset($meta['steps_meta']);
//    unset($meta['supplier_id']);
    $this->steps_meta = json_encode(array(
      'url'            => $this->url,
      'username'       => $this->username,
      'username_label' => $this->username_label,
      'password'       => $this->password,
      'password_label' => $this->password_label,
      'step2_label'    => $this->step2_label,
      'logon_label'    => $this->logon_label,
      'step3_label'    => $this->step3_label,
      'step4_label'    => $this->step4_label,
      'step5_label'    => $this->step5_label,
      'step6_label'    => $this->step6_label,
      'step7_label'    => $this->step7_label,
      'step8_label'    => $this->step8_label,
      'step9_label'    => $this->step9_label,
      'step10_label'    => $this->step10_label,
      'download_link'    => $this->download_link,
    ));

    return parent::beforeValidate();
  }

  /**
   * @inheritdoc
   */
  protected function afterFind()
  {
    foreach (json_decode($this->steps_meta) as $property => $value) {
      $this->$property = $value;
    }

    $this->supplier_name = $this->supplier->name;

    parent::afterFind();
  }

  /**
   * Scope. Filter record by given supplier name
   *
   * @param string $value
   * @return self
   */
  public function bySupplierName($value)
  {
    $criteria = $this->getDbCriteria();
    $criteria->with = array(
      'supplier' => array(
        'join'      => 'INNER JOIN',
        'condition' => 'name = :name',
        'params'    => array(':name' => $value)
      )
    );

    return $this;
  }

  /**
   * Scope. Filter record by supplier id
   * @param int $value
   * @return self
   */
  public function bySupplierId($value)
  {
    return $this->byFieldValues('supplier_id', $value);
  }
}