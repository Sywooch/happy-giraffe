<?php

/**
 * This is the model class for table "message_log".
 *
 * The followings are the available columns in table 'message_log':
 * @property string $dialog_id
 * @property string $user_id
 * @property string $text
 * @property string $created
 * @property integer $read_status
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property MessageDialog $dialog
 * @property User $user
 */
class MessageLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MessageLog the static model class
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
		return 'message_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dialog_id', 'required'),
			array('read_status, deleted', 'numerical', 'integerOnly'=>true),
			array('dialog_id, user_id', 'length', 'max'=>10),
            array('deleted', 'default', 'value'=>0),
            array('read_status', 'default', 'value'=>0),
			array('text, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dialog_id, user_id, text, created, read_status, deleted', 'safe', 'on'=>'search'),
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
			'dialog' => array(self::BELONGS_TO, 'MessageDialog', 'dialog_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dialog_id' => 'Dialog',
			'user_id' => 'User',
			'text' => 'Text',
			'created' => 'Created',
			'read_status' => 'Read Status',
			'deleted' => 'Deleted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('dialog_id',$this->dialog_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('read_status',$this->read_status);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterSave()
    {
        if ($this->isNewRecord)
            $this->created = date("Y-m-d H:i:s");
        return parent::afterSave();
    }

    static function NewMessage($dialog_id, $user_id, $text){
        $message = new MessageLog();
        $message->dialog_id = $dialog_id;
        $message->text = $text;
        $message->user_id = $user_id;
        $message->save();

        Yii::import('site.frontend.extensions.Dklab_Realplexor');
        $rpl = new Dklab_Realplexor("chat.happy-giraffe.com", "10010", "crm_");
        $rpl->send('Alpha', array(
            'text'=>$message->text,
            'user'=>$message->user_id,
            'time'=>date("H:i:s")
        ));
    }
}