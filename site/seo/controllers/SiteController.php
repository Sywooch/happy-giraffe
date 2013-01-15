<?php

class SiteController extends SController
{
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'logout', 'modules', 'removeUser', 'test', 'sql'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('login', 'maintenance', 'closeAdvert'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        if (count($this->getUserModules()) > 1)
            $this->redirect($this->createUrl('site/modules'));

        if (Yii::app()->user->checkAccess('moderator'))
            $this->redirect($this->createUrl('writing/moderator/index'));

        if (Yii::app()->user->checkAccess('admin'))
            $this->redirect($this->createUrl('user/'));

        if (Yii::app()->user->checkAccess('author'))
            $this->redirect($this->createUrl('writing/author'));

        if (Yii::app()->user->checkAccess('rewrite-author'))
            $this->redirect($this->createUrl('writing/author'));

        if (Yii::app()->user->checkAccess('editor'))
            $this->redirect($this->createUrl('writing/editor/tasks', array('rewrite' => 0)));

        if (Yii::app()->user->checkAccess('content-manager'))
            $this->redirect($this->createUrl('writing/content/index'));

        if (Yii::app()->user->checkAccess('articles-input'))
            $this->redirect($this->createUrl('writing/existArticles'));

        if (Yii::app()->user->checkAccess('corrector'))
            $this->redirect($this->createUrl('writing/corrector/index'));

        if (Yii::app()->user->checkAccess('superuser'))
            $this->redirect($this->createUrl('competitors/default/index'));

        if (Yii::app()->user->checkAccess('promotion'))
            $this->redirect($this->createUrl('promotion/linking/autoLinking'));

        if (Yii::app()->user->checkAccess('cook-manager'))
            $this->redirect('/competitors/cook/');

        if (Yii::app()->user->checkAccess('cook-author'))
            $this->redirect($this->createUrl('cook/author'));

        if (Yii::app()->user->checkAccess('cook-content-manager'))
            $this->redirect($this->createUrl('cook/content'));

        if (Yii::app()->user->checkAccess('externalLinks-manager'))
            $this->redirect($this->createUrl('externalLinks/sites/index'));

        if (Yii::app()->user->checkAccess('externalLinks-worker'))
            $this->redirect($this->createUrl('externalLinks/tasks/index'));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        $this->layout = 'none';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            $userModel = new SeoUser('login');
            $userModel = $userModel->find(array(
                'condition' => 'email=:email AND password=:password',
                'params' => array(
                    ':email' => $model->username,
                    ':password' => md5($model->password),
                )));

            if ($userModel !== null) {
                $identity = new SeoUserIdentity($userModel->getAttributes());
                $identity->authenticate();
                if ($identity->errorCode == SeoUserIdentity::ERROR_NONE) {
                    Yii::app()->user->login($identity);
                    $this->redirect(array('site/index'));
                }
            } else
                $model->addError('username', 'Неправильный логин или пароль');
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionModules()
    {
        $this->render('modules');
    }

    public function actionSql($sql = '')
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $long_time = 0;
        if (!empty($sql)) {
            $start_time = microtime(true);
            Yii::app()->db_seo->createCommand($sql)->execute();
            $long_time = 1000 * (microtime(true) - $start_time);
        }

        $this->render('sql', compact('sql', 'long_time'));
    }

    public function actionRemoveUser()
    {
        $entity_id = Yii::app()->request->getPost('entity_id');
        $list_name = Yii::app()->request->getPost('list_name');
        $entities = Yii::app()->user->getState($list_name);
        foreach ($entities as $key => $entity)
            if ($entity == $entity_id)
                unset($entities[$key]);
        Yii::app()->user->setState($list_name, $entities);
        echo CJSON::encode(array('status' => true));
    }

    public function actionMaintenance()
    {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        $this->layout = '//system/layout';
        Yii::app()->clientScript->registerCssFile('http://www.happy-giraffe.ru/stylesheets/maintenance.css');
        $this->render('//system/maintenance');
    }

    public function actionCloseAdvert()
    {
        SeoUserAttributes::setAttribute('close_advert_' . SeoUserAttributes::ADVERT_ID, 1);
    }

    public function actionTest()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        $html = file_get_contents('http://ru.wikipedia.org/wiki/%D0%93%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%A3%D0%BA%D1%80%D0%B0%D0%B8%D0%BD%D1%8B');

        $document = phpQuery::newDocument($html);
        $k = 0;
        foreach ($document->find('#mw-content-text > ul > li') as $row) {
            $city_name = trim(pq($row)->find('a:first')->text());
            if ($city_name == 'Ямполь')
                continue;
            $region_name = trim(pq($row)->find('a:eq(1)')->text());

            if ($region_name == 'Автономная Республика Крым')
                $region_name = 'Республика Крым';
            if ($region_name == 'Ровненская область')
                $region_name = 'Республика Крым';
            //echo $city_name . ' - ' . $region_name . '<br>';

            $region = GeoRegion::model()->findByAttributes(array('country_id' => 221, 'name' => $region_name));
            if ($region === null)
                echo $region_name . ' not found<br>';
            else {
                $criteria = new CDbCriteria;
                $criteria->compare('country_id',221);
                $criteria->compare('region_id',$region->id);
                $criteria->compare('name',$city_name);
                $city = GeoCity::model()->find($criteria);

                if ($city === null){
                    $criteria = new CDbCriteria;
                    $criteria->compare('country_id',221);
                    $criteria->compare('region_id',$region->id);
                    $criteria->compare('name',$city_name, true);
                    $city = GeoCity::model()->find($criteria);
                    if ($city !== null){
                        echo $city_name.' - '.$city->name.'<br>';
                        $city->name = $city_name;
                        $city->save();
                    }

                    //echo $city_name . ' not found<br>';
                }
            }

            $k++;

            if ($k >= 414)
                break;
        }
    }
}