<?php

/**
 * This is the model class for table "mail__templates".
 *
 * The followings are the available columns in table 'mail__templates':
 * @property string $id
 * @property string $title
 * @property string $action
 * @property string $subject
 * @property string $body
 */
class MailTemplate extends CActiveRecord
{
    public static $replace_model;

    /**
     * Returns the static model of the specified AR class.
     * @return MailTemplate the static model class
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'mail__templates';
	}

	public function rules()
	{
		return array(
			array('title, action, subject, body', 'required'),
            array('title, action', 'length', 'max'=>255),
			array('subject', 'length', 'max'=>100),
			array('id, title, action, subject, body', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название шаблона',
			'action' => 'Ключ действия',
            'subject' => 'Тема письма',
			'body' => 'Тело письма',
		);
	}

    public function findByAction($action)
    {
        return $this->findByAttributes(array('action' => $action));
    }

    public function parse($model, $attribute)
    {
        MailTemplate::$replace_model = $model;
        return preg_replace_callback('!\{\{(\w+)\}\}!', 'Mailtemplate::replace_by_model', $this->{$attribute});
    }

    public static function replace_by_model($matches)
    {
        if(isset(self::$replace_model->{$matches[1]}))
            return self::$replace_model->{$matches[1]};
        return $matches[0];
    }

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('action',$this->action,true);
        $criteria->compare('subject',$this->body,true);
		$criteria->compare('body',$this->body,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}