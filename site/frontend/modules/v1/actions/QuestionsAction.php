<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\som\modules\qa\models\QaQuestion;

class QuestionsAction extends RoutedAction
{
    public function run()
    {
        $this->route('getQuestions', 'postQuestion', 'updateQuestion', 'deleteQuestion');
    }

    public function getQuestions()
    {
        $this->controller->get(QaQuestion::model(), $this);
    }

    public function postQuestion()
    {
        if (!\Yii::app()->user->checkAccess('createQaQuestion')) {
            $this->controller->setError('AccessDenied', 403);
            return;
        }

        $require = array(
            'title' => true,
            'text' => true,
            'sendNotifications' => true,
            'categoryId' => true,
            'consultationId' => false,
        );

        if ($this->controller->checkParams($require)) {
            $question = new QaQuestion();

            $question->attributes = $this->controller->getParams($require);
            $question->authorId = $this->controller->identity->getId();

            if ($question->save()) {
                $this->controller->data = $question;
            } else {
                $this->controller->setError('SavingFailed', 500);
            }
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }
    }

    public function updateQuestion()
    {
        $require = array(
            'id' => true,
            'title' => true,
            'sendNotifications' => true,
            'categoryId' => true,
            'consultationId' => false,
        );

        if ($this->controller->checkParams($require)) {
            $params = $this->controller->getParams($require);

            $question = QaQuestion::model()->findByPk($params['id']);

            if ($question) {
                if (!\Yii::app()->user->checkAccess('updateQaQuestion', array('entity' => $question))) {
                    $this->controller->setError('AccessDenied', 403);
                    return;
                }

                unset($params['id']);
                $question->attributes = $params;

                if ($question->save()) {
                    $this->controller->data = $question;
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

    public function deleteQuestion()
    {
        $require = array(
            'id' => true,
            'action' => true,
        );

        if ($this->controller->checkParams($require)) {
            $params = $this->getParams($require);

            $question = QaQuestion::model()->findByPk($params['id']);

            if ($question) {
                if (!\Yii::app()->user->checkAccess('manageQaQuestion', array('entity' => $question))) {
                    $this->controller->setError('AccessDenied', 403);
                    return;
                }

                switch ($params['action']) {
                    case 'delete':
                        $question->isRemoved = 1;
                        break;
                    case 'restore':
                        $question->isRemoved = 0;
                        break;
                    default:
                        $this->controller->setError('InvalidActionParam', 400);
                        return;
                }

                if ($question->save()) {
                    $this->controller->data = $question;
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
}