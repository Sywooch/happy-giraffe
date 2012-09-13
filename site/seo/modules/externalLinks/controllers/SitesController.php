<?php

class SitesController extends SController
{
    public $layout = '/layouts/externalLinks';
    public $icon = 2;
    public $pageTitle = 'Внешние ссылки';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionReports($page = 0)
    {
        $model = new ELLink();

        $dataProvider = $model->search();
        $criteria = $dataProvider->criteria;
        $count = ELLink::model()->count($dataProvider->criteria);

        $pages = new CPagination($count);
        $pages->pageSize = 2;
        $pages->currentPage = $page;
        $pages->applyLimit($dataProvider->criteria);

        $models = ELLink::model()->findAll($criteria);

        $this->render('reports', compact('models', 'pages'));
    }

    public function actionCheckSite()
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
            elseif (!empty($model->links))
                $response = array(
                    'type' => 2,
                    'links' => $this->renderPartial('_links', array('links'=>$model->links), true)
                );
            else
                $response = array(
                    'type' => 1,
                );
        }

        echo CJSON::encode($response);
    }

    public function actionAddSite()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null) {
            $model = new ELSite;
            $model->url = $host;
            if ($model->save()) {
                $response = array(
                    'status' => true,
                    'id' => $model->id
                );
            } else
                $response = array('status' => false);
        } else
            $response = array('status' => true, 'id' => $model->id);

        echo CJSON::encode($response);
    }

    public function actionAddToBlacklist()
    {
        $url = Yii::app()->request->getPost('url');
        $parse = parse_url($url);
        $host = $parse['host'];

        $model = ELSite::model()->findByAttributes(array('url' => $host));
        if ($model === null) {
            $model = new ELSite();
            $model->url = $host;
            $model->status = ELSite::STATUS_BLACKLIST;
            $model->type = 1;
        } else {
            if ($model->status == ELSite::STATUS_BLACKLIST) {
                echo CJSON::encode(array('status' => true));
                Yii::app()->end();
            } else
                $model->status = ELSite::STATUS_BLACKLIST;
        }

        if ($model->save()) {
            $response = array('status' => true);
        } else
            $response = array(
                'status' => false,
                'error' => $model->getErrorsText()
            );

        echo CJSON::encode($response);
    }

    public function actionAdd()
    {
        $model = new ELLink();
        if (Yii::app()->request->getPost('paid_link') == 'on')
            $model->scenario = 'paid';

        $model->attributes = Yii::app()->request->getPost('ELLink');

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
            $model->site->status = 0;
            $model->site->save();
            if (!$model->withRelated->save(true, array('keywords')))
                var_dump($model->getErrors());
        }
    }
}