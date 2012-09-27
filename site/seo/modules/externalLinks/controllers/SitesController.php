<?php

class SitesController extends ELController
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionReports($page = 1)
    {
        $model = new ELLink();

        $dataProvider = $model->search();
        $criteria = $dataProvider->criteria;
        $criteria->with = array('site' => array(
            'select' => array('type')
        ));
        $criteria->compare('site.type', ELSite::TYPE_SITE);
        $count = ELLink::model()->count($dataProvider->criteria);

        $pages = new CPagination($count);
        $pages->currentPage = $page - 1;
        $pages->pageSize = 10;
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
                    'links' => $this->renderPartial('_links', array('links' => $model->links), true)
                ); else
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
            $model->type = ELSite::TYPE_SITE;
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
            $model->type = ELSite::TYPE_SITE;
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

    public function actionLoadUrl()
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $url = Yii::app()->request->getPost('url');
        $html = file_get_contents($url);
        $document = phpQuery::newDocument($html);

        foreach ($document->find('a') as $link) {
            $href = trim(pq($link)->attr('href'));
            if (strpos($href, 'http://www.happy-giraffe.ru/') !== false) {
                if (trim(pq($link)->text()) == $href)
                    $anchor = '';
                else
                    $anchor = trim(pq($link)->text());

                echo CJSON::encode(array(
                    'status' => true,
                    'url' => $href,
                    'anchor' => $anchor
                ));
                Yii::app()->end();
            }
        }
    }

    public function actionRemove()
    {
        $site_id = Yii::app()->request->getPost('site_id');
        $site = $this->loadSite($site_id);

        echo CJSON::encode(array('status' => $site->delete()));
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