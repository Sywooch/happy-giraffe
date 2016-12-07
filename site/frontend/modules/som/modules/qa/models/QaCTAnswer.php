<?php

namespace site\frontend\modules\som\modules\qa\models;

use site\common\components\closureTable\INode;

/**
 * @property int $id
 * @property string $content
 * @property int $id_author
 * @property int $is_removed
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
    
    public function getId()
    {
        return $this->id;
    }
}