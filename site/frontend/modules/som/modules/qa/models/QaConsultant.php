<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__consultations_consultants".
 *
 * The followings are the available columns in table 'qa__consultations_consultants':
 * @property int $id
 * @property int $consultationId
 * @property string $name
 * @property string $title
 * @property int $userId
 * @property string $text
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaConsultation $consultation
 */
class QaConsultant extends \HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__consultations_consultants';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

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
			'consultation' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaConsultation', 'consultationId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'consultationId' => 'Consultation',
			'name' => 'Name',
			'title' => 'Title',
			'userId' => 'User',
			'text' => 'Text',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaConsultant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
