<?php

class ForumsController extends ELController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionExecuted()
    {
        $this->render('executed');
    }

    public function actionReports($page = 1)
    {
        $model = new ELLink();

        $dataProvider = $model->search();
        $criteria = $dataProvider->criteria;
        $criteria->with = array('site' => array(
            'select' => array('type')
        ));
        $criteria->condition = 'site.type = ' . ELSite::TYPE_FORUM . ' AND link_cost IS NULL';
        $count = ELLink::model()->count($dataProvider->criteria);

        $pages = new CPagination($count);
        $pages->currentPage = $page - 1;
        $pages->applyLimit($dataProvider->criteria);

        $models = ELLink::model()->findAll($criteria);

        $this->render('reports', compact('models', 'pages'));
    }

    public function actionAdd()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];
        $create_task = Yii::app()->request->getPost('create_task');

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null) {
            $model = new ELSite;
            $model->url = $host;
            $model->type = ELSite::TYPE_FORUM;
            if ($model->save()) {
                if ($create_task)
                    ELTask::createRegisterTask($model->id);

                if ($model->status == ELSite::STATUS_BLACKLIST)
                    $type = 3;
                elseif (!empty($model->links))
                    $type = 2; else
                    $type = 1;

                $response = array(
                    'status' => true,
                    'id' => $model->id,
                    'type' => $type,
                    'account' => $this->renderPartial('_reg_data', array('account' => $model->account), true)
                );
            } else
                $response = array('status' => false);
        } else {
            $model->url = $host;
            $model->type = ELSite::TYPE_FORUM;
            if ($model->save()) {

                if ($model->status == ELSite::STATUS_BLACKLIST)
                    $type = 3;
                elseif (!empty($model->tasks))
                    $type = 2; else
                    $type = 1;

                $response = array(
                    'status' => true,
                    'id' => $model->id,
                    'type' => $type,
                    'account' => $this->renderPartial('_reg_data', array('account' => $model->account), true)
                );
            } else
                $response = array('status' => false);
        }

        echo CJSON::encode($response);
    }

    public function actionCheck()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null)
            $response = array(
                'type' => 1,
            );
        else {
            if ($model->status == ELSite::STATUS_BLACKLIST)
                $response = array(
                    'type' => 3,
                );
            else
                $response = array(
                    'type' => 2,
                );
        }

        echo CJSON::encode($response);
    }

    public function actionBlacklist()
    {
        $model = new ELSite('search');
        $model->unsetAttributes();
        if (isset($_GET['ELSite']))
            $model->attributes = $_GET['ELSite'];
        $model->status = ELSite::STATUS_BLACKLIST;

        $this->render('blacklist', compact('model'));
    }

    public function actionDowngrade()
    {
        $site = $this->loadModel(Yii::app()->request->getPost('site_id'));
        if ($site->bad_rating < 5) {
            $site->bad_rating++;
            if ($site->save()) {
                $response = array(
                    'status' => true,
                    'class' => $site->getCssClass()
                );
            } else
                $response = array('status' => false, 'error' => $site->getErrorsText());

            echo CJSON::encode($response);
        } else
            echo CJSON::encode(array('status' => false, 'error' => 'Хуже уже некуда'));
    }

    public function actionRemoveFromBl()
    {
        $site = $this->loadModel(Yii::app()->request->getPost('site_id'));
        $site->comments_count = Yii::app()->request->getPost('commentsCount');
        $site->removeFromBlacklist();

        echo CJSON::encode(array(
            'status' => true
        ));
    }

    public function actionGraylist()
    {
        $model = new ELSite('search');
        $model->unsetAttributes();
        if (isset($_GET['ELSite']))
            $model->attributes = $_GET['ELSite'];

        $this->render('graylist', compact('model'));
    }

    public function actionAddToBlacklist()
    {
        $site = $this->loadModel(Yii::app()->request->getPost('site_id'));

        if ($site->addToBlacklist()) {
            $response = array('status' => true);
        } else
            $response = array('status' => false, 'error' => $site->getErrorsText());
        echo CJSON::encode($response);
    }

    public function actionChangeLimit(){
        $site = $this->loadModel(Yii::app()->request->getPost('site_id'));
        $comments_count = Yii::app()->request->getPost('commentsCount');
        if (empty($comments_count))
            Yii::app()->end();

        $site->comments_count = $comments_count;
        if ($site->save()) {
            $response = array('status' => true);
        } else
            $response = array('status' => false, 'error' => $site->getErrorsText());
        echo CJSON::encode($response);
    }

    /**
     * @param int $id model id
     * @return ELSite
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ELSite::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}