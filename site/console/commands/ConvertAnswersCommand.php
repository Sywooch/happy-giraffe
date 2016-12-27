<?php

use site\frontend\modules\som\modules\qa\models\QaAnswer;
/**
 * @author Emil Vililyaev
 */
class ConvertAnswersCommand extends CConsoleCommand
{

    public function actionRun()
    {
        echo "Started...\n";

        $answers = QaAnswer::model()->findAll('root_id IS NULL');

        foreach ($answers as /*@var $answer QaAnswer */ $answer)
        {
            $answer->markAsRoot($answer->id);

            if (!empty($answer->children))
            {
                $this->_createChildRelation($answer);
            }
        }

        echo "Done\n";
    }

    /**
     * @param QaAnswer $answer
     */
    private function _createChildRelation(QaAnswer $answer)
    {
        if (!empty($childs = $answer->children))
        {
            foreach ($childs as /*@var $child QaAnswer */ $child)
            {
                $answer->append($child);

                if (!empty($child->children))
                {
                    $this->_createChildRelation($child);
                }
            }
        }
    }

}