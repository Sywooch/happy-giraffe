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
 * @property string $isRemoved
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 *
 * @property \site\frontend\components\api\models\User $user
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
			'question' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaQuestion', 'questionId'),
		);
	}

	public function apiRelations()
	{
		return array(
			'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'userId'),
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
			'AuthorBehavior' => array(
				'class' => 'site\common\behaviors\AuthorBehavior',
				'attr' => 'authorId',
			),
		);
	}

	public function save($runValidation = true, $attributes = null)
	{
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

	protected function updateAnswersCount($n)
	{
		$this->question->saveCounters(array('answersCount' => $n));
	}

	public function user($userId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.authorId', $userId);
		return $this;
	}

	public function orderDesc()
	{
		$this->getDbCriteria()->order = $this->tableAlias . '.dtimeCreate DESC';
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
	 * @return QaAnswer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
