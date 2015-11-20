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
 * @property string $rating
 * @property int $answersCount
 * @property string $isRemoved
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer[] $answers
 *
 * @property \site\frontend\components\api\models\User $user
 */
class QaQuestion extends \HActiveRecord
{
	private $_user;

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
			'answers' => array(self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'questionId'),
		);
	}

	public function apiRelations()
	{
		return array(
			'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'authorId'),
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
	 * @return array|mixed|null
	 * @throws \site\frontend\components\api\ApiException
	 * @todo сделать пакетную выборку
	 */
	public function getUser()
	{
		if (is_null($this->_user)) {
			$this->_user = \site\frontend\components\api\models\User::model()->query('get', array(
				'id' => (int) $this->authorId,
				'avatarSize' => \Avatar::SIZE_MEDIUM,
			));
		}

		return $this->_user;
	}
}
