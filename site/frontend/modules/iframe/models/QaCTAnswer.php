<?php

namespace site\frontend\modules\iframe\models;

use site\common\components\closureTable\INode;
use site\frontend\components\api\ApiRelation;
use site\frontend\components\api\models\User;
use site\frontend\modules\som\modules\qa\behaviors\QaBehavior;
use site\frontend\modules\som\modules\qa\components\BaseVoteManager;
use site\frontend\modules\som\modules\qa\components\CTAnswerManager;
use site\frontend\modules\som\modules\qa\components\ISubject;
use site\frontend\modules\som\modules\qa\components\QaCTVoteManager;
use site\frontend\modules\specialists\models\SpecialistProfile;

/**
 * @property int $id
 * @property string $content
 * @property int $id_author
 * @property int $is_removed
 * @property int $votes_count
 * @property int $dtimeCreate
 * @property int $dtimeUpdate
 *
 * @property-read int $votesCount алиас
 * @property string $text алиас
 * @property-read $authorId алиас
 *
 * @property-read \User $author
 * @property-read User $user
 * @property-read QaQuestion $question
 *
 * @property-read \PurifiedBehavior $purified
 */
class QaCTAnswer extends \HActiveRecord implements INode, \IHToJSON
{
    /**
     * @return BaseVoteManager
     */
    public static function createVoteManager()
    {
        return new QaCTVoteManager();
    }

    public function __construct()
    {
        throw new \Exception("depricated!");
    }

    public function tableName()
    {
        return 'qa__answers_new';
    }

    public function rules()
    {
        return [
            ['content', 'required'],
        ];
    }

    public function relations()
    {
        return [
            'author' => [static::BELONGS_TO, \User::class, 'id_author'],
        ];
    }

    public function apiRelations()
    {
        return [
            'user' => [ApiRelation::class, User::class, 'id_author', 'params' => ['avatarSize' => 40]],
        ];
    }

    public function behaviors()
    {
        return [
            'HTimestampBehavior' => [
                'class' => \HTimestampBehavior::class,
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => 'dtimeUpdate',
            ],
            'purified' => [
                'class' => \PurifiedBehavior::class,
                'attributes' => ['text'],
                'options' => [
                    'AutoFormat.Linkify' => true,
                ],
            ],
            'QaBehavior' => [
                'class' => QaBehavior::class
            ]
        ];
    }

    /**
     * @return QaQuestion
     */
    public function getQuestion()
    {
        return QaQuestion::model()->findByPk(CTAnswerManager::findSubject($this));
    }

#region QaAnswer BC
    /**
     * @return bool
     */
    public function authorIsSpecialist()
    {
        return $this->author->isSpecialist;
    }

    public function getVotesCount()
    {
        return $this->votes_count;
    }

    public function getText()
    {
        return $this->content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthorId()
    {
        return $this->id_author;
    }

#endregion

    public function orderDesc()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.dtimeCreate DESC';

        return $this;
    }

    public function user($userId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.id_author', $userId);
        return $this;
    }

    public function defaultScope()
    {
        $t = $this->getTableAlias(false, false);

        return [
            'condition' => $t . '.is_removed = 0',
        ];
    }

#region INode
    /**
     * @var INode[]
     */
    protected $_childes = [];

    /**
     * @inheritdoc
     */
    public function appendChild(INode $node)
    {
        $this->_childes[] = $node;
    }

#endregion

    public function toJSON()
    {
        return [
            'user' => $this->user->toJSON(),
            'dtimeCreate' => $this->dtimeCreate,
            'text' => $this->purified->text,
            'votesCount' => $this->votes_count,
            'canEdit' => false,
            'canRemove' => false,
            'canVote' => false,
            'isVoted' => false,
            'isAdditional' => false,
            'isAnswerToAdditional' => false,
            'isSpecialistAnswer' => false,
            'root_id' => null,
            'can_answer' => $this->question->answerManager->canAnswer($this, \Yii::app()->user->getModel()),
        ];
    }
}