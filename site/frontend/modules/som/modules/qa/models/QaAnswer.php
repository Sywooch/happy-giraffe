<?php
namespace site\frontend\modules\som\modules\qa\models;
use site\frontend\modules\som\modules\qa\behaviors\NotificationBehavior;
use site\frontend\modules\specialists\models\SpecialistGroup;
use site\frontend\modules\specialists\models\SpecialistProfile;

/**
 * This is the model class for table "qa__answers".
 *
 * The followings are the available columns in table 'qa__answers':
 * @property int $id
 * @property string $text
 * @property int $questionId
 * @property int $authorId
 * @property int $dtimeCreate
 * @property int $dtimeUpdate
 * @property bool $isRemoved
 * @property int $votesCount
 * @property bool $isBest
 * @property int $root_id
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 * @property \User $author
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswerVote[] $votes
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer $root
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer[] $children
 *
 * @property \site\frontend\components\api\models\User $user
 */
class QaAnswer extends \HActiveRecord implements \IHToJSON
{
    /**
     * Диапазон времени (минут), в течени которого специалист может редактировать свой ответ
     *
     * @var integer
     * @author Sergey Gubarev
     */
    const MINUTES_FOR_EDITING = 5;

    /**
     * Время (минут) задержки публикации ответа специалистом на сайте и в сервисе "Мой педиатр"
     *
     * @var integer
     * @author Sergey Gubarev
     */
    const MINUTES_AWAITING_PUBLISHED = 5;


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
			array('questionId', 'safe'),
			array('text', 'required'),
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
			'question' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaQuestion', 'questionId', 'joinType' => 'INNER JOIN'),
			'author' => array(self::BELONGS_TO, get_class(\User::model()), 'authorId'),
			'category' => array(self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaCategory', array('categoryId' => 'id'), 'through' => 'question'),
			'tag' => array(self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaTag', array('tag_id' => 'id'), 'through' => 'question'),
			'votes' => array(self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaAnswerVote', 'answerId'),
			'root' => [self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'root_id', 'joinType' => 'inner join'],
			'children' => [self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'root_id'],
		);
	}

	public function apiRelations()
	{
		return array(
			'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'authorId', 'params' => array('avatarSize' => 40)),
		);
	}

	/**
	 * @return \site\frontend\modules\som\modules\qa\models\QaAnswer[]
	 */
	public function getChilds()
	{
		$matchedAnswers = $this->children;

		foreach ($matchedAnswers as $answer)
		{
			if (!empty($answer->children))
			{
				$matchedAnswers = array_merge($matchedAnswers, $answer->getChilds());
			}

		}

		return $matchedAnswers;

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
			'CacheDelete' => array(
				'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
			),
 			'PushStream' => array(
 				'class' => \site\frontend\modules\api\ApiModule::PUSH_STREAM,
 			),
			'softDelete' => array(
				'class' => 'site.common.behaviors.SoftDeleteBehavior',
				'removeAttribute' => 'isRemoved',
			),
			'HTimestampBehavior' => array(
				'class' => 'HTimestampBehavior',
				'createAttribute' => 'dtimeCreate',
				'updateAttribute' => 'dtimeUpdate',
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
			'notificationBehavior' => array(
				'class' => NotificationBehavior::class,
			),
			'RatingBehavior' => array(
				'class' => 'site\frontend\modules\som\modules\qa\behaviors\RatingBehavior',
			),
		    \site\frontend\modules\som\modules\qa\behaviors\QaBehavior::class,
		);
	}

	public function save($runValidation = true, $attributes = null)
	{
		if (\Yii::app()->db->getCurrentTransaction() !== null) {
			return parent::save($runValidation, $attributes);
		}

		$transaction = $this->dbConnection->beginTransaction();
		try {
			$success = parent::save($runValidation, $attributes);
			$transaction->commit();
		} catch (\Exception $e) {
			$transaction->rollback();
			return false;
		}
		return $success;
	}

	/**
	 * {@inheritDoc}
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
        if ($this->isAdditional())
        {
            return $this->authorId == $this->question->authorId;
        }

        return parent::beforeSave();
	}

	public function softDelete()
	{
		$transaction = $this->dbConnection->beginTransaction();
		try {
			$success = $this->softDelete->softDelete();
			$transaction->commit();
		} catch (\Exception $e) {
			$transaction->rollback();
			return false;
		}
		return $success;
	}

	public function afterSave()
	{
		if ($this->isNewRecord) {
			$this->updateAnswersCount(1);
		}
		parent::afterSave();
	}

	public function afterSoftDelete()
	{
		$this->updateAnswersCount(-1);
		$this->softDelete->afterSoftDelete();
	}

	public function afterSoftRestore()
	{
		$this->updateAnswersCount(1);
		$this->softDelete->afterSoftRestore();
	}

	protected function updateAnswersCount($n)
	{
		$this->question->saveCounters(array('answersCount' => $n));
	}

	public function user($userId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.authorId', $userId);
		return $this;
	}

	public function question($questionId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.questionId', $questionId);
		return $this;
	}

	public function orderDesc()
	{
		$this->getDbCriteria()->order = $this->tableAlias . '.dtimeCreate DESC';
		return $this;
	}

	public function category($categoryId)
	{
		$this->getDbCriteria()->mergeWith(array('with'=>array(
			'question' => array(
				'joinType' => 'INNER JOIN',
				'scopes' => array('category' => array($categoryId)),
			),
		)));
		return $this;
	}

	public function notConsultation()
	{
		$qTable = QaQuestion::model()->tableName();
		$t = $this->tableAlias;
		$criteria = $this->getDbCriteria();
		$criteria->join = " JOIN $qTable q ON q.id = $t.questionId";
		$criteria->addCondition('q.consultationId IS NULL');
		return $this;
	}

	public function checkQuestionExiststance()
	{
		$criteria = new \CDbCriteria();
		$criteria->with = array('question');
		$criteria->addCondition('question.isRemoved = 0');
		$this->getDbCriteria()->mergeWith($criteria);
		return $this;
	}

	/**
	 * @param \User $user
	 *
	 * @return bool
	 */
	public function canBeAnsweredBy($user)
	{
		// уточняющий вопрос
		if ($this->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS) && $this->root_id == null && !$this->children) {
			return $user->id == $this->question->authorId && !$user->isSpecialistOfGroup(SpecialistGroup::DOCTORS);
		}

		// ответ на уточняющий вопрос
		if (!$this->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS) && $this->root_id != null && count($this->root->children) == 1) {
			return $user->id == $this->root->authorId && $user->isSpecialistOfGroup(SpecialistGroup::DOCTORS);
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function isAdditional()
	{
		return !$this->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS) && $this->root_id != null;
	}

