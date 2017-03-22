<?php

namespace site\frontend\modules\iframe\models;

/**
 * This is the model class for table "qa__consultations".
 *
 * The followings are the available columns in table 'qa__consultations':
 * @property int $id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $qaCategory
 * @property \site\frontend\modules\som\modules\qa\models\QaConsultant[] $qaConsultationsConsultants
 * @property int $questionsCount
 */
class QaConsultation extends \HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__consultations';
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
			'category' => array(self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaCategory', 'consultationId'),
			'consultants' => array(self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaConsultant', 'consultationId'),
			'questionsCount' => array(self::STAT, 'site\frontend\modules\som\modules\qa\models\QaQuestion', 'consultationId'),
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
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaConsultation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
