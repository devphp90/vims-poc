<?php

/**
 * This is the model class for table "{{nav_supplier}}".
 */
class SupplierStatusChange extends BaseAR
{
  const STATUS_ACTIVE  = 'active';
  const STATUS_INACTVE = 'inactive';

  public $edit_only;

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
		return '{{supplier_status_change}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('supplier_id, created_by', 'required'),
			array('current_status, from_on, to_on, comments, updated_by','safe'),
      array('created_at', 'default', 'value' => date('Y-m-d'), 'on' => 'insert'),
      array('updated_at', 'default', 'value' => date('Y-m-d'), 'on' => 'update'),
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
      'from_on' => 'From',
      'to_on' => 'To',
    );
  }

  /**
   * @inheritdoc
   */
  protected function beforeValidate()
  {
    // Fix formatting
    if ($this->from_on)
      $this->from_on = date('Y-m-d', strtotime($this->from_on));

    if ($this->to_on)
      $this->to_on = date('Y-m-d', strtotime($this->to_on));

    return parent::beforeValidate();
  }

  /**
   * Scope. Filter by supplier id
   *
   * @param $values
   * @return self
   */
  public function bySupplierId($values)
  {
    return $this->byFieldValues("{$this->tableAlias}.supplier_id", $values);
  }
}