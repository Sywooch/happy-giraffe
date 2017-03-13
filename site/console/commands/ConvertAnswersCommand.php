<?php

use site\frontend\modules\som\modules\qa\models\QaAnswer;
/**
 * @author Emil Vililyaev
 */
class ConvertAnswersCommand extends CConsoleCommand
{

    /**
     * @var integer
     */
    const LIMIT = 200;

    public function actionRun()
    {
        echo "Started...\n";

        $answersCount = $this->_getAnswers(TRUE);
        $itaration = (int)($answersCount/self::LIMIT);

        if ($answersCount%self::LIMIT > 0)
        {
            $itaration++;
        }

        echo 'Выбрано: ' . $answersCount . PHP_EOL;
        echo 'Количество итераций: ' . $itaration . PHP_EOL;

        for ($i=0; $i < $itaration; $i++)
        {
            $scope = $i+1;
            echo PHP_EOL;
            echo "Scope № " . $scope . PHP_EOL;

            $answers = $this->_getAnswers(FALSE, self::LIMIT * $i);
            $count = 0;

            foreach ($answers as /*@var $answer QaAnswer */ $answer)
            {
                $answer->markAsRoot($answer->id);

                if (!empty($answer->children))
                {
                    $this->_createChildRelation($answer);
                }

                $count++;

                echo $count . " rows is OK";
                echo "\033[14D";
            }

        }

        echo PHP_EOL;
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

    private function _getAnswers($returnCount = FALSE, $offset = NULL)
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('root_id IS NULL');

        if (!$returnCount)
        {
            $criteria->limit = self::LIMIT;

            if (!is_null($offset))
            {
                $criteria->offset = $offset;
            }

            return QaAnswer::model()->findAll($criteria);
        }

        return QaAnswer::model()->count($criteria);

    }

}