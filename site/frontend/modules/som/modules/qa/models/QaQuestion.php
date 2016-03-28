<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__questions".
 *
 * The followings are the available columns in table 'qa__questions':
 * @property int $id
 * @property string $title
 * @property string $text
 * @property bool $sendNotifications
 * @property int $categoryId
 * @property int $consultationId
 * @property int $authorId
 * @property int $dtimeCreate
 * @property int $dtimeUpdate
 * @property string $url
 * @property bool $isRemoved
 * @property double $rating
 * @property int $answersCount
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaConsultation $consultation
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer[] $answers
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer $lastAnswer
 *
 * @property \site\frontend\components\api\models\User $user
 */
class QaQuestion extends \HActiveRecord
{
	public $sendNotifications = true;

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

			// категория
			array('categoryId', 'default', 'value' => null),
			array('categoryId', 'exist', 'attributeName' => 'id', 'className' => 'site\frontend\modules\som\modules\qa\models\QaCategory', 'except' => 'consultation'),

			// консультация
			array('consultationId', 'required', 'on' => 'consultation'),
			array('consultationId', 'exist', 'attributeName' => 'id', 'className' => 'site\frontend\modules\som\modules\qa\models\QaConsultation', 'on' => 'consultation'),
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
			'category' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaCategory', 'categoryId'),
			'answers' => array(self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'questionId'),
			'lastAnswer' => array(self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'questionId', 'scopes' => 'orderDesc'),
		);
	}

	public function apiRelations()
	{
		return array(
			'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'authorId', 'params' => array('avatarSize' => 72)),
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
			'sendNotifications' => 'Получать уведомления об ответах',
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
			'CacheDelete' => array(
				'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
			),
			/*'PushStream' => array(
				'class' => \site\frontend\modules\api\ApiModule::PUSH_STREAM,
			),*/
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
			'purified' => array(
				'class' => 'site.common.behaviors.PurifiedBehavior',
				'attributes' => array('text'),
				'options' => array(
					'AutoFormat.Linkify' => true,
				),
			),
		);
	}

	public function unanswered()
	{
		$this->getDbCriteria()->addCondition($this->tableAlias . '.answersCount = 0');
		return $this;
	}

	public function orderRating()
	{
		$this->getDbCriteria()->order = $this->tableAlias . '.rating DESC';
		return $this;
	}

	public function orderDesc()
	{
		$this->getDbCriteria()->order = $this->tableAlias . '.dtimeCreate DESC';
		return $this;
	}

	public function category($categoryId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.categoryId', $categoryId);
		return $this;
	}

	public function consultation($consultationId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.consultationId', $consultationId);
		return $this;
	}

	public function notConsultation()
	{
		$this->getDbCriteria()->addCondition($this->tableAlias . '.consultationId IS NULL');
		return $this;
	}

	public function user($userId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.authorId', $userId);
		return $this;
	}

	public function defaultScope()
	{
		$t = $this->getTableAlias(false, false);
		return array(
			'condition' => $t . '.isRemoved = 0',
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

	public function canBeAnsweredBy($userId)
	{
		if (! $this->isFromConsultation()) {
			return $this->authorId != $userId;
		} else {
			return QaConsultant::model()->exists('userId = :userId AND consultationId = :consultationId', array(
				':userId' => $userId,
				':consultationId' => $this->consultationId,
			));
		}
	}

	public function isFromConsultation()
	{
		return $this->consultationId !== null;
	}
}
