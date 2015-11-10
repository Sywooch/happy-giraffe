<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__answers".
 *
 * The followings are the available columns in table 'qa__answers':
 * @property string $id
 * @property string $text
 * @property string $questionId
 * @property string $authorId
 * @property string $dtimeCreate
 * @property string $dtimeUpdate
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 */
class QaAnswer extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__answers';
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
			'question' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaQuestions', 'questionId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
			'questionId' => 'Question',
			'authorId' => 'Author',
			'dtimeCreate' => 'Dtime Create',
			'dtimeUpdate' => 'Dtime Update',
		);
	}

	public function behaviors()
	{
		return array(
			'softDelete' => array(
				'class' => 'site.common.behaviors.SoftDeleteBehavior',
				'removeAttribute' => 'isRemoved',
			),
			'HTimestampBehavior' => array(
				'class' => 'HTimestampBehavior',
				'createAttribute' => 'dtimeCreate',
				'updateAttribute' => 'dtimeUpdate',
			),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaAnswer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
