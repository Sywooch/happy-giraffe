<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class AnswersAction extends RoutedAction
{
    public function run()
    {
        $this->route('getAnswers', 'postAnswer', 'updateAnswer', 'deleteAnswer');
    }

    public function getAnswers()
    {
        if (\Yii::app()->request->getParam('question_id', null)) {
            $where = 'questionId = ' . \Yii::app()->request->getParam('question_id');
            $this->controller->get(QaAnswer::model(), $this, $where);
        } else {
            $this->controller->get(QaAnswer::model(), $this);
        }
    }

    public function postAnswer()
    {
        $require = array(
            'question_id' => true,
            'text' => true,
        );

        if ($this->controller->checkParams($require)) {
            $params = $this->controller->getParams($require);

            $question = QaQuestion::model()->findByPk($params['question_id']);

            if ($question) {
                if (!\Yii::app()->user->checkAccess('createQaAnswer', array('question' => $question))) {
                    $this->controller->setError('AccessDenied', 403);
                }

                $answer = new QaAnswer();
                $answer->questionId = $params['question_id'];
                $answer->text = $params['text'];

                if ($answer->save()) {
                    $this->controller->data = $answer;
                } else {
                    $this->controller->setError('SavingFailed', 500);
                }
            } else {
                $this->controller->setError('QuestionNotFound', 404);
            }
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }
    }

    public function updateAnswer()
    {
        $require = array(
            'id' => true,
            'text' => true,
        );

        if ($this->controller->checkParams($require)) {
            $params = $this->controller->getParams($require);

            $answer = QaAnswer::model()->findByPk($params['id']);

            if ($answer) {
                if (!\Yii::app()->user->checkAccess('updateQaAnswer', array('entity' => $answer))) {
                    $this->controller->setError('AccessDenied', 403);
                    return;
                }

                $answer->text = $params['text'];

                if ($answer->save()) {
                    $this->controller->data = $answer;
                } else {
                    $this->controller->setError('SavingFailed', 500);
                }
            } else {
                $this->controller->setError('AnswerNotFound', 404);
            }
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }
    }

    public function deleteAnswer()
    {
        $require = array(
            'id' => true,
            'action' => true,
        );

        if ($this->controller->checkParams($require)) {
            $params = $this->getParams($require);

            $answer = QaAnswer::model()->findByPk($params['id']);

            if ($answer) {
                if (!\Yii::app()->user->checkAccess('manageQaAnswer', array('entity' => $answer))) {
                    $this->controller->setError('AccessDenied', 403);
                    return;
                }

                switch ($params['action']) {
                    case 'delete':
                        $answer->isRemoved = 1;
                        break;
                    case 'restore':
                        $answer->isRemoved = 0;
                        break;
                    default:
                        $this->controller->setError('InvalidActionParam', 400);
                        return;
                }

                if ($answer->save()) {
                    $this->controller->data = $answer;
                } else {
                    $this->controller->setError('SavingFailed', 500);
                }
            } else {
                $this->controller->setError('AnswerNotFound', 404);
            }
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }
    }
}