<?php

namespace site\frontend\modules\som\modules\qa\models;

use site\common\components\closureTable\INode;
use site\frontend\components\api\ApiRelation;
use site\frontend\components\api\models\User;
use site\frontend\modules\som\modules\qa\components\CTAnswerManager;

/**
 * @property int $id
 * @property string $content
 * @property int $id_author
 * @property int $is_removed
 * @property int $votes_count
 * @property-read int $votesCount алиас
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
            // 'user' => [static::BELONGS_TO, User::class, 'id_author'],
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