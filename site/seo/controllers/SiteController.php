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

    public function actionTest(){
        $html = '<html><body><table class="wikitable sortable jquery-tablesorter" style="background: #F7F7F7" border="0">
<tbody>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%90%D0%B1%D0%B0%D0%B9_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Абай (город)" class="mw-redirect">Абай</a></td>
<td>Абай</td>
<td><i>Абай</i></td>
<td><a href="/wiki/1961" title="1961" class="mw-redirect">1961</a></td>
<td align="right">39387</td>
<td align="right">46533</td>
<td align="right">39800</td>
<td align="right">35602</td>
<td align="right">25783</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BA%D0%BE%D0%BB%D1%8C" title="Акколь">Акколь</a></td>
<td>Акколь</td>
<td><i><span style="display: none; speak: none;">Аккол</span>Ақкөл</i></td>
<td><a href="/wiki/1965" title="1965" class="mw-redirect">1965</a></td>
<td align="right">17867</td>
<td align="right">19664</td>
<td align="right">16100</td>
<td align="right">18274</td>
<td align="right">13886</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:%D0%90ksaj_coat_of_arms.png?uselang=ru" class="image"><img alt="Аksaj coat of arms.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/9/90/%D0%90ksaj_coat_of_arms.png/30px-%D0%90ksaj_coat_of_arms.png" width="30" height="45" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/9/90/%D0%90ksaj_coat_of_arms.png/45px-%D0%90ksaj_coat_of_arms.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/9/90/%D0%90ksaj_coat_of_arms.png/60px-%D0%90ksaj_coat_of_arms.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%81%D0%B0%D0%B9_(%D0%97%D0%B0%D0%BF%D0%B0%D0%B4%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C)" title="Аксай (Западно-Казахстанская область)" class="mw-redirect">Аксай</a></td>
<td>Аксай</td>
<td><i><span style="display: none; speak: none;">Аксай</span>Ақсай</i></td>
<td><a href="/wiki/1967" title="1967" class="mw-redirect">1967</a></td>
<td align="right">10400</td>
<td align="right">18237</td>
<td align="right">26900</td>
<td align="right">42426</td>
<td align="right">33482</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%97%D0%B0%D0%BF%D0%B0%D0%B4%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Западно-Казахстанская область">Западно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coat_of_arms_of_Aksu_(Kazakhstan).jpg?uselang=ru" class="image"><img alt="Coat of arms of Aksu (Kazakhstan).jpg" src="//upload.wikimedia.org/wikipedia/commons/thumb/f/f6/Coat_of_arms_of_Aksu_%28Kazakhstan%29.jpg/30px-Coat_of_arms_of_Aksu_%28Kazakhstan%29.jpg" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/f/f6/Coat_of_arms_of_Aksu_%28Kazakhstan%29.jpg/45px-Coat_of_arms_of_Aksu_%28Kazakhstan%29.jpg 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/f/f6/Coat_of_arms_of_Aksu_%28Kazakhstan%29.jpg/60px-Coat_of_arms_of_Aksu_%28Kazakhstan%29.jpg 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%81%D1%83_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4,_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C)" title="Аксу (город, Павлодарская область)">Аксу</a></td>
<td>Аксу</td>
<td><i><span style="display: none; speak: none;">Аксу</span>Ақсу</i></td>
<td><a href="/wiki/1961" title="1961" class="mw-redirect">1961</a></td>
<td align="right">41572</td>
<td align="right">47067</td>
<td align="right">42300</td>
<td align="right">47978</td>
<td align="right">42090</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Павлодарская область">Павлодарская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE-%D0%90%D0%BA%D1%82%D0%B0%D1%83_%D0%B3%D0%B5%D1%80%D0%B1.png" class="image"><img alt="Шевченко-Актау герб.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/4/46/%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE-%D0%90%D0%BA%D1%82%D0%B0%D1%83_%D0%B3%D0%B5%D1%80%D0%B1.png/30px-%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE-%D0%90%D0%BA%D1%82%D0%B0%D1%83_%D0%B3%D0%B5%D1%80%D0%B1.png" width="30" height="49" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/4/46/%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE-%D0%90%D0%BA%D1%82%D0%B0%D1%83_%D0%B3%D0%B5%D1%80%D0%B1.png/45px-%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE-%D0%90%D0%BA%D1%82%D0%B0%D1%83_%D0%B3%D0%B5%D1%80%D0%B1.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/4/46/%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE-%D0%90%D0%BA%D1%82%D0%B0%D1%83_%D0%B3%D0%B5%D1%80%D0%B1.png/60px-%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE-%D0%90%D0%BA%D1%82%D0%B0%D1%83_%D0%B3%D0%B5%D1%80%D0%B1.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D0%B0%D1%83" title="Актау">Актау</a></td>
<td>Актау</td>
<td><i><span style="display: none; speak: none;">Актау</span>Ақтау</i></td>
<td><a href="/wiki/1963" title="1963" class="mw-redirect">1963</a></td>
<td align="right">110575</td>
<td align="right">159245</td>
<td align="right">143396</td>
<td align="right">180373</td>
<td align="right">172904</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%9C%D0%B0%D0%BD%D0%B3%D0%B8%D1%81%D1%82%D0%B0%D1%83%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Мангистауская область">Мангистауская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Aktobe_seal.gif?uselang=ru" class="image"><img alt="Aktobe seal.gif" src="//upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Aktobe_seal.gif/30px-Aktobe_seal.gif" width="30" height="29" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Aktobe_seal.gif/45px-Aktobe_seal.gif 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Aktobe_seal.gif/60px-Aktobe_seal.gif 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA" title="Актюбинск" class="mw-redirect">Актюбинск</a></td>
<td>Актобе</td>
<td><i><span style="display: none; speak: none;">Актобе</span>Ақтөбе</i></td>
<td><a href="/wiki/1869" title="1869" class="mw-redirect">1869</a></td>
<td align="right">190569</td>
<td align="right">253532</td>
<td align="right">253088</td>
<td align="right">285507</td>
<td align="right">357193</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%90%D0%BB%D0%B3%D0%B0" title="Алга">Алга</a></td>
<td>Алга</td>
<td><i><span style="display: none; speak: none;">Алга</span>Алға</i></td>
<td><a href="/wiki/1961" title="1961" class="mw-redirect">1961</a></td>
<td align="right">16420</td>
<td align="right">17910</td>
<td align="right">15100</td>
<td align="right">14741</td>
<td align="right">19896</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coat_of_arms_of_Almaty.svg?uselang=ru" class="image"><img alt="Coat of arms of Almaty.svg" src="//upload.wikimedia.org/wikipedia/commons/thumb/9/93/Coat_of_arms_of_Almaty.svg/30px-Coat_of_arms_of_Almaty.svg.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/9/93/Coat_of_arms_of_Almaty.svg/45px-Coat_of_arms_of_Almaty.svg.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/9/93/Coat_of_arms_of_Almaty.svg/60px-Coat_of_arms_of_Almaty.svg.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0-%D0%90%D1%82%D0%B0" title="Алма-Ата">Алма-Ата</a></td>
<td>Алматы</td>
<td><i>Алматы</i></td>
<td><a href="/wiki/1867" title="1867" class="mw-redirect">1867</a></td>
<td align="right">909644</td>
<td align="right">1127884</td>
<td align="right">1129356</td>
<td align="right">1328362</td>
<td align="right">1422354</td>
<td align="center">1</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0-%D0%90%D1%82%D0%B0" title="Алма-Ата">Алма-Ата</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%90%D1%80%D0%B0%D0%BB%D1%8C%D1%81%D0%BA" title="Аральск">Аральск</a></td>
<td>Арал</td>
<td><i>Арал</i></td>
<td><a href="/wiki/1938" title="1938" class="mw-redirect">1938</a></td>
<td align="right">32087</td>
<td align="right">30801</td>
<td align="right">31100</td>
<td align="right">36328</td>
<td align="right">30505</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Кызылординская область">Кызылординская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Arkalyk_seal.png?uselang=ru" class="image"><img alt="Arkalyk seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Arkalyk_seal.png/30px-Arkalyk_seal.png" width="30" height="37" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Arkalyk_seal.png/45px-Arkalyk_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Arkalyk_seal.png/60px-Arkalyk_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D1%80%D0%BA%D0%B0%D0%BB%D1%8B%D0%BA" title="Аркалык">Аркалык</a></td>
<td>Аркалык</td>
<td><i><span style="display: none; speak: none;">Аркалык</span>Арқалық</i></td>
<td><a href="/wiki/1965" title="1965" class="mw-redirect">1965</a></td>
<td align="right">47963</td>
<td align="right">62367</td>
<td align="right">45700</td>
<td align="right">56614</td>
<td align="right">27835</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%9A%D0%BE%D1%81%D1%82%D0%B0%D0%BD%D0%B0%D0%B9%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Костанайская область">Костанайская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:%D0%90%D1%80%D1%8B%D1%81_%D0%B3%D0%B5%D1%80%D0%B1.png?uselang=ru" class="image"><img alt="Арыс герб.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/0/03/%D0%90%D1%80%D1%8B%D1%81_%D0%B3%D0%B5%D1%80%D0%B1.png/30px-%D0%90%D1%80%D1%8B%D1%81_%D0%B3%D0%B5%D1%80%D0%B1.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/0/03/%D0%90%D1%80%D1%8B%D1%81_%D0%B3%D0%B5%D1%80%D0%B1.png/45px-%D0%90%D1%80%D1%8B%D1%81_%D0%B3%D0%B5%D1%80%D0%B1.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/0/03/%D0%90%D1%80%D1%8B%D1%81_%D0%B3%D0%B5%D1%80%D0%B1.png/60px-%D0%90%D1%80%D1%8B%D1%81_%D0%B3%D0%B5%D1%80%D0%B1.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D1%80%D1%8B%D1%81" title="Арыс">Арыс</a></td>
<td>Арыс</td>
<td><i>Арыс</i></td>
<td><a href="/wiki/1956" title="1956" class="mw-redirect">1956</a></td>
<td align="right">27995</td>
<td align="right">33523</td>
<td align="right">34100</td>
<td align="right">39934</td>
<td align="right">39541</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:New_coat_of_arms_of_Astana.svg?uselang=ru" class="image"><img alt="New coat of arms of Astana.svg" src="//upload.wikimedia.org/wikipedia/commons/thumb/8/8a/New_coat_of_arms_of_Astana.svg/30px-New_coat_of_arms_of_Astana.svg.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/8/8a/New_coat_of_arms_of_Astana.svg/45px-New_coat_of_arms_of_Astana.svg.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/8/8a/New_coat_of_arms_of_Astana.svg/60px-New_coat_of_arms_of_Astana.svg.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D1%81%D1%82%D0%B0%D0%BD%D0%B0" title="Астана">Астана</a></td>
<td>Астана</td>
<td><i>Астана</i></td>
<td><a href="/wiki/1831" title="1831" class="mw-redirect">1831</a></td>
<td align="right">233638</td>
<td align="right">277365</td>
<td align="right">312965</td>
<td align="right">389189</td>
<td align="right">684479</td>
<td align="center">1</td>
<td><a href="/wiki/%D0%A1%D1%82%D0%BE%D0%BB%D0%B8%D1%86%D0%B0" title="Столица">Столица</a> <a href="/wiki/%D0%A0%D0%B5%D1%81%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B0_%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD" title="Республика Казахстан" class="mw-redirect">Республики Казахстан</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%90%D1%82%D0%B1%D0%B0%D1%81%D0%B0%D1%80" title="Атбасар">Атбасар</a></td>
<td>Атбасар</td>
<td><i>Атбасар</i></td>
<td><a href="/wiki/1892" title="1892" class="mw-redirect">1892</a></td>
<td align="right">36250</td>
<td align="right">39163</td>
<td align="right">33400</td>
<td align="right">37910</td>
<td align="right">30099</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coat_of_arms_of_Atyrau.jpg?uselang=ru" class="image"><img alt="Coat of arms of Atyrau.jpg" src="//upload.wikimedia.org/wikipedia/commons/thumb/d/db/Coat_of_arms_of_Atyrau.jpg/30px-Coat_of_arms_of_Atyrau.jpg" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/d/db/Coat_of_arms_of_Atyrau.jpg/45px-Coat_of_arms_of_Atyrau.jpg 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/d/db/Coat_of_arms_of_Atyrau.jpg/60px-Coat_of_arms_of_Atyrau.jpg 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%90%D1%82%D1%8B%D1%80%D0%B0%D1%83" title="Атырау">Атырау</a></td>
<td>Атырау</td>
<td><i>Атырау</i></td>
<td><a href="/wiki/1885" title="1885" class="mw-redirect">1885</a></td>
<td align="right">130916</td>
<td align="right">149261</td>
<td align="right">142497</td>
<td align="right">158308</td>
<td align="right">178474</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%90%D1%82%D1%8B%D1%80%D0%B0%D1%83%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Атырауская область">Атырауская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%90%D1%8F%D0%B3%D0%BE%D0%B7_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Аягоз (город)" class="mw-redirect">Аягоз</a></td>
<td>Аягоз</td>
<td><i><span style="display: none; speak: none;">Аякоз</span>Аягөз</i></td>
<td><a href="/wiki/1939" title="1939" class="mw-redirect">1939</a></td>
<td align="right">38969</td>
<td align="right">42729</td>
<td align="right">35000</td>
<td align="right">34895</td>
<td align="right">37593</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Baikonur_seal.png?uselang=ru" class="image"><img alt="Baikonur seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/7/74/Baikonur_seal.png/30px-Baikonur_seal.png" width="30" height="44" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/7/74/Baikonur_seal.png/45px-Baikonur_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/7/74/Baikonur_seal.png/60px-Baikonur_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%91%D0%B0%D0%B9%D0%BA%D0%BE%D0%BD%D1%83%D1%80_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Байконур (город)">Байконур</a></td>
<td>Байконыр</td>
<td><i><span style="display: none; speak: none;">Байконыр</span>Байқоңыр</i></td>
<td><a href="/wiki/1969" title="1969" class="mw-redirect">1969</a></td>
<td align="right"></td>
<td align="right">74700</td>
<td align="right">60200</td>
<td align="right">59452</td>
<td align="right">37 096</td>
<td align="center">1</td>
<td><a href="/wiki/%D0%90%D1%80%D0%B5%D0%BD%D0%B4%D0%B0" title="Аренда">Арендуется</a> <a href="/wiki/%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D0%B9%D1%81%D0%BA%D0%B0%D1%8F_%D0%A4%D0%B5%D0%B4%D0%B5%D1%80%D0%B0%D1%86%D0%B8%D1%8F" title="Российская Федерация" class="mw-redirect">Российской Федерацией</a><sup id="cite_ref-4" class="reference"><a href="#cite_note-4">[4]</a></sup></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%93%D0%B5%D1%80%D0%B1_%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88%D0%B0.png" class="image"><img alt="Герб Балхаша.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/8/8b/%D0%93%D0%B5%D1%80%D0%B1_%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88%D0%B0.png/30px-%D0%93%D0%B5%D1%80%D0%B1_%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88%D0%B0.png" width="30" height="29" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/8/8b/%D0%93%D0%B5%D1%80%D0%B1_%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88%D0%B0.png/45px-%D0%93%D0%B5%D1%80%D0%B1_%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88%D0%B0.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/8/8b/%D0%93%D0%B5%D1%80%D0%B1_%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88%D0%B0.png/60px-%D0%93%D0%B5%D1%80%D0%B1_%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88%D0%B0.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%91%D0%B0%D0%BB%D1%85%D0%B0%D1%88_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Балхаш (город)">Балхаш</a></td>
<td>Балхаш</td>
<td><i><span style="display: none; speak: none;">Балкаш</span>Балқаш</i></td>
<td><a href="/wiki/1937" title="1937" class="mw-redirect">1937</a></td>
<td align="right">78145</td>
<td align="right">86742</td>
<td align="right">81100</td>
<td align="right">86897</td>
<td align="right">69 665</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%91%D1%83%D0%BB%D0%B0%D0%B5%D0%B2%D0%BE" title="Булаево">Булаево</a></td>
<td>Булаево</td>
<td><i>Булаево</i></td>
<td><a href="/wiki/1969" title="1969" class="mw-redirect">1969</a></td>
<td align="right"></td>
<td align="right">11300</td>
<td align="right">9900</td>
<td align="right">10560</td>
<td align="right">8 153</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%A1%D0%B5%D0%B2%D0%B5%D1%80%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Северо-Казахстанская область">Северо-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%94%D0%B5%D1%80%D0%B6%D0%B0%D0%B2%D0%B8%D0%BD%D1%81%D0%BA" title="Державинск">Державинск</a></td>
<td>Державинск</td>
<td><i>Державинск</i></td>
<td><a href="/wiki/1966" title="1966" class="mw-redirect">1966</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">13300</td>
<td align="right">15096</td>
<td align="right">6 384</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Seal_Zhezkazgan.png?uselang=ru" class="image"><img alt="Seal Zhezkazgan.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Seal_Zhezkazgan.png/30px-Seal_Zhezkazgan.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Seal_Zhezkazgan.png/45px-Seal_Zhezkazgan.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/4/4b/Seal_Zhezkazgan.png/60px-Seal_Zhezkazgan.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%96%D0%B5%D0%B7%D0%BA%D0%B0%D0%B7%D0%B3%D0%B0%D0%BD" title="Жезказган">Жезказган</a></td>
<td>Жезказган</td>
<td><i><span style="display: none; speak: none;">Жезказган</span>Жезқазған</i></td>
<td><a href="/wiki/1954" title="1954" class="mw-redirect">1954</a></td>
<td align="right">89200</td>
<td align="right">107053</td>
<td align="right">103400</td>
<td align="right">112154</td>
<td align="right">85 923</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%96%D0%B8%D1%82%D0%B8%D0%BA%D0%B0%D1%80%D0%B0" title="Житикара">Житикара</a></td>
<td>Житикара</td>
<td><i><span style="display: none; speak: none;">Житыкара</span>Жетіқара</i></td>
<td><a href="/wiki/1939" title="1939" class="mw-redirect">1939</a></td>
<td align="right"></td>
<td align="right">32700</td>
<td align="right">38300</td>
<td align="right">49008</td>
<td align="right">34 204</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%9A%D0%BE%D1%81%D1%82%D0%B0%D0%BD%D0%B0%D0%B9%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Костанайская область">Костанайская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%94%D0%B6%D0%B5%D1%82%D1%8B%D1%81%D0%B0%D0%B9" title="Джетысай" class="mw-redirect">Джетысай</a></td>
<td>Жетысай</td>
<td><i><span style="display: none; speak: none;">Жетисай</span>Жетісай</i></td>
<td><a href="/wiki/1969" title="1969" class="mw-redirect">1969</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">27000</td>
<td align="right">32508</td>
<td align="right">34 905</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%95%D1%80%D0%B5%D0%B9%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%83" title="Ерейментау">Ерейментау</a></td>
<td>Ерейментау</td>
<td><i>Ерейментау</i></td>
<td><a href="/wiki/1965" title="1965" class="mw-redirect">1965</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">13600</td>
<td align="right">15436</td>
<td align="right">11 724</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%95%D1%81%D0%B8%D0%BA" title="Есик">Есик</a></td>
<td>Есик</td>
<td><i><span style="display: none; speak: none;">Есык</span>Есік</i></td>
<td><a href="/wiki/1968" title="1968" class="mw-redirect">1968</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">26200</td>
<td align="right">28339</td>
<td align="right">35 439</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%95%D1%81%D0%B8%D0%BB%D1%8C" title="Есиль">Есиль</a></td>
<td>Есиль</td>
<td><i><span style="display: none; speak: none;">Есыл</span>Есіл</i></td>
<td><a href="/wiki/1963" title="1963" class="mw-redirect">1963</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">15100</td>
<td align="right">13591</td>
<td align="right">11 273</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%96%D0%B0%D0%BD%D0%B0%D0%BE%D0%B7%D0%B5%D0%BD" title="Жанаозен">Жанаозен</a></td>
<td>Жанаозен</td>
<td><i><span style="display: none; speak: none;">Жанаозен</span>Жаңаөзен</i></td>
<td><a href="/wiki/1968" title="1968" class="mw-redirect">1968</a></td>
<td align="right">34000</td>
<td align="right">48300</td>
<td align="right">51100</td>
<td align="right">60796</td>
<td align="right">95 631</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9C%D0%B0%D0%BD%D0%B3%D0%B8%D1%81%D1%82%D0%B0%D1%83%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Мангистауская область">Мангистауская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%96%D0%B0%D0%BD%D0%B0%D1%82%D0%B0%D1%81" title="Жанатас">Жанатас</a></td>
<td>Жанатас</td>
<td><i><span style="display: none; speak: none;">Жанатас</span>Жаңатас</i></td>
<td><a href="/wiki/1969" title="1969" class="mw-redirect">1969</a></td>
<td align="right"></td>
<td align="right">37000</td>
<td align="right">33900</td>
<td align="right">35558</td>
<td align="right">20 759</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%96%D0%B0%D0%BC%D0%B1%D1%8B%D0%BB%D1%8C%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Жамбыльская область" class="mw-redirect">Жамбыльская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%96%D0%B0%D1%80%D0%BA%D0%B5%D0%BD%D1%82" title="Жаркент">Жаркент</a></td>
<td>Жаркент</td>
<td><i>Жаркент</i></td>
<td><a href="/wiki/1891" title="1891" class="mw-redirect">1891</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">34100</td>
<td align="right">36884</td>
<td align="right">43 184</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%96%D0%B5%D0%BC" title="Жем">Жем</a></td>
<td>Жем</td>
<td><i>Жем</i></td>
<td><a href="/wiki/1967" title="1967" class="mw-redirect">1967</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">4351</td>
<td align="right">1 916</td>
<td align="center">5</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%97%D0%B0%D0%B9%D1%81%D0%B0%D0%BD_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Зайсан (город)">Зайсан</a></td>
<td>Зайсан</td>
<td><i>Зайсаң</i></td>
<td><a href="/wiki/1941" title="1941" class="mw-redirect">1941</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">18400</td>
<td align="right">18345</td>
<td align="right">14 937</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%97%D1%8B%D1%80%D1%8F%D0%BD%D0%BE%D0%B2%D1%81%D0%BA" title="Зыряновск">Зыряновск</a></td>
<td>Зыряновск</td>
<td><i>Зыряновск</i></td>
<td><a href="/wiki/1941" title="1941" class="mw-redirect">1941</a></td>
<td align="right">51132</td>
<td align="right">52900</td>
<td align="right">45800</td>
<td align="right">47760</td>
<td align="right">38 544</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9A%D0%B0%D0%B7%D0%B0%D0%BB%D0%B8%D0%BD%D1%81%D0%BA" title="Казалинск">Казалинск</a></td>
<td>Казалинск</td>
<td><i><span style="display: none; speak: none;">Казалы</span>Қазалы</i></td>
<td><a href="/wiki/1867" title="1867" class="mw-redirect">1867</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">6200</td>
<td align="right">7242</td>
<td align="right">7 138</td>
<td align="center">5</td>
<td><a href="/wiki/%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Кызылординская область">Кызылординская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9A%D0%B0%D0%BD%D0%B4%D1%8B%D0%B0%D0%B3%D0%B0%D1%88" title="Кандыагаш">Кандыагаш</a></td>
<td>Кандыагаш</td>
<td><i><span style="display: none; speak: none;">Кандыагаш</span>Қандыағаш</i></td>
<td><a href="/wiki/1967" title="1967" class="mw-redirect">1967</a></td>
<td align="right"></td>
<td align="right">26700</td>
<td align="right">27000</td>
<td align="right">30815</td>
<td align="right">29 909</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9A%D0%B0%D0%BF%D1%87%D0%B0%D0%B3%D0%B0%D0%B9" title="Капчагай">Капчагай</a></td>
<td>Капшагай</td>
<td><i><span style="display: none; speak: none;">Капшагай</span>Қапшағай</i></td>
<td><a href="/wiki/1970" title="1970" class="mw-redirect">1970</a> (?)</td>
<td align="right">25200</td>
<td align="right">37900</td>
<td align="right">39600</td>
<td align="right">46521</td>
<td align="right">41 201</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Karaganda_seal.png?uselang=ru" class="image"><img alt="Karaganda seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Karaganda_seal.png/30px-Karaganda_seal.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Karaganda_seal.png/45px-Karaganda_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Karaganda_seal.png/60px-Karaganda_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B0" title="Караганда">Караганда</a></td>
<td>Караганда</td>
<td><i><span style="display: none; speak: none;">Караганды</span>Қарағанды</i></td>
<td><a href="/wiki/1934" title="1934" class="mw-redirect">1934</a></td>
<td align="right">571877</td>
<td align="right">507318</td>
<td align="right">436864</td>
<td align="right">451800</td>
<td align="right">472 957</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB.png" class="image"><img alt="Герб города Каражал.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/7/7b/%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB.png/30px-%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB.png" width="30" height="37" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/7/7b/%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB.png/45px-%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/7/7b/%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB.png/60px-%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B6%D0%B0%D0%BB" title="Каражал">Каражал</a></td>
<td>Каражал</td>
<td><i><span style="display: none; speak: none;">Каражал</span>Қаражал</i></td>
<td><a href="/wiki/1963" title="1963" class="mw-redirect">1963</a></td>
<td align="right"></td>
<td align="right">18100</td>
<td align="right">15500</td>
<td align="right">15194</td>
<td align="right">9 928</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D1%82%D0%B0%D1%83" title="Каратау" class="mw-redirect">Каратау</a></td>
<td>Каратау</td>
<td><i><span style="display: none; speak: none;">Каратау</span>Қаратау</i></td>
<td><a href="/wiki/1963" title="1963" class="mw-redirect">1963</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">37800</td>
<td align="right">40453</td>
<td align="right">26 902</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%96%D0%B0%D0%BC%D0%B1%D1%8B%D0%BB%D1%8C%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Жамбыльская область" class="mw-redirect">Жамбыльская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%BA%D0%B0%D1%80%D0%B0%D0%BB%D0%B8%D0%BD%D1%81%D0%BA" title="Каркаралинск">Каркаралинск</a></td>
<td>Каркаралинск</td>
<td><i><span style="display: none; speak: none;">Каркаралы</span>Қарқаралы</i></td>
<td><a href="/wiki/1868" title="1868" class="mw-redirect">1868</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">6200</td>
<td align="right">7242</td>
<td align="right">8 947</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%81%D0%BA%D0%B5%D0%BB%D0%B5%D0%BD" title="Каскелен">Каскелен</a></td>
<td>Каскелен</td>
<td><i><span style="display: none; speak: none;">Каскелен</span>Қаскелең</i></td>
<td><a href="/wiki/1963" title="1963" class="mw-redirect">1963</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">30200</td>
<td align="right">32666</td>
<td align="right">59 650</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:%D0%93%D0%B5%D1%80%D0%B1_%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83.png?uselang=ru" class="image"><img alt="Герб Кентау.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/9/9e/%D0%93%D0%B5%D1%80%D0%B1_%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83.png/30px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83.png" width="30" height="47" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/9/9e/%D0%93%D0%B5%D1%80%D0%B1_%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83.png/45px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/9/9e/%D0%93%D0%B5%D1%80%D0%B1_%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83.png/60px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9A%D0%B5%D0%BD%D1%82%D0%B0%D1%83" title="Кентау">Кентау</a></td>
<td>Кентау</td>
<td><i>Кентау</i></td>
<td><a href="/wiki/1955" title="1955" class="mw-redirect">1955</a></td>
<td align="right">62991</td>
<td align="right">63784</td>
<td align="right">58100</td>
<td align="right">60799</td>
<td align="right">59 425</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0.png" class="image"><img alt="Герб города Кызылорда.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/1/14/%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0.png/30px-%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0.png" width="30" height="31" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/1/14/%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0.png/45px-%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/1/14/%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0.png/60px-%D0%93%D0%B5%D1%80%D0%B1_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%B0_%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B0" title="Кызылорда">Кызылорда</a></td>
<td>Кызылорда</td>
<td><i><span style="display: none; speak: none;">Кызылорда</span>Қызылорда</i></td>
<td><a href="/wiki/1867" title="1867" class="mw-redirect">1867</a></td>
<td align="right">156128</td>
<td align="right">150425</td>
<td align="right">157364</td>
<td align="right">182929</td>
<td align="right">195 838</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%9A%D1%8B%D0%B7%D1%8B%D0%BB%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Кызылординская область">Кызылординская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Kokshetau_seal.png?uselang=ru" class="image"><img alt="Kokshetau seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Kokshetau_seal.png/30px-Kokshetau_seal.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Kokshetau_seal.png/45px-Kokshetau_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Kokshetau_seal.png/60px-Kokshetau_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9A%D0%BE%D0%BA%D1%88%D0%B5%D1%82%D0%B0%D1%83" title="Кокшетау">Кокшетау</a></td>
<td>Кокшетау</td>
<td><i><span style="display: none; speak: none;">Кокшетау</span>Көкшетау</i></td>
<td><a href="/wiki/1832" title="1832" class="mw-redirect">1832</a></td>
<td align="right">103162</td>
<td align="right">135424</td>
<td align="right">123389</td>
<td align="right">132753</td>
<td align="right">137 214</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9A%D1%83%D0%BB%D1%8C%D1%81%D0%B0%D1%80%D1%8B" title="Кульсары">Кульсары</a></td>
<td>Кульсары</td>
<td><i>Құлсары</i></td>
<td><a href="/wiki/2001" title="2001" class="mw-redirect">2001</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">39700</td>
<td align="right">44654</td>
<td align="right">52 777</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D1%82%D1%8B%D1%80%D0%B0%D1%83%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Атырауская область">Атырауская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coat_of_arms_of_Kurchatov_Kazakhstan.svg?uselang=ru" class="image"><img alt="Coat of arms of Kurchatov Kazakhstan.svg" src="//upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Coat_of_arms_of_Kurchatov_Kazakhstan.svg/30px-Coat_of_arms_of_Kurchatov_Kazakhstan.svg.png" width="30" height="38" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Coat_of_arms_of_Kurchatov_Kazakhstan.svg/45px-Coat_of_arms_of_Kurchatov_Kazakhstan.svg.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Coat_of_arms_of_Kurchatov_Kazakhstan.svg/60px-Coat_of_arms_of_Kurchatov_Kazakhstan.svg.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9A%D1%83%D1%80%D1%87%D0%B0%D1%82%D0%BE%D0%B2_(%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C)" title="Курчатов (Восточно-Казахстанская область)" class="mw-redirect">Курчатов</a></td>
<td>Курчатов</td>
<td><i>Курчатов</i></td>
<td><a href="/wiki/1948" title="1948" class="mw-redirect">1948</a></td>
<td align="right">10 836</td>
<td align="right">16300</td>
<td align="right">13900</td>
<td align="right">13664</td>
<td align="right">10 836</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Kostanay_city_seal.gif?uselang=ru" class="image"><img alt="Kostanay city seal.gif" src="//upload.wikimedia.org/wikipedia/commons/thumb/5/53/Kostanay_city_seal.gif/30px-Kostanay_city_seal.gif" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/5/53/Kostanay_city_seal.gif/45px-Kostanay_city_seal.gif 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/5/53/Kostanay_city_seal.gif/60px-Kostanay_city_seal.gif 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9A%D0%BE%D1%81%D1%82%D0%B0%D0%BD%D0%B0%D0%B9" title="Костанай">Костанай</a></td>
<td>Костанай</td>
<td><i>Қостанай</i></td>
<td><a href="/wiki/1893" title="1893" class="mw-redirect">1893</a></td>
<td align="right">164500</td>
<td align="right">223558</td>
<td align="right">221429</td>
<td align="right">249395</td>
<td align="right">215 346</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%9A%D0%BE%D1%81%D1%82%D0%B0%D0%BD%D0%B0%D0%B9%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Костанайская область">Костанайская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9B%D0%B5%D0%BD%D0%B3%D0%B5%D1%80" title="Ленгер">Ленгер</a></td>
<td>Ленгер</td>
<td><i>Ленгер</i></td>
<td><a href="/wiki/1945" title="1945" class="mw-redirect">1945</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">19600</td>
<td align="right">23599</td>
<td align="right">24 860</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Lissakowsk_seal.png?uselang=ru" class="image"><img alt="Lissakowsk seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Lissakowsk_seal.png/30px-Lissakowsk_seal.png" width="30" height="41" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Lissakowsk_seal.png/45px-Lissakowsk_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Lissakowsk_seal.png/60px-Lissakowsk_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9B%D0%B8%D1%81%D0%B0%D0%BA%D0%BE%D0%B2%D1%81%D0%BA" title="Лисаковск">Лисаковск</a></td>
<td>Лисаковск</td>
<td><i>Лисаковск</i></td>
<td><a href="/wiki/1971" title="1971" class="mw-redirect">1971</a></td>
<td align="right"></td>
<td align="right">33400</td>
<td align="right">32800</td>
<td align="right">36178</td>
<td align="right">36 630</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%9A%D0%BE%D1%81%D1%82%D0%B0%D0%BD%D0%B0%D0%B9%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Костанайская область">Костанайская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9C%D0%B0%D0%BA%D0%B8%D0%BD%D1%81%D0%BA" title="Макинск">Макинск</a></td>
<td>Макинск</td>
<td><i>Макинск</i></td>
<td><a href="/wiki/1945" title="1945" class="mw-redirect">1945</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">17000</td>
<td align="right">19295</td>
<td align="right">16 763</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%9C%D0%B0%D0%BC%D0%BB%D1%8E%D1%82%D0%BA%D0%B0" title="Мамлютка">Мамлютка</a></td>
<td>Мамлютка</td>
<td><i>Мамлют</i></td>
<td><a href="/wiki/1969" title="1969" class="mw-redirect">1969</a></td>
<td align="right"></td>
<td align="right">11500</td>
<td align="right">9600</td>
<td align="right">9825</td>
<td align="right">7 450</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%A1%D0%B5%D0%B2%D0%B5%D1%80%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Северо-Казахстанская область">Северо-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D0%B0.png?uselang=ru" class="image"><img alt="Герб Павлодара.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/d/d7/%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D0%B0.png/30px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D0%B0.png" width="30" height="36" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/d/d7/%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D0%B0.png/45px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D0%B0.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/d/d7/%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D0%B0.png/60px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D0%B0.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80" title="Павлодар">Павлодар</a></td>
<td>Павлодар</td>
<td><i>Павлодар</i></td>
<td><a href="/wiki/1861" title="1861" class="mw-redirect">1861</a></td>
<td align="right">272895</td>
<td align="right">329681</td>
<td align="right">320400</td>
<td align="right">354809</td>
<td align="right">321 815</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Павлодарская область">Павлодарская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Seal_Petropavl.svg?uselang=ru" class="image"><img alt="Seal Petropavl.svg" src="//upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Seal_Petropavl.svg/30px-Seal_Petropavl.svg.png" width="30" height="31" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Seal_Petropavl.svg/45px-Seal_Petropavl.svg.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Seal_Petropavl.svg/60px-Seal_Petropavl.svg.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9F%D0%B5%D1%82%D1%80%D0%BE%D0%BF%D0%B0%D0%B2%D0%BB%D0%BE%D0%B2%D1%81%D0%BA" title="Петропавловск">Петропавловск</a></td>
<td>Петропавловск</td>
<td><i>Петропавл</i></td>
<td><a href="/wiki/1807" title="1807" class="mw-redirect">1807</a></td>
<td align="right">206559</td>
<td align="right">239606</td>
<td align="right">216300</td>
<td align="right">208547</td>
<td align="right">203 192</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%A1%D0%B5%D0%B2%D0%B5%D1%80%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Северо-Казахстанская область">Северо-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA%D0%B0.png" class="image"><img alt="Герб Приозёрска.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/8/82/%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA%D0%B0.png/30px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA%D0%B0.png" width="30" height="43" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/8/82/%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA%D0%B0.png/45px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA%D0%B0.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/8/82/%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA%D0%B0.png/60px-%D0%93%D0%B5%D1%80%D0%B1_%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA%D0%B0.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%9F%D1%80%D0%B8%D0%BE%D0%B7%D1%91%D1%80%D1%81%D0%BA_(%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD)" title="Приозёрск (Казахстан)" class="mw-redirect">Приозёрск</a></td>
<td>Приозёрск</td>
<td><i>Приозёрск</i></td>
<td><a href="/wiki/1961" title="1961" class="mw-redirect">1961</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">19724</td>
<td align="right">13 518</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Ridder,_Kazakhstan_CoA.jpg?uselang=ru" class="image"><img alt="Ridder, Kazakhstan CoA.jpg" src="//upload.wikimedia.org/wikipedia/commons/thumb/5/58/Ridder%2C_Kazakhstan_CoA.jpg/30px-Ridder%2C_Kazakhstan_CoA.jpg" width="30" height="29" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/5/58/Ridder%2C_Kazakhstan_CoA.jpg/45px-Ridder%2C_Kazakhstan_CoA.jpg 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/5/58/Ridder%2C_Kazakhstan_CoA.jpg/60px-Ridder%2C_Kazakhstan_CoA.jpg 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A0%D0%B8%D0%B4%D0%B4%D0%B5%D1%80" title="Риддер">Риддер</a></td>
<td>Риддер</td>
<td><i>Риддер</i></td>
<td><a href="/wiki/1934" title="1934" class="mw-redirect">1934</a></td>
<td align="right">68135</td>
<td align="right">68730</td>
<td align="right">56269</td>
<td align="right">54252</td>
<td align="right">49 705</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coat_of_arms_of_Rudnyi.png?uselang=ru" class="image"><img alt="Coat of arms of Rudnyi.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Coat_of_arms_of_Rudnyi.png/30px-Coat_of_arms_of_Rudnyi.png" width="30" height="47" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Coat_of_arms_of_Rudnyi.png/45px-Coat_of_arms_of_Rudnyi.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Coat_of_arms_of_Rudnyi.png/60px-Coat_of_arms_of_Rudnyi.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A0%D1%83%D0%B4%D0%BD%D1%8B%D0%B9" title="Рудный">Рудный</a></td>
<td>Рудный</td>
<td><i>Рудный</i></td>
<td><a href="/wiki/1957" title="1957" class="mw-redirect">1957</a></td>
<td align="right">109707</td>
<td align="right">125245</td>
<td align="right">117300</td>
<td align="right">126007</td>
<td align="right">111 686</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%BE%D1%81%D1%82%D0%B0%D0%BD%D0%B0%D0%B9%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Костанайская область">Костанайская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%A1%D0%BE%D1%80%D0%B0%D2%A3.png" class="image"><img alt="Сораң.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/2/20/%D0%A1%D0%BE%D1%80%D0%B0%D2%A3.png/30px-%D0%A1%D0%BE%D1%80%D0%B0%D2%A3.png" width="30" height="42" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/2/20/%D0%A1%D0%BE%D1%80%D0%B0%D2%A3.png/45px-%D0%A1%D0%BE%D1%80%D0%B0%D2%A3.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/2/20/%D0%A1%D0%BE%D1%80%D0%B0%D2%A3.png/60px-%D0%A1%D0%BE%D1%80%D0%B0%D2%A3.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A1%D0%B0%D1%80%D0%B0%D0%BD%D1%8C" title="Сарань">Сарань</a></td>
<td>Сарань</td>
<td><i>Сараң</i></td>
<td><a href="/wiki/1954" title="1954" class="mw-redirect">1954</a></td>
<td align="right">54878</td>
<td align="right">63900</td>
<td align="right">48500</td>
<td align="right">49082</td>
<td align="right">42 074</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A1%D0%B0%D1%80%D0%BA%D0%B0%D0%BD%D0%B4" title="Сарканд">Сарканд</a></td>
<td>Сарканд</td>
<td><i><span style="display: none; speak: none;">Саркан</span>Сарқан</i></td>
<td><a href="/wiki/1968" title="1968" class="mw-redirect">1968</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">16200</td>
<td align="right"></td>
<td align="right">14 312</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A1%D0%B0%D1%80%D1%8B%D0%B0%D0%B3%D0%B0%D1%88" title="Сарыагаш">Сарыагаш</a></td>
<td>Сарыагаш</td>
<td><i>Сарыағаш</i></td>
<td><a href="/wiki/1945" title="1945" class="mw-redirect">1945</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">23200</td>
<td align="right">27933</td>
<td align="right">39 720</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%A1%D3%99%D1%82%D0%B1%D0%B0%D0%B5%D0%B2.png" class="image"><img alt="Сәтбаев.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/b/b5/%D0%A1%D3%99%D1%82%D0%B1%D0%B0%D0%B5%D0%B2.png/30px-%D0%A1%D3%99%D1%82%D0%B1%D0%B0%D0%B5%D0%B2.png" width="30" height="29" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/b/b5/%D0%A1%D3%99%D1%82%D0%B1%D0%B0%D0%B5%D0%B2.png/45px-%D0%A1%D3%99%D1%82%D0%B1%D0%B0%D0%B5%D0%B2.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/b/b5/%D0%A1%D3%99%D1%82%D0%B1%D0%B0%D0%B5%D0%B2.png/60px-%D0%A1%D3%99%D1%82%D0%B1%D0%B0%D0%B5%D0%B2.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A1%D0%B0%D1%82%D0%BF%D0%B0%D0%B5%D0%B2_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Сатпаев (город)">Сатпаев</a></td>
<td>Сатпаев</td>
<td><i><span style="display: none; speak: none;">Сатбаев</span>Сәтбаев</i></td>
<td><a href="/wiki/1973" title="1973" class="mw-redirect">1973</a></td>
<td align="right">48700</td>
<td align="right">59343</td>
<td align="right">62900</td>
<td align="right">73874</td>
<td align="right">61 276</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Semey_Seal.png?uselang=ru" class="image"><img alt="Semey Seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/3/30/Semey_Seal.png/30px-Semey_Seal.png" width="30" height="39" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/3/30/Semey_Seal.png/45px-Semey_Seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/3/30/Semey_Seal.png/60px-Semey_Seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A1%D0%B5%D0%BC%D0%B8%D0%BF%D0%B0%D0%BB%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA" title="Семипалатинск" class="mw-redirect">Семипалатинск</a></td>
<td>Семей</td>
<td><i>Семей</i></td>
<td><a href="/wiki/1782" title="1782" class="mw-redirect">1782</a></td>
<td align="right">282574</td>
<td align="right">317112</td>
<td align="right">292500</td>
<td align="right">312136</td>
<td align="right">303 878</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%93%D0%B5%D1%80%D0%B1_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B8.png" class="image"><img alt="Герб Сергеевки.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/7/79/%D0%93%D0%B5%D1%80%D0%B1_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B8.png/30px-%D0%93%D0%B5%D1%80%D0%B1_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B8.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/7/79/%D0%93%D0%B5%D1%80%D0%B1_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B8.png/45px-%D0%93%D0%B5%D1%80%D0%B1_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B8.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/7/79/%D0%93%D0%B5%D1%80%D0%B1_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B8.png/60px-%D0%93%D0%B5%D1%80%D0%B1_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B8.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%BA%D0%B0_(%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD)" title="Сергеевка (Казахстан)">Сергеевка</a></td>
<td>Сергеевка</td>
<td><i>Сергеевка</i></td>
<td><a href="/wiki/1969" title="1969" class="mw-redirect">1969</a></td>
<td align="right"></td>
<td align="right">13000</td>
<td align="right">9700</td>
<td align="right">9016</td>
<td align="right">7 613</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%A1%D0%B5%D0%B2%D0%B5%D1%80%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Северо-Казахстанская область">Северо-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A1%D0%B5%D1%80%D0%B5%D0%B1%D1%80%D1%8F%D0%BD%D1%81%D0%BA" title="Серебрянск">Серебрянск</a></td>
<td>Серебрянск</td>
<td><i>Серебрянск</i></td>
<td><a href="/wiki/1962" title="1962" class="mw-redirect">1962</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">12000</td>
<td align="right">11964</td>
<td align="right">9 779</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A1%D1%82%D0%B5%D0%BF%D0%BD%D0%BE%D0%B3%D0%BE%D1%80%D1%81%D0%BA" title="Степногорск">Степногорск</a></td>
<td>Степногорск</td>
<td><i>Степногорск</i></td>
<td><a href="/wiki/1964" title="1964" class="mw-redirect">1964</a></td>
<td align="right">46700</td>
<td align="right">63300</td>
<td align="right">50900</td>
<td align="right">47705</td>
<td align="right">46 399</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A1%D1%82%D0%B5%D0%BF%D0%BD%D1%8F%D0%BA" title="Степняк">Степняк</a></td>
<td>Степняк</td>
<td><i>Степняк</i></td>
<td><a href="/wiki/1937" title="1937" class="mw-redirect">1937</a></td>
<td align="right"></td>
<td align="right">6800</td>
<td align="right">5400</td>
<td align="right">5016</td>
<td align="right">4 136</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A2%D0%B0%D0%B9%D1%8B%D0%BD%D1%88%D0%B0" title="Тайынша">Тайынша</a></td>
<td>Тайынша</td>
<td><i>Тайынша</i></td>
<td><a href="/wiki/1962" title="1962" class="mw-redirect">1962</a></td>
<td align="right"></td>
<td align="right">16100</td>
<td align="right">13500</td>
<td align="right">13865</td>
<td align="right">12 028</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%A1%D0%B5%D0%B2%D0%B5%D1%80%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Северо-Казахстанская область">Северо-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A2%D0%B0%D0%BB%D0%B3%D0%B0%D1%80" title="Талгар">Талгар</a></td>
<td>Талгар</td>
<td><i><span style="display: none; speak: none;">Талгар</span>Талғар</i></td>
<td><a href="/wiki/1959" title="1959" class="mw-redirect">1959</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">41800</td>
<td align="right">45213</td>
<td align="right">46 201</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Taldykorgan_seal.png?uselang=ru" class="image"><img alt="Taldykorgan seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Taldykorgan_seal.png/30px-Taldykorgan_seal.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Taldykorgan_seal.png/45px-Taldykorgan_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Taldykorgan_seal.png/60px-Taldykorgan_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A2%D0%B0%D0%BB%D0%B4%D1%8B%D0%BA%D0%BE%D1%80%D0%B3%D0%B0%D0%BD" title="Талдыкорган">Талдыкорган</a></td>
<td>Талдыкорган</td>
<td><i>Талдықорған</i></td>
<td><a href="/wiki/1944" title="1944" class="mw-redirect">1944</a></td>
<td align="right">87948</td>
<td align="right">118623</td>
<td align="right">107100</td>
<td align="right">114728</td>
<td align="right">126 944</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Seal_Taraz.png?uselang=ru" class="image"><img alt="Seal Taraz.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Seal_Taraz.png/30px-Seal_Taraz.png" width="30" height="43" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Seal_Taraz.png/45px-Seal_Taraz.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Seal_Taraz.png/60px-Seal_Taraz.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A2%D0%B0%D1%80%D0%B0%D0%B7" title="Тараз">Тараз</a></td>
<td>Тараз</td>
<td><i>Тараз</i></td>
<td><span style="display: none; speak: none;">1000</span><small><a href="/wiki/%D0%94%D1%80%D0%B5%D0%B2%D0%BD%D0%B8%D0%B9_%D0%BC%D0%B8%D1%80" title="Древний мир">древности</a></small></td>
<td align="right">263793</td>
<td align="right">303961</td>
<td align="right">330125</td>
<td align="right">398233</td>
<td align="right">327 180</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%96%D0%B0%D0%BC%D0%B1%D1%8B%D0%BB%D1%8C%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Жамбыльская область" class="mw-redirect">Жамбыльская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coats_of_arms_of_Tekeli.png?uselang=ru" class="image"><img alt="Coats of arms of Tekeli.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Coats_of_arms_of_Tekeli.png/30px-Coats_of_arms_of_Tekeli.png" width="30" height="43" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Coats_of_arms_of_Tekeli.png/45px-Coats_of_arms_of_Tekeli.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Coats_of_arms_of_Tekeli.png/60px-Coats_of_arms_of_Tekeli.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A2%D0%B5%D0%BA%D0%B5%D0%BB%D0%B8" title="Текели">Текели</a></td>
<td>Текели</td>
<td><i>Текелі</i></td>
<td><a href="/wiki/1952" title="1952" class="mw-redirect">1952</a></td>
<td align="right"></td>
<td align="right">31200</td>
<td align="right">24700</td>
<td align="right">22840</td>
<td align="right">26 976</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A2%D0%B5%D0%BC%D0%B8%D1%80_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Темир (город)">Темир</a></td>
<td>Темир</td>
<td><i><span style="display: none; speak: none;">Темыр</span>Темір</i></td>
<td><a href="/wiki/1896" title="1896" class="mw-redirect">1896</a></td>
<td align="right"></td>
<td align="right">3500</td>
<td align="right">2800</td>
<td align="right">2611</td>
<td align="right">2 576</td>
<td align="center">5</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coat_of_arms_of_Temirtau.svg?uselang=ru" class="image"><img alt="Coat of arms of Temirtau.svg" src="//upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Coat_of_arms_of_Temirtau.svg/30px-Coat_of_arms_of_Temirtau.svg.png" width="30" height="40" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Coat_of_arms_of_Temirtau.svg/45px-Coat_of_arms_of_Temirtau.svg.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Coat_of_arms_of_Temirtau.svg/60px-Coat_of_arms_of_Temirtau.svg.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A2%D0%B5%D0%BC%D0%B8%D1%80%D1%82%D0%B0%D1%83" title="Темиртау">Темиртау</a></td>
<td>Темиртау</td>
<td><i><span style="display: none; speak: none;">Темыртау</span>Теміртау</i></td>
<td><a href="/wiki/1945" title="1945" class="mw-redirect">1945</a></td>
<td align="right">213026</td>
<td align="right">213551</td>
<td align="right">181800</td>
<td align="right">179520</td>
<td align="right">176 588</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="/wiki/%D0%A4%D0%B0%D0%B9%D0%BB:%D0%A2%D2%AF%D1%80%D0%BA%D1%96%D1%81%D1%82%D0%B0%D0%BD.png" class="image"><img alt="Түркістан.png" src="//upload.wikimedia.org/wikipedia/ru/thumb/2/22/%D0%A2%D2%AF%D1%80%D0%BA%D1%96%D1%81%D1%82%D0%B0%D0%BD.png/30px-%D0%A2%D2%AF%D1%80%D0%BA%D1%96%D1%81%D1%82%D0%B0%D0%BD.png" width="30" height="34" srcset="//upload.wikimedia.org/wikipedia/ru/thumb/2/22/%D0%A2%D2%AF%D1%80%D0%BA%D1%96%D1%81%D1%82%D0%B0%D0%BD.png/45px-%D0%A2%D2%AF%D1%80%D0%BA%D1%96%D1%81%D1%82%D0%B0%D0%BD.png 1.5x, //upload.wikimedia.org/wikipedia/ru/thumb/2/22/%D0%A2%D2%AF%D1%80%D0%BA%D1%96%D1%81%D1%82%D0%B0%D0%BD.png/60px-%D0%A2%D2%AF%D1%80%D0%BA%D1%96%D1%81%D1%82%D0%B0%D0%BD.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A2%D1%83%D1%80%D0%BA%D0%B5%D1%81%D1%82%D0%B0%D0%BD_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Туркестан (город)">Туркестан</a></td>
<td>Туркестан</td>
<td><i><span style="display: none; speak: none;">Туркыстан</span>Түркістан</i></td>
<td><span style="display: none; speak: none;">1000</span><small><a href="/wiki/%D0%94%D1%80%D0%B5%D0%B2%D0%BD%D0%B8%D0%B9_%D0%BC%D0%B8%D1%80" title="Древний мир">древности</a></small></td>
<td align="right">66741</td>
<td align="right">77692</td>
<td align="right">87600</td>
<td align="right">109673</td>
<td align="right">146 449</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Oral_seal.png?uselang=ru" class="image"><img alt="Oral seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Oral_seal.png/30px-Oral_seal.png" width="30" height="39" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Oral_seal.png/45px-Oral_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Oral_seal.png/60px-Oral_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A3%D1%80%D0%B0%D0%BB%D1%8C%D1%81%D0%BA" title="Уральск">Уральск</a></td>
<td>Уральск</td>
<td><i>Орал</i></td>
<td><a href="/wiki/1613" title="1613" class="mw-redirect">1613</a></td>
<td align="right">167352</td>
<td align="right">199522</td>
<td align="right">212900</td>
<td align="right">255489</td>
<td align="right">210 128</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%97%D0%B0%D0%BF%D0%B0%D0%B4%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Западно-Казахстанская область">Западно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Oskemen_seal.jpg?uselang=ru" class="image"><img alt="Oskemen seal.jpg" src="//upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Oskemen_seal.jpg/30px-Oskemen_seal.jpg" width="30" height="41" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Oskemen_seal.jpg/45px-Oskemen_seal.jpg 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Oskemen_seal.jpg/60px-Oskemen_seal.jpg 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A3%D1%81%D1%82%D1%8C-%D0%9A%D0%B0%D0%BC%D0%B5%D0%BD%D0%BE%D0%B3%D0%BE%D1%80%D1%81%D0%BA" title="Усть-Каменогорск">Усть-Каменогорск</a></td>
<td>Усть-Каменогорск</td>
<td><i><span style="display: none; speak: none;">Оскемен</span>Өскемен</i></td>
<td><a href="/wiki/1868" title="1868" class="mw-redirect">1868</a></td>
<td align="right">274287</td>
<td align="right">322221</td>
<td align="right">310950</td>
<td align="right">344421</td>
<td align="right">306 588</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A3%D1%87%D0%B0%D1%80%D0%B0%D0%BB" title="Учарал" class="mw-redirect">Учарал</a></td>
<td>Ушарал</td>
<td><i><span style="display: none; speak: none;">Ушарал</span>Үшарал</i></td>
<td><a href="/wiki/1984" title="1984" class="mw-redirect">1984</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">15900</td>
<td align="right">17198</td>
<td align="right">16 331</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A3%D1%88%D1%82%D0%BE%D0%B1%D0%B5" title="Уштобе">Уштобе</a></td>
<td>Уштобе</td>
<td><i><span style="display: none; speak: none;">Уштобе</span>Үштөбе</i></td>
<td><a href="/wiki/1961" title="1961" class="mw-redirect">1961</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">20300</td>
<td align="right">21957</td>
<td align="right">24 755</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BB%D0%BC%D0%B0%D1%82%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Алматинская область">Алматинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Fort-Shevchenko_coa.gif?uselang=ru" class="image"><img alt="Fort-Shevchenko coa.gif" src="//upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Fort-Shevchenko_coa.gif/30px-Fort-Shevchenko_coa.gif" width="30" height="39" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Fort-Shevchenko_coa.gif/45px-Fort-Shevchenko_coa.gif 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Fort-Shevchenko_coa.gif/60px-Fort-Shevchenko_coa.gif 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A4%D0%BE%D1%80%D1%82-%D0%A8%D0%B5%D0%B2%D1%87%D0%B5%D0%BD%D0%BA%D0%BE" title="Форт-Шевченко">Форт-Шевченко</a></td>
<td>Форт-Шевченко</td>
<td><i>Форт-Шевченко</i></td>
<td><a href="/wiki/1899" title="1899" class="mw-redirect">1899</a></td>
<td align="right"></td>
<td align="right">3500</td>
<td align="right">4400</td>
<td align="right">6076</td>
<td align="right">5 000</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9C%D0%B0%D0%BD%D0%B3%D0%B8%D1%81%D1%82%D0%B0%D1%83%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Мангистауская область">Мангистауская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A5%D1%80%D0%BE%D0%BC%D1%82%D0%B0%D1%83" title="Хромтау">Хромтау</a></td>
<td>Хромтау</td>
<td><i>Хромтау</i></td>
<td><a href="/wiki/1967" title="1967" class="mw-redirect">1967</a></td>
<td align="right"></td>
<td align="right">24400</td>
<td align="right">23400</td>
<td align="right">25518</td>
<td align="right">24 421</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A7%D0%B0%D1%80%D0%B4%D0%B0%D1%80%D0%B0" title="Чардара" class="mw-redirect">Чардара</a></td>
<td>Шардара</td>
<td><i>Шардара</i></td>
<td><a href="/wiki/1968" title="1968" class="mw-redirect">1968</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">23400</td>
<td align="right">28174</td>
<td align="right">30 845</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A7%D0%B0%D1%80%D1%81%D0%BA_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Чарск (город)">Чарск</a></td>
<td>Шар</td>
<td><i>Шар</i></td>
<td><a href="/wiki/1963" title="1963" class="mw-redirect">1963</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">9500</td>
<td align="right">9471</td>
<td align="right">7 992</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A7%D0%B5%D0%BB%D0%BA%D0%B0%D1%80" title="Челкар">Челкар</a></td>
<td>Шалкар</td>
<td><i>Шалқар</i></td>
<td><a href="/wiki/1928" title="1928" class="mw-redirect">1928</a></td>
<td align="right"></td>
<td align="right">28900</td>
<td align="right">28700</td>
<td align="right">32250</td>
<td align="right">26 869</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82.png?uselang=ru" class="image"><img alt="Шымкент.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/7/78/%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82.png/30px-%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82.png" width="30" height="30" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/7/78/%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82.png/45px-%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/7/78/%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82.png/60px-%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A8%D1%8B%D0%BC%D0%BA%D0%B5%D0%BD%D1%82" title="Шымкент">Шымкент</a></td>
<td>Шымкент</td>
<td><i>Шымкент</i></td>
<td><span style="display: none; speak: none;">1400</span><small><a href="/wiki/%D0%A1%D1%80%D0%B5%D0%B4%D0%BD%D0%B8%D0%B5_%D0%B2%D0%B5%D0%BA%D0%B0" title="Средние века">средних веков</a></small></td>
<td align="right">321535</td>
<td align="right">380091</td>
<td align="right">390200</td>
<td align="right">454583</td>
<td align="right">625 110</td>
<td align="center">2</td>
<td><a href="/wiki/%D0%AE%D0%B6%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Южно-Казахстанская область">Южно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Coat_of_arms_of_Shahtinsk.png?uselang=ru" class="image"><img alt="Coat of arms of Shahtinsk.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/1/13/Coat_of_arms_of_Shahtinsk.png/30px-Coat_of_arms_of_Shahtinsk.png" width="30" height="42" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/1/13/Coat_of_arms_of_Shahtinsk.png/45px-Coat_of_arms_of_Shahtinsk.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/1/13/Coat_of_arms_of_Shahtinsk.png/60px-Coat_of_arms_of_Shahtinsk.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%A8%D0%B0%D1%85%D1%82%D0%B8%D0%BD%D1%81%D0%BA" title="Шахтинск">Шахтинск</a></td>
<td>Шахтинск</td>
<td><i>Шахтинск</i></td>
<td><a href="/wiki/1961" title="1961" class="mw-redirect">1961</a></td>
<td align="right">50382</td>
<td align="right">65600</td>
<td align="right">54800</td>
<td align="right">54748</td>
<td align="right">36 510</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9A%D0%B0%D1%80%D0%B0%D0%B3%D0%B0%D0%BD%D0%B4%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Карагандинская область">Карагандинская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A8%D0%B5%D0%BC%D0%BE%D0%BD%D0%B0%D0%B8%D1%85%D0%B0" title="Шемонаиха">Шемонаиха</a></td>
<td>Шемонаиха</td>
<td><i>Шемонаиха</i></td>
<td><a href="/wiki/1961" title="1961" class="mw-redirect">1961</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">21000</td>
<td align="right">20937</td>
<td align="right">18 814</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%92%D0%BE%D1%81%D1%82%D0%BE%D1%87%D0%BD%D0%BE-%D0%9A%D0%B0%D0%B7%D0%B0%D1%85%D1%81%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Восточно-Казахстанская область">Восточно-Казахстанская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A8%D1%83_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Шу (город)">Шу</a></td>
<td>Шу</td>
<td><i><span style="display: none; speak: none;">Шу</span>Шу</i></td>
<td><a href="/wiki/1960" title="1960" class="mw-redirect">1960</a></td>
<td align="right"></td>
<td align="right"></td>
<td align="right">39700</td>
<td align="right">42486</td>
<td align="right">36 010</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%96%D0%B0%D0%BC%D0%B1%D1%8B%D0%BB%D1%8C%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Жамбыльская область" class="mw-redirect">Жамбыльская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%A9%D1%83%D1%87%D0%B8%D0%BD%D1%81%D0%BA" title="Щучинск">Щучинск</a></td>
<td>Щучинск</td>
<td><i>Щучинск</i></td>
<td><a href="/wiki/1939" title="1939" class="mw-redirect">1939</a></td>
<td align="right"></td>
<td align="right">55500</td>
<td align="right">47900</td>
<td align="right">50128</td>
<td align="right">44 547</td>
<td align="center">4</td>
<td><a href="/wiki/%D0%90%D0%BA%D0%BC%D0%BE%D0%BB%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Акмолинская область">Акмолинская область</a></td>
</tr>
<tr style="height:60px">
<td>
<div class="center">
<div class="floatnone"><a href="//commons.wikimedia.org/wiki/File:Ekibastuz_seal.png?uselang=ru" class="image"><img alt="Ekibastuz seal.png" src="//upload.wikimedia.org/wikipedia/commons/thumb/7/72/Ekibastuz_seal.png/30px-Ekibastuz_seal.png" width="30" height="42" srcset="//upload.wikimedia.org/wikipedia/commons/thumb/7/72/Ekibastuz_seal.png/45px-Ekibastuz_seal.png 1.5x, //upload.wikimedia.org/wikipedia/commons/thumb/7/72/Ekibastuz_seal.png/60px-Ekibastuz_seal.png 2x"></a></div>
</div>
</td>
<td><a href="/wiki/%D0%AD%D0%BA%D0%B8%D0%B1%D0%B0%D1%81%D1%82%D1%83%D0%B7" title="Экибастуз">Экибастуз</a></td>
<td>Экибастуз</td>
<td><i>Екібастұз</i></td>
<td><a href="/wiki/1957" title="1957" class="mw-redirect">1957</a></td>
<td align="right">65871</td>
<td align="right">135006</td>
<td align="right">137200</td>
<td align="right">158165</td>
<td align="right">126 538</td>
<td align="center">3</td>
<td><a href="/wiki/%D0%9F%D0%B0%D0%B2%D0%BB%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Павлодарская область">Павлодарская область</a></td>
</tr>
<tr style="height:60px">
<td></td>
<td><a href="/wiki/%D0%AD%D0%BC%D0%B1%D0%B0_(%D0%B3%D0%BE%D1%80%D0%BE%D0%B4)" title="Эмба (город)">Эмба</a></td>
<td>Эмба</td>
<td><i>Эмбі</i></td>
<td><a href="/wiki/1967" title="1967" class="mw-redirect">1967</a></td>
<td align="right"></td>
<td align="right">15000</td>
<td align="right">16900</td>
<td align="right">21163</td>
<td align="right">11 252</td>
<td align="center">5</td>
<td><a href="/wiki/%D0%90%D0%BA%D1%82%D1%8E%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F_%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C" title="Актюбинская область">Актюбинская область</a></td>
</tr>
</tbody><tfoot></tfoot></table></body></html>';

        $document = phpQuery::newDocument($html);

        $cities = array();
        foreach ($document->find('tr') as $row){
            $cities [] = pq($row)->find('td:eq(1)')->text()."\n";
        }

        Yii::import('site.frontend.modules.geo.models.*');
        foreach ($cities as $city) {
            $city = trim($city);
            $model = GeoCity::model()->find('country_id=109 AND name="' . $city . '"');
            if ($model !== null) {
                $model->type = 'г';
                $model->update(array('type'));
            }else{
                echo $city."<br>";
            }
        }
    }
}