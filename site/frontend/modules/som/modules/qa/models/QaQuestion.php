<?php
namespace site\frontend\modules\som\modules\qa\models;

use site\frontend\modules\api\ApiModule;
use site\frontend\modules\notifications\behaviors\ContentBehavior;
use site\frontend\modules\som\modules\qa\behaviors\QaBehavior;
use site\frontend\modules\som\modules\qa\components\BaseAnswerManager;
use site\frontend\modules\som\modules\qa\components\CTAnswerManager;
use site\frontend\modules\som\modules\qa\components\ISubject;
use site\frontend\modules\specialists\models\SpecialistGroup;
use site\frontend\modules\specialists\modules\pediatrician\helpers\AnswersTree;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\som\modules\qa\components\QaObjectList;

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
 * @property int $tag_id
 * @property int $attachedChild
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaConsultation $consultation
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer[] $answers
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer $lastAnswer
 * @property \User $author
 * @property \site\frontend\modules\som\modules\qa\models\QaTag $tag
 *
 * @property \site\frontend\components\api\models\User $user
 *
 * @property-read BaseAnswerManager $answerManager
 * @property-read \PurifiedBehavior $purified
 */
class QaQuestion extends \HActiveRecord implements \IHToJSON, ISubject
{

    /**
     * @var integer NOT_REMOVED Статус неудаленного вопроса
     * @author Sergey Gubarev
     */
    const NOT_REMOVED = 0;

    public $sendNotifications = true;

    /**
     * @var boolean
     */
    private $_hasAnswerForSpecialist;

    /**
     * @inheritdoc
     */
    public function getSubjectId()
    {
        return $this->id;
    }

