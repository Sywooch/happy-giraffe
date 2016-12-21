<?php

namespace site\frontend\modules\som\modules\activity\commands;

use site\frontend\modules\som\modules\activity\models\Activity;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;

/**
 * Class ModifiedAnswersRows
 *
 * @package site\frontend\modules\som\modules\activity\commands
 * @author Sergey Gubarev
 */
class ActivityAnswers extends \CConsoleCommand
{

    public function actionIndex()
    {
        try
        {
            echo 'Выборка всех ответов к вопросам..' . PHP_EOL;

            $cmd = \Yii::app()->getDb()->createCommand()
                ->select('MD5(id)')
                ->from(QaAnswer::model()->tableName())
            ;

            $answersHashList = $cmd->queryColumn();

            $criteria = new \CDbCriteria();
            $criteria->addInCondition('typeId', [Activity::TYPE_COMMENT, Activity::TYPE_ANSWER_PEDIATRICIAN]);
            $criteria->addInCondition('hash', $answersHashList);

            $activityAnswers = Activity::model()->findAll($criteria);

            echo 'Выбрано: ' . count($activityAnswers) . PHP_EOL;

            $count = 0;

            foreach ($activityAnswers as $activityAnswerModel)
            {
                $answerModel = $this->_getAnswerModel($activityAnswerModel->hash);

                if (is_null($answerModel))
                {
                    echo "{$activityAnswerModel->id} ($activityAnswerModel->hash) не найдена" . PHP_EOL;
                    continue;
                }
                else
                {
                    if ($activityAnswerModel->typeId != Activity::TYPE_ANSWER_PEDIATRICIAN && $answerModel->authorIsSpecialist())
                    {
                        $activityAnswerModel->typeId = Activity::TYPE_ANSWER_PEDIATRICIAN;
                    }

                    $activityAnswerModel->data = serialize($answerModel);
                    $activityAnswerModel->save();

                    $count++;

                    echo "\033[12D";
                    echo $count;
                }
            }

            echo PHP_EOL . 'ВСЕ!' . PHP_EOL;
        }
        catch (\CDbException $e)
        {
            echo PHP_EOL . $e->getMessage() . PHP_EOL;
        }
    }

    private function _getAnswerModel($hash)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = 'MD5(t.id) = :hashId';
        $criteria->params[':hashId'] = $hash;

        $model = QaAnswer::model()->find($criteria);

        if ($model->category->isPediatrician())
        {
            return QaCTAnswer::model()->find($criteria);
        }

        return $model;
    }

}