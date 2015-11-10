<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__categories".
 *
 * The followings are the available columns in table 'qa__categories':
 * @property string $id
 * @property string $title
 * @property string $consultationId
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaConsultation $consultation
 * @property \site\frontend\modules\som\modules\qa\models\QaQuestion[] $questions
 */
class QaCategory extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__categories';
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
			'questions' => array(self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaQuestion', 'categoryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'consultationId' => 'Consultation',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function simple()
	{
		$this->getDbCriteria()->addCondition('consultationId IS NULL');
		return $this;
	}
}
