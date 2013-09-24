<?php
/**
 * Base ActiveRecord housing common methods/functions
 *
 * @author vojalf@gmail.com
 * @since 07.25.2013
 */
abstract class BaseAR extends CActiveRecord
{
  protected function afterValidate()
  {
    Yii::log(json_encode($this->getErrors()), CLogger::LEVEL_ERROR, __CLASS__);

    parent::afterValidate();
  }
  /**
   * Returns the fully qualified class name.
   *
   * @return string
   */
  public static function className()
  {
    return get_called_class();
  }

  /**
   * Filter record of the given field and values
   *
   * @param string $field
   * @param mixed $values
   * @param string $operator
   * @return self
   */
  protected function byFieldValues($field, $values, $operator = 'AND')
  {
    $criteria = $this->getDbCriteria();

    if (is_array($values))
      $criteria->addInCondition($field, $values, $operator);
    else
      $criteria->addColumnCondition(array($field => $values), 'AND', $operator);

    return $this;
  }
}