<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\common\components\closureTable\ClosureTableManager;
use site\common\components\closureTable\IClosureTableProvider;
use site\common\components\closureTable\INode;
use site\common\components\closureTable\ITreeNode;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;
use site\frontend\modules\som\modules\qa\models\QaCTAnswerTreeNode;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class CTAnswerManager extends BaseAnswerManager implements IClosureTableProvider
{
    /**
     * @return ClosureTableManager
     */
    protected function getManager()
    {
        return new ClosureTableManager($this);
    }

    /**
     * @param int $authorId
     * @param string $content
     * @param ISubject|INode $subject
     * @throws \Exception
     * @return INode|null
     */
    public function createAnswer($authorId, $content, $subject)
    {
        $transaction = \Yii::app()->db->currentTransaction === null ? \Yii::app()->db->beginTransaction() : \Yii::app()->db->currentTransaction;

        try {
            $subjectId = $subject instanceof ISubject ? $subject->getSubjectId() : static::findSubject($subject);

            /** @var QaCTAnswer $node */
            if (!$node = $this->getManager()->createNode([$content, $authorId, $subjectId])) {
                throw new \Exception('fail create');
            }

            if (!$this->getManager()->attach($node, $subjectId, $subject instanceof INode ? $subject : null)) {
                throw new \Exception('fail attach');
            }

            $transaction->commit();

            return $node;
        } catch (\Exception $ex) {
            $transaction->rollback();
            throw $ex;
        }
    }

    /**
     * @param QaCTAnswer $answer
     * @param \User $user
     * @return mixed
     */
    public function canAnswer($answer, \User $user)
    {
        return $answer->id_author != $user->id;
    }

    public function getAnswer($answerId)
    {
        return $this->getManager()->getNodeTree($answerId);
    }

    public function getAnswers(QaQuestion $question)
    {
        return $this->getManager()->getNodeTree($question->getSubjectId());
    }

    public function getAnswersCount(QaQuestion $question)
    {
        return count($this->getAnswers($question));
    }

    /**
     * @param INode $answer
     * @return int|null
     */
    public static function findSubject(INode $answer)
    {
        /** @var ITreeNode $treeNode */
        $treeNode = QaCTAnswerTreeNode::model()->byAncestorId($answer->getId())->byDescendantId($answer->getId())->find();

        return $treeNode ? $treeNode->getSubjectId() : null;
    }

#region IClosureTableProvider
    /**
     * @inheritdoc
     */
    public function createNode(array $params = [])
    {
        list($content, $authorId) = $params;

        $answer = new QaCTAnswer();
        $answer->content = $content;
        $answer->id_author = $authorId;

        return $answer->save() ? $answer : null;
    }

    /**
     * @inheritdoc
     */
    public function createNodeTree($idAncestor, $idDescendant, $level, $idSubject, $idNearestAncestor)
    {
        $treeNode = new QaCTAnswerTreeNode();
        $treeNode->id_ancestor = $idAncestor;
        $treeNode->id_descendant = $idDescendant;
        $treeNode->level = $level;
        $treeNode->id_subject = $idSubject;
        $treeNode->id_nearest_ancestor = $idNearestAncestor;

        return $treeNode->save() ? $treeNode : null;
    }

    /**
     * @inheritdoc
     */
    public function fetchNode($id)
    {
        return QaCTAnswer::model()->find(['condition' => ['id' => $id]]);
    }

    /**
     * @inheritdoc
     */
    public function fetchTree($subjectId)
    {
        $sql = <<<SQL
        SELECT
          nodes.id, nodes.content, tree.id_ancestor, tree.id_descendant, tree.id_nearest_ancestor, tree.level
        FROM
          qa__answers_new AS nodes
        JOIN
          qa__answers_new_tree AS tree ON nodes.id = tree.id_descendant
        WHERE
          tree.id_subject = {$subjectId}
SQL;

        return \Yii::app()->db->createCommand($sql)->queryAll(true);
    }

    /**
     * @inheritdoc
     */
    public function fetchNodes(array $id)
    {
        return QaCTAnswer::model()->findAllByPk($id, ['index' => 'id']);
    }

    public function getAncestors($subjectId, $ancestorId)
    {
        return QaCTAnswerTreeNode::model()->find()->byDescendantId($ancestorId)->bySubjectId($subjectId)->findAll();
    }
#endregion
}
