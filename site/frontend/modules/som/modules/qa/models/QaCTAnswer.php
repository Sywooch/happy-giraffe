<?php

namespace site\frontend\modules\som\modules\qa\models;

use site\common\components\closureTable\INode;
use site\frontend\components\api\ApiRelation;
use site\frontend\components\api\models\User;
use site\frontend\modules\som\modules\qa\components\CTAnswerManager;
use site\frontend\modules\specialists\models\SpecialistProfile;

/**
 * @property int $id
 * @property string $content
 * @property int $id_author
 * @property int $is_removed
 * @property int $votes_count
 * @property int $dtimeCreate
 *
 * @property-read int $votesCount алиас
 * @property string $text алиас
 *
 * @property-read User $user
 * @property-read QaQuestion $question
 */
class QaCTAnswer extends \HActiveRecord implements INode
{
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
        ];
    }

    /**
     * @return QaQuestion
     */
    public function getQuestion()
    {
        return QaQuestion::model()->findByPk(CTAnswerManager::findSubject($this));
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
#endregion

    public function orderDesc()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.dtimeCreate DESC';
        return $this;
    }

    public function defaultScope()
    {
        $t = $this->getTableAlias(false, false);
        return array(
            'condition' => $t . '.is_removed = 0',
        );
    }

    /**
     * @return boolean
     */
    public function authorIsSpecialist()
    {
        return SpecialistProfile::model()->exists('id = :id', [':id' => $this->id_author]);
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
}