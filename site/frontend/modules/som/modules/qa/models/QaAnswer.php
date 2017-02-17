<?php
namespace site\frontend\modules\som\modules\qa\models;

use site\common\behaviors\AuthorBehavior;
use site\frontend\modules\notifications\behaviors\ContentBehavior;
use site\frontend\modules\som\modules\qa\behaviors\ClosureTableBehavior;
use site\frontend\modules\som\modules\qa\behaviors\AnswerCometBehavior;
use site\frontend\modules\som\modules\qa\behaviors\NotificationBehavior;
use site\frontend\modules\som\modules\qa\behaviors\QaBehavior;
use site\frontend\modules\som\modules\qa\components\QaManager;
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
 * @property bool $isPublished
 * @property int $votesCount
 * @property bool $isBest
 * @property int $root_id
 *
 * @property-read bool $isTimeoutExpired
 *
 * @property-read NotificationBehavior $notificationBehavior
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaQuestion $question
 * @property \User $author
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswerVote[] $votes
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer $root
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer[] $children
 * @property \site\frontend\modules\som\modules\qa\behaviors\ClosureTableBehavior $CTBehavior
 *
 * @property \site\frontend\components\api\models\User $user
 */
class QaAnswer extends \HActiveRecord implements \IHToJSON
{
    /**
     * @var integer PUBLISHED Статус опубликованного ответа
     * @author Sergey Gubarev
     */
    const PUBLISHED = 1;

