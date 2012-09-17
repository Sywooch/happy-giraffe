<?php

class TasksController extends ELController
{
    public function actionIndex()
    {
        $task = ELTask::getNextTask();
        if ($task === null)
            $this->render('empty');
        else
            $this->render('task', compact('task'));
    }

    public function actionTakeForum()
    {
        $transaction = ELTask::model()->getDbConnection()->beginTransaction();
        try {
            $task = $this->loadModel(Yii::app()->request->getPost('id'));
            if (!empty($task->user_id)) {
                $response = array('status' => false, 'error' => 'Форум уже взят, перезагрузите страницу');
            } else {
                $task->user_id = Yii::app()->user->id;
                $task->closeTask();
                $response = array('status' => $task->save());
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $response = array('status' => false, 'error' => 'Ошибка транзакции, попробуйте снова');
        }

        echo CJSON::encode($response);
    }

    public function actionAddForumLogin()
    {
        $login = Yii::app()->request->getPost('login');
        $password = Yii::app()->request->getPost('password');
        $site = $this->loadSite(Yii::app()->request->getPost('site_id'));

        if (empty($site->account))
            $account = new ELAccount();
        else
            $account = $site->account;
        $account->login = $login;
        $account->password = $password;
        if ($account->save()) {
            $response = array(
                'status' => true,
            );
        } else
            $response = array('status' => false, 'error' => $account->getErrorsText());

        echo CJSON::encode($response);
    }

    public function actionProblem()
    {
        $type = Yii::app()->request->getPost('type');
        $task = $this->loadModel(Yii::app()->request->getPost('id'));

        if ($type == 1) {
            if ($task->site->addToBlacklist()) {
                $response = array(
                    'status' => true,
                );
            } else
                $response = array('status' => false, 'error' => $task->site->getErrorsText());

        } elseif ($type == 2) {
            $task->start_date = date("Y-m-d", strtotime('+ 3 days'));
            $task->user_id = Yii::app()->user->id;
            if ($task->save()) {
                $response = array(
                    'status' => true,
                );
            } else
                $response = array('status' => false, 'error' => $task->getErrorsText());
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionExecuted()
    {
        $task = $this->loadModel(Yii::app()->request->getPost('id'));

        if ($task->closeTask()) {
            $response = array(
                'status' => true,
            );
        } else
            $response = array('status' => false, 'error' => $task->getErrorsText());

        echo CJSON::encode($response);
    }

    public function actionAddLink()
    {
        $model = new ELLink();
        $model->attributes = Yii::app()->request->getPost('ELLink');
        $model->author_id = Yii::app()->user->id;
        $model->created = date("Y-m-d H:i:s");
        $model->link_type = ELLink::TYPE_POST;

        if (!empty($_POST['ELLink']['anchors'])) {
            $result = array();
            foreach ($_POST['ELLink']['anchors'] as $anchor) {
                $anchor = trim($anchor);
                if (!empty($anchor))
                    $result [] = Keyword::GetKeyword($anchor);
            }
            $model->keywords = $result;
        }

        echo CActiveForm::validate($model);

        if ($model->validate()) {
            if (!$model->withRelated->save(true, array('keywords')))
                var_dump($model->getErrors());
            else {
                $task_id = Yii::app()->request->getPost('id');
                if (!empty($task_id)) {
                    $task = $this->loadModel(Yii::app()->request->getPost('id'));
                    $task->closeTask();
                }
            }
        }
    }

    /**
     * @param int $id model id
     * @return ELTask
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ELTask::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id model id
     * @return ELSite
     * @throws CHttpException
     */
    public function loadSite($id){
        $model = ELSite::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}