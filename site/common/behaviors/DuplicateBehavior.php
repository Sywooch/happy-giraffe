<?php
/**
 * User: alexk984
 * Date: 21/01/13
 */
class DuplicateBehavior extends CActiveRecordBehavior
{
    public $attribute = 'title';
    public $error_text = 'Вы только что создали статью с таким названием';

    public function afterValidate($event)
    {
        parent::afterValidate($event);

        if (!$this->owner->isNewRecord)
            return true;


        $previous_model = $this->getLastModel();

        if ($previous_model === null)
            return true;

        $value1 = strip_tags($this->owner->getAttribute($this->attribute));
        $value2 = strip_tags($previous_model->getAttribute($this->attribute));

        if (trim($value1) != trim($value2))
            return true;
        else{
            $this->owner->addError($this->attribute, $this->error_text);
            return false;
        }
    }

    public function getLastModel()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created > :last_time';
        $criteria->params = array(
            ':last_time' => date("Y-m-d H:i:s", strtotime('-5 minutes'))
        );
        $criteria->compare('author_id', Yii::app()->user->id);
        $criteria->order = 'id desc';
        return CActiveRecord::model(get_class($this->owner))->find($criteria);
    }
}