    /**
     * @var integer NOT_REMOVED Статус неудаленного ответа
     * @author Sergey Gubarev
     */
    const NOT_REMOVED = 0;

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
     * @return bool
     */
    public function getIsTimeoutExpired()
    {
        return $this->dtimeCreate <= time() - 60 * QaAnswer::MINUTES_AWAITING_PUBLISHED;
    }

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
        return [
            ['questionId', 'safe'],
            ['text', 'required'],
            ['isRemoved', 'default', 'value' => 0],
            ['votesCount', 'default', 'value' => 0],
            ['isBest', 'default', 'value' => 0],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'question' => [self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaQuestion', 'questionId', 'joinType' => 'INNER JOIN'],
            'author' => [self::BELONGS_TO, get_class(\User::model()), 'authorId'],
            'category' => [self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaCategory', ['categoryId' => 'id'], 'through' => 'question'],
            'tag' => [self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaTag', ['tag_id' => 'id'], 'through' => 'question'],
            'votes' => [self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaAnswerVote', 'answerId'],
            'root' => [self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'root_id', 'joinType' => 'inner join'],
            'children' => [self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'root_id']
        ];
    }

    public function apiRelations()
    {
        return [
            'user' => ['site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'authorId', 'params' => ['avatarSize' => 40]],
        ];
    }

    /**
     * Получить ID comet-канала
     *
     * @return string
     * @author Sergey Gubarev
     */
    public function channelId()
    {
        $idParts = [
            QaManager::getQuestionChannelId($this->questionId),
            'answer' . $this->id,
            QaQuestion::COMET_CHANNEL_ID_EDITED_PREFIX
        ];

        return implode('_', $idParts);
    }

    /**
     * @return \site\frontend\modules\som\modules\qa\models\QaAnswer[]
     * @deprecated use descendants scope ($answer->descendants()->findAll())
     */
    public function getChilds()
    {
        $matchedAnswers = $this->children;

        foreach ($matchedAnswers as $answer) {
            if (!empty($answer->children)) {
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
        return [
            'id' => 'ID',
            'text' => 'Text',
            'questionId' => 'Question',
            'authorId' => 'Author',
            'dtimeCreate' => 'Dtime Create',
            'dtimeUpdate' => 'Dtime Update',
        ];
    }

    public function behaviors()
    {
        return [
            'CacheDelete' => [
                'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
            ],
            'PushStream' => [
                'class' => \site\frontend\modules\api\ApiModule::PUSH_STREAM,
            ],
            'softDelete' => [
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
                'removeAttribute' => 'isRemoved',
            ],
            'HTimestampBehavior' => [
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => 'dtimeUpdate',
            ],
            'AuthorBehavior' => [
                'class' => 'site\common\behaviors\AuthorBehavior',
                'attr' => 'authorId',
            ],
            'purified' => [
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => ['text'],
                'options' => [
                    'AutoFormat.Linkify' => true,
                ],
            ],
            'RatingBehavior' => [
                'class' => 'site\frontend\modules\som\modules\qa\behaviors\RatingBehavior',
            ],
            'notificationBehavior' => [
                'class' => 'site\frontend\modules\som\modules\qa\behaviors\NotificationBehavior',
            ],
            'QaBehavior' => [
                'class' => QaBehavior::class
            ],
            'CTBehavior' => [
                'class'             => ClosureTableBehavior::class,
                'closureTableName'  => 'qa__answers_tree',
                'childAttribute'    => 'descendant_id',
                'parentAttribute'   => 'ancestor_id'
            ],
            'AnswerCometBehavior' => [
                'class' => AnswerCometBehavior::class
            ]
        ];
    }

    /**
     * {@inheritDoc}
     * @see CActiveRecord::beforeSave()
     */
    protected function beforeSave()
    {
        $parentResult = parent::beforeSave();

        if ($this->isAdditional()) {
            return $this->authorId == $this->question->authorId;
        }

        return $parentResult;
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

    /**
     * @inheritdoc
     */
    public function afterSave()
    {
        if ($this->isNewRecord)
        {
            $this->updateAnswersCount(1);

            if (!is_null($this->root_id))
            {
                $targetModel = self::model()->findByPk($this->root_id);
                $targetModel->append($this);
            }
            else
            {
                $this->markAsRoot($this->id);
            }
        }
        else
        {
            if ($this->question->category->isPediatrician())
            {
                $channelId = QaManager::getQuestionChannelId($this->question->id);

                $this->refresh();

                $resp = [
                    'status'    => true,
                    'answerId'  => $this->id,
                    'text'      => $this->text,
                    'isRoot'    => is_null($this->root_id)
                ];

                (new \CometModel())->send($channelId, $resp, \CometModel::MP_QUESTION_ANSWER_FINISH_EDITED);

                QaManager::deleteAnswerObjectFromCollectionByAttr(['answerId' => $this->id]);
            }
        }

        parent::afterSave();
    }

    public function afterSoftDelete()
    {
        if ($this->isAdditional())
        {
            $channelId = \site\frontend\modules\specialists\modules\pediatrician\components\QaManager::getQuestionChannelId($this->questionId);

            (new \CometModel())->send($channelId, null, \CometModel::QA_REMOVE_ANSWER);
        }

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
        $this->question->saveCounters(['answersCount' => $n]);
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
        $this->getDbCriteria()->mergeWith(['with' => [
            'question' => [
                'joinType' => 'INNER JOIN',
                'scopes' => ['category' => [$categoryId]],
            ],
        ]]);

        return $this;
    }

    public function byRootId($rootId)
    {
        $this->getDbCriteria()->addColumnCondition(['root_id' => $rootId]);

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
        $criteria->with = ['question'];
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
        $isDoctor = $user->isSpecialistOfGroup(SpecialistGroup::DOCTORS);
        $isAnswerFromDoctor = $this->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS);
        $isRootFromDoctor = $isAnswerFromDoctor;

        if ($this->root_id != null) {
            $isRootFromDoctor = $this->root->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS);
        }

        // уточняющий вопрос
        if ($isAnswerFromDoctor && $this->root_id == null && !$this->children) {
            return $user->id == $this->question->authorId && !$isDoctor;
        }

        // ответ на уточняющий вопрос
        if (!$isAnswerFromDoctor && $this->root_id != null && count($this->root->children) == 1 && $isRootFromDoctor) {
            return $user->id == $this->root->authorId && $isDoctor;
        }

        //комментарий от автора вопроса
        if (!$isAnswerFromDoctor && $this->root_id == null && count($this->children) == 0) {
            return $user->id == $this->question->authorId;
        }

        //ответ в ветку комментариев
        if (!$isAnswerFromDoctor && $this->root_id != null && count($this->children) == 0 && !$isRootFromDoctor) {
            return $this->authorId != $user->id && !$isDoctor;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isAdditional()
    {
        return !$this->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS) && $this->root_id != null && $this->root->author->isSpecialist;
    }

    /**
     * @return bool
     */
    public function isAnswerToAdditional()
    {
        return $this->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS) && $this->root_id != null;
    }

    /**
     * @return bool
     */
    public function isCommentToBranch()
    {
        return !$this->authorIsSpecialist() && $this->root_id != null && !$this->root->author->isSpecialist;
    }

    /**
     * @return self
     */
    public function onlyPublished()
    {
        $this->getDbCriteria()->addColumnCondition(['isPublished' => self::PUBLISHED]);

        return $this;
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
     * @param int $userId
     *
     * @return QaAnswer
     */
    public function excludeAdditionalRoots($userId)
    {
        $this->getDbCriteria()->addCondition("(select count(*) from qa__answers as a where a.questionId = {$this->tableAlias}.questionId and a.authorId = {$userId} and a.isRemoved = 0) < 2");

        return $this;
    }

    /**
     * @param int $userId
     *
     * @return QaAnswer
     */
    public function excludeByQuestionsAuthor($userId)
    {
        if (!isset($this->getDbCriteria()->with['question'])) {
            $this->getDbCriteria()->with[] = 'question';
        }

        $this->getDbCriteria()->addCondition("question.authorId != {$userId}");

        return $this;
    }

    public function descendantsCount($forMe = FALSE)
    {
        $condition = 'isPublished=' . QaAnswer::PUBLISHED;

        if (\Yii::app() instanceof \CConsoleApplication)
        {
            $user = \Yii::app()->user;

            if (!$user->isGuest && $forMe)
            {
                $condition = ' AND authorId=' . \Yii::app()->user->id;
            }
        }

        return $this->descendants()->count($condition);
    }

    /**
     * @return QaAnswer
     */
    public function specialists()
    {
        if (!isset($this->getDbCriteria()->with['author'])) {
            $this->getDbCriteria()->with[] = 'author';
        }
        $this->getDbCriteria()->addCondition("author.specialistInfo is not null and author.specialistInfo != ''");
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

        $user = \Yii::app()->user;

        if ((!$user->isGuest && !$user->model->isSpecialist) || $this->isPublished)
        {
            $status = FALSE;
        }

        return compact('status', 'diffMins');
    }

    public function defaultScope()
    {
        $t = $this->getTableAlias(false, false);

        return [
            'condition' => $t . '.isRemoved = 0',
        ];
    }

    public function toJSON()
    {
        $isVoted    = [];
        $canEdit    = FALSE;
        $canRemove  = FALSE;
        $canVote    = FALSE;

        if (!(\Yii::app() instanceof \CConsoleApplication))
        {
            $isVoted    = QaAnswerVote::model()->byAnswer($this->id)->user(\Yii::app()->user->id)->findAll();
            $canEdit    = \Yii::app()->user->checkAccess('updateQaAnswer', array('entity' => $this));
            $canRemove  = \Yii::app()->user->checkAccess('removeQaAnswer', array('entity' => $this));
            $canVote    = \Yii::app()->user->checkAccess('voteAnswer', array('entity' => $this));
        }

        return [
            'id'                                => (int) $this->id,
            'authorId'                          => (int) $this->authorId,
            'dtimeCreate'                       => (int) $this->dtimeCreate,
            'text'                              => $this->purified->text,
            'votesCount'                        => (int) $this->votesCount,
            'user'                              => $this->user->formatedForJson(),
            'isRemoved'                         => (bool) $this->isRemoved,
            'bySpecialist'                      => $this->authorIsSpecialist(),
            'rootId'                            => $this->root_id,
            'canEdit'                           => $canEdit,
            'canRemove'                         => $canRemove,
            'canVote'                           => $canVote,
            'isVoted'                           => !empty($isVoted),
            'question'                          => $this->question->toJSON(),
            'countChildAnswers'                 => (int) $this->descendantsCount(FALSE),
            'isAdditional'                      => $this->isAdditional(),
            'isAnswerToAdditional'              => $this->isAnswerToAdditional(),
            'isEditing'                         => QaManager::isAnswerEditing((int) $this->id)
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QaAnswer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return boolean
     */
    public function authorIsSpecialist()
    {
        return $this->author->isSpecialist;
    }

    public function getLeaf()
    {
        return empty($this->children);
    }

    /**
     * {@inheritDoc}
     * @see CActiveRecord::saveCounters()
     */
    public function saveCounters($counters)
    {
        $parentResult = parent::saveCounters($counters);

        if ($parentResult && array_key_exists('votesCount', $counters))
        {
            $this->updateActivity();
        }

        return $parentResult;
    }

}
