<?php

class HController extends CController
{
    public $menu = array();
    public $breadcrumbs = array();
    public $rssFeed = null;
    public $seoHrefs = array();
    public $seoContent = array();
    public $registerUserModel = null;
    public $registerUserData = null;

    public $meta_description = '';
    public $meta_keywords = null;
    public $meta_title = null;
    public $page_meta_model = null;

    public $pGallery = null;
    public $broadcast = false;

    public $body_class = 'body-club';

    protected $r = 159;

    public function filterAjaxOnly($filterChain)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest())
            $filterChain->run();
        else
            throw new CHttpException(404, Yii::t('yii', 'Your request is invalid.'));
    }

    public function init()
    {
        parent::init();

        require_once('mobiledetect/Mobile_Detect.php');

        $this->combineStatic();
        Yii::app()->clientScript
            ->registerCssFile('/stylesheets/common.css?'.$this->r)
            ->registerCssFile('/stylesheets/global.css?'.$this->r)
        ;
    }

    protected function beforeAction($action)
    {
        $this->_mobileRedirect();

        // отключение повторной подгрузки jquery
        /* if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery.yiiactiveform.js' => false,
                'jquery.ba-bbq.js' => false,
                'jquery.yiilistview.js' => false,
            );
        } */

        // noindex для дева
        if ($_SERVER['HTTP_HOST'] == 'dev.happy-giraffe.ru') {
            Yii::app()->clientScript->registerMetaTag('noindex,nofollow', 'robots');
        }

        if (!Yii::app()->user->isGuest && (Yii::app()->user->model->blocked == 1 || Yii::app()->user->model->deleted == 1))
            Yii::app()->user->logout();

        // авторизация
        if (isset($this->actionParams['token'])) {
            if (($user_id = UserToken::model()->useToken($this->actionParams['token'])) !== false) {
                $identity = new SafeUserIdentity($user_id);
                if ($identity->authenticate())
                    Yii::app()->user->login($identity);
            }
            unset($_GET['token']);
        }

        $received_params = array('utm_source',
            'utm_medium',
            'im_interlocutor_id',
            'im_type',
            'openSettings',
            'fb_action_ids',
            'fb_action_types',
            'fb_source',
            'action_object_map'
        );

        // seo-фильтр get-параметров
        if (in_array($this->uniqueId, array(
            'blog',
            'community',
            'services/horoscope/default',
            'services/childrenDiseases/default',
            'cook/spices',
            'cook/choose',
        )) || in_array($this->route, array('cook/recipe/view', 'cook/recipe/index'))
        ) {
            $reflector = new ReflectionClass($this);
            $parametersObjects = $reflector->getMethod('action' . $this->action->id)->getParameters();
            $parametersNames = array();
            foreach ($parametersObjects as $p)
                $parametersNames[] = $p->name;
            foreach ($this->actionParams as $p => $v)
                if (array_search($p, $parametersNames) === false && strpos($p, '_page') === false && !in_array($p, $received_params))
                    throw new CHttpException(404, 'Такой записи не существует');
        }

        // мета-теги
        $this->setMetaTags();


        if (Yii::app()->user->getState('redirect_to') != null){
            Yii::app()->clientScript->registerScript('redirect_to','HGoTo("'.Yii::app()->user->getState('redirect_to').'");');
            Yii::app()->user->setState('redirect_to', null);
        }

        return parent::beforeAction($action);
    }

    protected function afterRender($view, &$output)
    {
        $js = '$(function() {
                var seoHrefs = ' . CJSON::encode($this->seoHrefs) . ';
                var seoContent = ' . CJSON::encode($this->seoContent) . ';
                var $elements = $("[data-key]");
                for(var i = 0, count = $elements.length; i < count; i++) {
                    var $element = $elements.eq(i);
                    var key = $element.data("key");
                    switch($element.data("type")) {
                        case "href":
                            $element.attr("href", Base64.decode(seoHrefs[key]));
                            break;
                        case "content":
                            $element.replaceWith(Base64.decode(seoContent[key]));
                            break;
                    }
                }
            });';

        $hash = md5($js);
        $cacheId = 'seoHide_' . $hash;
        Yii::app()->cache->set($cacheId, $js);

        Yii::app()->clientScript->registerScriptFile('/js_dynamics/' . $hash . '.js/', CClientScript::POS_END);

        return parent::afterRender($view, $output);
    }

    public function getViews()
    {
        $path = '/' . Yii::app()->request->pathInfo . '/';

        return PageView::model()->incViewsByPath($path);
    }

    public function setMetaTags()
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->page_meta_model = PageMetaTag::getModel(Yii::app()->controller->route, Yii::app()->controller->actionParams);
            if ($this->page_meta_model !== null) {
                if (!empty($this->page_meta_model->description))
                    $this->meta_description = $this->page_meta_model->description;
                if (!empty($this->page_meta_model->keywords))
                    $this->meta_keywords = $this->page_meta_model->keywords;
                if (!empty($this->page_meta_model->title))
                    $this->meta_title = $this->page_meta_model->title;
            }
        }
    }

    protected function combineStatic()
    {
        if (YII_DEBUG === false) {
            $wwwPath = Yii::getPathOfAlias('application.www-submodule');

            foreach (Yii::app()->params['combineMap'] as $all => $filesArray) {
                if (file_exists($wwwPath . $all)) {
                    $to = Yii::app()->request->isAjaxRequest ? false : $all . '?r=' . $this->r;
                    foreach ($filesArray as $f)
                        Yii::app()->clientScript->scriptMap[$f] = $to;
                }
            }
        }
    }

    /**
     * Считает заходы из ПС для модуля комментаторов
     */
    public function registerCounter()
    {
        Yii::app()->clientScript->registerScript('se_counter', 'SeCounter();');
    }

    private function _mobileRedirect()
    {
        $detect = new Mobile_Detect();
        $mobile = $newMobile = (string) Yii::app()->request->cookies['mobile'];

        if ($mobile == '' && $detect->isMobile() && ! $detect->isTablet())
            $newMobile = 1;

        if ($mobile == 1 && Yii::app()->request->getQuery('nomo') == 1)
            $newMobile = 0;

        if ($mobile != $newMobile)
            Yii::app()->request->cookies['mobile'] = new CHttpCookie('mobile', $newMobile, array('expire' => time() + 60 * 60 * 24 * 365));

        if ($newMobile == 1)
            $this->redirect('http://m.happy-giraffe.ru' . $_SERVER['REQUEST_URI']);
    }
}