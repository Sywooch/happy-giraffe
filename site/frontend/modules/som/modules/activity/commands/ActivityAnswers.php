<?php

namespace site\frontend\modules\som\modules\activity\commands;

use site\frontend\modules\som\modules\activity\models\Activity;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * Class ModifiedAnswersRows
 *
 * @package site\frontend\modules\som\modules\activity\commands
 * @author Sergey Gubarev
 */
class ActivityAnswers extends \CConsoleCommand
{

    /**
     * @var integer
     */
    private $_limit = 100;

    public function actionIndex()
    {
        try
        {
            echo 'Удаляю вопросы..' . PHP_EOL;
            $delCount = $this->_deleteQuestions();
            echo 'Удалено ' . $delCount . ' вопросов' . PHP_EOL;

            echo 'Выборка всех ответов к вопросам..' . PHP_EOL;

            $answersCount = $this->_getActivityAnswers(TRUE);
            $itaration = (int)($answersCount/$this->_limit);

            $isOk = 0;
            $hasError = 0;

            if ($answersCount%$this->_limit > 0)
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

                $activityAnswers = $this->_getActivityAnswers(FALSE, $this->_limit * $i);
                $count = 0;

                foreach ($activityAnswers as $activityAnswerModel)
                {
                    $answerModel = $this->_getAnswerModel($activityAnswerModel->hash);

                    if (is_null($answerModel))
                    {
                        echo "{$activityAnswerModel->id} ($activityAnswerModel->hash) не найдена" . PHP_EOL;
                        $hasError++;
                        continue;
                    }
                    else
                    {
                        if ($activityAnswerModel->typeId != Activity::TYPE_ANSWER_PEDIATRICIAN && $answerModel->authorIsSpecialist())
                        {
                            $activityAnswerModel->typeId = Activity::TYPE_ANSWER_PEDIATRICIAN;
                        }

//                         $data = serialize($answerModel);
                        $data = json_encode(['attributes' => $answerModel->getAttributes()]);

                        $activityAnswerModel->data = $data;
                        $activityAnswerModel->save();

                        $count++;

                        echo $count . " rows is OK";
                        echo "\033[13D";
//                         sleep(1);
                    }
                }
                $isOk += $count;
            }

            echo PHP_EOL;
            echo "---------------------------" . PHP_EOL;
            echo "is OK: " . $isOk . " rows" . PHP_EOL;
            echo "has error: " . $hasError . " rows" . PHP_EOL;
            $total = $hasError + $isOk;
            echo "Total converted: " . $total . " rows";
            echo PHP_EOL;
        }
        catch (\CDbException $e)
        {
            echo PHP_EOL . $e->getMessage() . PHP_EOL;
        }
    }

    private function _deleteQuestions()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('typeId="' . Activity::TYPE_QUESTION . '"');

        $activityList = Activity::model()->findAll($criteria);

        $delCount = 0;

        foreach ($activityList as $activity)
        {
            /*@var $question QaQuestion */
            $question = $this->_getQuestionModel($activity->hash);

            if (is_null($question) || is_null($question->categoryId))
            {
                continue;
            }

            if ($question->category->isPediatrician())
            {
                $activity->delete();
                $delCount++;
            }
        }

        return $delCount;
    }

    private function _getActivityAnswers($returnCount = FALSE, $offset = NULL)
    {
        $cmd = \Yii::app()->getDb()->createCommand()
            ->select('MD5(id)')
            ->from(QaAnswer::model()->tableName())
        ;

        $answersHashList = $cmd->queryColumn();

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('typeId', [Activity::TYPE_COMMENT, Activity::TYPE_ANSWER_PEDIATRICIAN]);
        $criteria->addInCondition('hash', $answersHashList);

        if (!$returnCount)
        {
            $criteria->limit = $this->_limit;

            if (!is_null($offset))
            {
                $criteria->offset = $offset;
            }

            return Activity::model()->findAll($criteria);
        }

        return Activity::model()->count($criteria);

    }

    private function _getAnswerModel($hash)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = 'MD5(t.id) = :hashId';
        $criteria->params[':hashId'] = $hash;

        $model = QaAnswer::model()->find($criteria);

        return $model;
    }

    private function _getQuestionModel($hash)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = 'MD5(t.id) = :hashId';
        $criteria->params[':hashId'] = $hash;

        $model = QaQuestion::model()->find($criteria);

        return $model;
    }

}