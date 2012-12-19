<?php

class BlogsController extends ELController
{

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('externalLinks-manager-panel') &&
            !Yii::app()->user->checkAccess('externalLinks-worker-panel')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

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
        $criteria->condition = 'site.type = ' . ELSite::TYPE_BLOG . ' AND link_cost IS NULL';
        $count = ELLink::model()->count($dataProvider->criteria);

        $pages = new CPagination($count);
        $pages->currentPage = $page - 1;
        $pages->applyLimit($dataProvider->criteria);

        $models = ELLink::model()->findAll($criteria);

        $this->render('reports', compact('models', 'pages'));
    }

    public function actionCheck()
    {
        $url = trim(Yii::app()->request->getPost('url'));

        $model = ELSite::model()->findByAttributes(array('url' => $url));
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

    public function actionList()
    {
        $model = new ELSite('search');
        $model->unsetAttributes();
        if (isset($_GET['ELSite']))
            $model->attributes = $_GET['ELSite'];
        $model->type = ELSite::TYPE_BLOG;
        $model->status = ELSite::STATUS_GOOD;

        $this->render('list', compact('model'));
    }

    public function actionBlacklist()
    {
        $model = new ELSite('search');
        $model->unsetAttributes();
        if (isset($_GET['ELSite']))
            $model->attributes = $_GET['ELSite'];
        $model->status = ELSite::STATUS_BLACKLIST;
        $model->type = ELSite::TYPE_BLOG;

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

    public function actionAddToBlacklist()
    {
        $site = $this->loadModel(Yii::app()->request->getPost('site_id'));

        if ($site->addToBlacklist()) {
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