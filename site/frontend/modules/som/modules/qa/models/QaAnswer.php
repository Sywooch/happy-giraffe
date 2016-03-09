<?php
namespace site\frontend\modules\som\modules\qa\models;

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
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 *
 * @property \site\frontend\components\api\models\User $user
 */
class QaAnswer extends \HActiveRecord implements \IHToJSON
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
		);
	}

	public function apiRelations()
	{
		return array(
			'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'authorId', 'params' => array('avatarSize' => 40)),
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
			'CacheDelete' => array(
				'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
			),
			'NStream' => array(
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
			'text' => \CHtml::encode($this->text),
			'votesCount' => (int) $this->votesCount,
			'user' => $this->user,
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
}