    public function __get($name)
    {
        if ($name == 'answersCount' && !is_null($this->category) && $this->category->isPediatrician()) {
            return $this->answerManager->getAnswersCount($this);
            return QaManager::getAnswersCountPediatorQuestion($this->id);
        }

        return parent::__get($name);
    }

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
        return [
            ['title', 'required'],
            ['title', 'length', 'max' => 150],
            ['text', 'length', 'max' => 1000],
            ['sendNotifications', 'boolean'],

            // категория
            ['categoryId', 'default', 'value' => null],
            ['categoryId', 'exist', 'attributeName' => 'id', 'className' => 'site\frontend\modules\som\modules\qa\models\QaCategory', 'except' => 'consultation'],

            // консультация
            ['consultationId', 'required', 'on' => 'consultation'],
            ['consultationId', 'exist', 'attributeName' => 'id', 'className' => 'site\frontend\modules\som\modules\qa\models\QaConsultation', 'on' => 'consultation'],

            // теги
            ['tag_id', 'required', 'on' => 'tag'],
            ['tag_id', 'tagValidator', 'on' => 'tag'],

            ['attachedChild', 'required', 'on' => 'attachedChild'],
            ['attachedChild', 'default', 'value' => null, 'on' => 'attachedChild'],
        ];
    }

    public function tagValidator($attribute, $params)
    {
        if ($this->$attribute && !QaTag::model()->byCategory($this->categoryId)->findByPk($this->$attribute)) {
            $this->addError($attribute, "Tag belongs to other category");
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'consultation' => [self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaConsultation', 'consultationId'],
            'category' => [self::BELONGS_TO, 'site\frontend\modules\som\modules\qa\models\QaCategory', 'categoryId'],
            'answers' => [self::HAS_MANY, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'questionId'],
            'lastAnswer' => [self::HAS_ONE, 'site\frontend\modules\som\modules\qa\models\QaAnswer', 'questionId', 'scopes' => 'orderDesc'],
            'tag' => [self::BELONGS_TO, get_class(QaTag::model()), 'tag_id'],
            'author' => [self::BELONGS_TO, \User::class, 'authorId'],
        ];
    }

    public function apiRelations()
    {
        return [
            'user' => ['site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'authorId', 'params' => ['avatarSize' => 72]],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'sendNotifications' => 'Получать уведомления об ответах',
            'categoryId' => 'Category',
            'authorId' => 'Author',
            'dtimeCreate' => 'Dtime Create',
            'dtimeUpdate' => 'Dtime Update',
            'url' => 'Url',
            'tag_id' => 'Тэг',
        ];
    }

    public function behaviors()
    {
        return [
            'CacheDelete' => [
                'class' => ApiModule::CACHE_DELETE,
            ],
            'PushStream' => [
                'class' => ApiModule::PUSH_STREAM,
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
            'UrlBehavior' => [
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => 'som/qa/default/view',
                'params' => function ($model) {
                    return [
                        'id' => $model->id,
                    ];
                },
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
            'notificationContentBehavior' => [
                'class' => ContentBehavior::class,
                'entityClass' => QaQuestion::class,
            ],
            QaBehavior::class,
        ];
    }

    public function unanswered()
    {
        $this->getDbCriteria()->addCondition($this->tableAlias . '.answersCount = 0');

        return $this;
    }

    public function orderRating()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.rating DESC, dtimeCreate DESC';

        return $this;
    }

    public function orderDesc()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.dtimeCreate DESC';

        return $this;
    }

    public function orderAsc()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.dtimeCreate ASC';

        return $this;
    }

    public function category($categoryId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.categoryId', $categoryId);

        return $this;
    }

    public function byTag($tagId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.tag_id', $tagId);

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

    /**
     * @return QaQuestion
     */
    public function withoutAnswers()
    {
        $this->getDbCriteria()->addCondition("(select count(*) from qa__answers a where a.questionId = {$this->tableAlias}.id and a.isRemoved = 0 and a.root_id is null) = 0");

        return $this;
    }

    public function defaultScope()
    {
        $t = $this->getTableAlias(false, false);

        return [
            'condition' => $t . '.isRemoved = 0',
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QaQuestion the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function canBeAnsweredBy($userId)
    {
        if (!$this->isFromConsultation()) {
            return $this->authorId != $userId && $this->checkAccessForSpecialist();
        } else {
            return QaConsultant::model()->exists('userId = :userId AND consultationId = :consultationId', [
                ':userId' => $userId,
                ':consultationId' => $this->consultationId,
            ]);
        }
    }

    /**
     * @param integer $userId
     * @return boolean
     */
    public function checkCustomAccessByAnswered($userId)
    {
        $profile = \Yii::app()->user->getModel()->specialistProfile;

        $dialog = $this->getSpecialistDialog();

        if ($this->authorId != $userId) {
            if (is_null($profile) || is_null($dialog)) {
                return true;
            }

            foreach ($dialog as $answer) {
                if ($answer->authorId == $profile->id) {
                    return is_null($this->getAnswersToAdditional()) && !is_null($this->getAdditionalAnswers());
                }
            }

            return false;
        }

        return is_null($this->getAnswersToAdditional()) && is_null($this->getAdditionalAnswers());
    }

    /**
     * @param integer $userId
     * @return boolean
     */
    public function checkAccessByViewQuestion($userId)
    {
        $profile = \Yii::app()->user->getModel()->specialistProfile;

        $dialog = $this->getSpecialistDialog();

        if (is_null($dialog) && !is_null($profile)) {
            return true;
        }

        if (is_null($profile) || !is_null($this->getAnswersToAdditional())) {
            return false;
        }

        foreach ($dialog as $answer) {
            if ($answer->authorId == $profile->id) {
                return !is_null($this->getAdditionalAnswers());
            }
        }

        return false;
    }

    /**
     * @return boolean
     */
    public function checkAccessForSpecialist()
    {
        $profile = \Yii::app()->user->getModel()->specialistProfile;

        if (is_null($profile)) {
            return true;
        }

        return $profile->authorizationIsDone();
    }

    public function isFromConsultation()
    {
        return $this->consultationId !== null;
    }

    /**
     * @return integer
     */
    public function answersUsersCount()
    {
        return count(array_unique(array_map(function ($value) {
            return $value->authorId;
        }, $this->answers)));
    }

    /**
     * @param int $userId
     *
     * @return QaQuestion
     */
    public function withoutUserAnswers($userId)
    {
        $this->getDbCriteria()->addCondition("not exists(select * from qa__answers a where a.questionId={$this->tableAlias}.id and a.authorId={$userId})");

        return $this;
    }

    /**
     * @return \site\frontend\modules\som\modules\qa\models\QaQuestion
     */
    public function next()
    {
        $this->getDbCriteria()->compare('dtimeCreate', '>' . $this->dtimeCreate);
        $this->orderAsc();
        $this->getDbCriteria()->limit = 1;

        return $this;
    }

    /**
     * @return \site\frontend\modules\som\modules\qa\models\QaQuestion
     */
    public function previous()
    {
        $this->getDbCriteria()->compare('dtimeCreate', '<' . $this->dtimeCreate);
        $this->orderDesc();
        $this->getDbCriteria()->limit = 1;

        return $this;
    }

	/**
	 * @return QaQuestion
	 */
	public function withoutSpecialistsAnswers()
	{
		$this->getDbCriteria()->addCondition("not exists(select * from qa__answers a where a.questionId={$this->tableAlias}.id and a.isRemoved = 0 and exists(select * from users u where u.id = a.authorId and u.specialistInfo is not null and u.specialistInfo != ''))");

		return $this;
	}

	/**
	 * {@inheritDoc}
	 * @see CActiveRecord::save()
	 */
	public function save($runValidation=true,$attributes=null)
	{
        $this->title = \CHtml::encode($this->title);

        return parent::save($runValidation, $attributes);
    }

    public function toJSON()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'authorId' => $this->authorId,
        ];
    }

    /**
     * @return boolean
     */
    public function hasAnswerForSpecialist()
    {
        if (!is_null($this->_hasAnswerForSpecialist)) {
            return $this->_hasAnswerForSpecialist;
        }

        $helper = new AnswersTree();
        $helper->init($this->getSpecialistDialog());

        $this->_hasAnswerForSpecialist = !is_null($helper->getCurrentAnswerForSpecialist());

        return $this->_hasAnswerForSpecialist;
    }

    /**
     * @return QaAnswer[]
     */
    public function getSpecialistDialog()
    {
        foreach ($this->answers as /*@var $answer QaAnswer */
                 $answer) {
            if ($answer->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS) && is_null($answer->root_id)) {
                $result = $answer->getChilds();
                array_push($result, $answer);

                return $result;
            }
        }
    }

    /**
     * @return NULL|\site\frontend\modules\som\modules\qa\models\QaAnswer[]
     */
    public function getAdditionalAnswers()
    {
        $dialog = $this->getSpecialistDialog();

        if (is_null($dialog)) {
            return null;
        }

        $additionalAnswers = [];

        foreach ($dialog as /*@var $answer QaAnswer */
                 $answer) {
            if ($answer->isAdditional()) {
                $additionalAnswers[] = $answer;
            }
        }

        return empty($additionalAnswers) ? null : $additionalAnswers;
    }

    /**
     * @return NULL|\site\frontend\modules\som\modules\qa\models\QaAnswer[]
     */
    public function getAnswersToAdditional()
    {
        $dialog = $this->getSpecialistDialog();

        if (is_null($dialog)) {
            return null;
        }

        $answersToAdditional = [];

        foreach ($dialog as /*@var $answer QaAnswer */
                 $answer) {
            if ($answer->isAnswerToAdditional()) {
                $answersToAdditional[] = $answer;
            }
        }

        return empty($answersToAdditional) ? null : $answersToAdditional;
    }

    /**
     * @param QaQuestion $question
     * @return static
     */
    public static function getNextQuestion(QaQuestion $question)
    {
        return static::model()->find([
            'condition' => 'dtimeCreate > :time',
            'order' => 'dtimeCreate ASC',
            'params' => [':time' => $question->dtimeCreate]
        ]);
    }

    /**
     * @param QaQuestion $question
     * @return static
     */
    public static function getPreviousQuestion(QaQuestion $question)
    {
        return static::model()->find([
            'condition' => 'dtimeCreate < :time',
            'order' => 'dtimeCreate DESC',
            'params' => [':time' => $question->dtimeCreate]
        ]);
    }

    /**
     * @return BaseAnswerManager
     */
    public function getAnswerManager()
    {
        if ($this->category->isPediatrician()) {
            return new CTAnswerManager($this);
        } else {
            return new DefaultAnswerManager($this);
        }
    }

    /**
     * @param string $condition
     * @param array $params
     * @return \site\frontend\modules\som\modules\qa\components\QaObjectList
     */
    public function getList($condition='',$params=[])
    {
        return new QaObjectList($this->findAll($condition, $params));
    }
}