	/**
	 * @return bool
	 */
	public function isAnswerToAdditional()
	{
		return $this->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS) && $this->root_id != null;
	}

	/**
	 * @param int $tagId
	 *
	 * @return QaAnswer
	 */
	public function byTag($tagId)
	{
		if (!isset($this->getDbCriteria()->with['tag'])) {
			$this->getDbCriteria()->with[] = 'tag';
		}

		$this->getDbCriteria()->compare('tag.id', $tagId);

		return $this;
	}

	/**
	 * @param int $userId
	 *
	 * @return QaAnswer
	 */
	public function additionalToSpecialist($userId)
	{
		if (!isset($this->getDbCriteria()->with['root'])) {
			$this->getDbCriteria()->with[] = 'root';
		}

		$this->getDbCriteria()->compare('root.authorId', $userId);
		$this->getDbCriteria()->addCondition("not exists(select * from qa__answers as children where children.root_id = {$this->tableAlias}.id and children.isRemoved = 0)");

		return $this;
	}

	/**
	 * Доступен ли вопрос для редактирования авторизованному специалисту
	 *
	 * @return array
	 * @author Sergey Gubarev
	 */
	public function availableForEditing()
	{
	    $time = $this->dtimeUpdate ? $this->dtimeUpdate : $this->dtimeCreate;

	    $diffMins = floor((time() - $time) / 60);

	    $status = $diffMins < self::MINUTES_FOR_EDITING ? true : false;

	    return compact('status', 'diffMins');
	}

	public function defaultScope()
	{
		$t = $this->getTableAlias(false, false);
		return array(
			'condition' => $t . '.isRemoved = 0',
		);
	}

	public function toJSON()
	{
		return array(
			'id' => (int) $this->id,
			'authorId' => (int) $this->authorId,
			'dtimeCreate' => (int) $this->dtimeCreate,
			'text' => $this->purified->text,
			'votesCount' => (int) $this->votesCount,
			'user' => $this->user->formatedForJson(),
			'isRemoved' => (bool) $this->isRemoved,
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

	/**
	 * @return boolean
	 */
	public function authorIsSpecialist()
	{
	    return SpecialistProfile::model()->exists('id = :id', [':id' => $this->authorId]);
	}
}
