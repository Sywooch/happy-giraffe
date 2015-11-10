<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__questions".
 *
 * The followings are the available columns in table 'qa__questions':
 * @property string $id
 * @property string $title
 * @property string $text
 * @property integer $sendNotifications
 * @property string $categoryId
 * @property string $authorId
 * @property string $dtimeCreate
 * @property string $dtimeUpdate
 * @property string $url
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 */
class QaQuestion extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, text', 'required'),
			array('title', 'length', 'max' => 150),
			array('text', 'length', 'max' => 1000),
			array('sendNotifications', 'boolean'),

			// консультация
			array('categoryId', 'required', 'except' => 'consultation'),
			array('categoryId', 'exist', 'attributeName' => 'id', 'className' => 'site\frontend\modules\som\modules\qa\models\QaCategory', 'except' => 'consultation'),
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
			'category' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaCategory', 'categoryId'),
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
			'text' => 'Text',
			'sendNotifications' => 'Send Notifications',
			'categoryId' => 'Category',
			'authorId' => 'Author',
			'dtimeCreate' => 'Dtime Create',
			'dtimeUpdate' => 'Dtime Update',
			'url' => 'Url',
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
			'UrlBehavior' => array(
				'class' => 'site\common\behaviors\UrlBehavior',
				'route' => 'som/qa/default/view',
				'params' => function($model) {
					return array(
						'id' => $model->id,
					);
				}
			),
			'AuthorBehavior' => array(
				'class' => 'site\common\behaviors\AuthorBehavior',
				'attr' => 'authorId',
			),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
