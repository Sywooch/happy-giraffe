<?php

/**
 * This is the model class for table "mail__campaigns".
 *
 * The followings are the available columns in table 'mail__campaigns':
 * @property string $id
 * @property string $subject
 * @property string $body
 * @property string $author_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $author
 */
class MailCampaign extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mail__campaigns';
	}

	public function rules()
	{
		return array(
			array('subject, body, author_id', 'required'),
			array('subject', 'length', 'max'=>100),
			array('author_id', 'length', 'max'=>10),
            array('created', 'safe'),
		);
	}

	public function relations()
	{
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            )
        );
    }

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subject' => 'Subject',
			'body' => 'Body',
			'author_id' => 'Author',
			'created' => 'Created',
		);
	}
}