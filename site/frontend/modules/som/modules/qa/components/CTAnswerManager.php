<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\common\components\closureTable\ClosureTableManager;
use site\common\components\closureTable\IClosureTableProvider;
use site\common\components\closureTable\INode;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;

class CTAnswerManager extends BaseAnswerManager implements IClosureTableProvider
{
    public function createAnswer($authorId, $content, ISubject $subject)
    {
        $closureTableManager = new ClosureTableManager();
        $closureTableManager->setProvider($this);
        
        $transaction = \Yii::app()->db->beginTransaction();
        
        try {
            if (!$node = $closureTableManager->createNode([$content, $authorId])) {
                throw new \Exception('fail');
            }
            
            $closureTableManager->applyTo($subject);
        } catch (\Exception $ex) {
            $transaction->rollback();
        }
        
        parent::createAnswer($authorId, $content, $subject);
    }
    
    /**
     * @inheritdoc
     */
    public function createNode(array $params = [])
    {
        list($content, $authorId) = func_get_args();
        
        $answer = new QaCTAnswer();
        $answer->content = $content;
        $answer->id_author = $authorId;
        
        return $answer->save() ? $answer : null;
    }
}