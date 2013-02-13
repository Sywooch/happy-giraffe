<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 1/15/13
 * Time: 1:10 PM
 * To change this template use File | Settings | File Templates.
 */
class InfinitePager extends CBasePager
{
    public $selector = '#content';
    public $options = array();
    public $callback = null;

    private $_defaultOptions = array(
        'loading' => array(
            'msgText' => 'Загрузка',
            'img' => '/images/ico/ajax-loader.gif',
        ),
    );

    public function init()
    {
        $this->getPages()->validateCurrentPage = false;
        parent::init();
    }

    public function run()
    {
        $this->registerClientScript();
        $this->createInfiniteScrollScript();
        $this->renderNavigation();

        if($this->getPages()->getPageCount() > 0 && $this->theresNoMorePages()) {
            throw new CHttpException(404);
        }
    }

    public function __get($name)
    {
        if(array_key_exists($name, $this->options)) {
            return $this->_options[$name];
        }

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if(array_key_exists($name, $this->options)) {
            return $this->options[$name] = $value;
        }

        return parent::__set($name, $value);
    }

    public function registerClientScript()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . ((YII_DEBUG) ? 'jquery.infinitescroll.js' : 'jquery.infinitescroll.min.js'));
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/behaviors/local.js');
    }

    private function createInfiniteScrollScript()
    {
        Yii::app()->clientScript->registerScript(
            uniqid(),
            "$('{$this->selector}').infinitescroll(".$this->buildInifiniteScrollOptions().($this->callback !== null ? ', ' . $this->callback : '').");"
        );
    }

    private function buildInifiniteScrollOptions()
    {
        $options = CMap::mergeArray($this->_defaultOptions, $this->options);
        return CJavaScript::encode($options);
    }

    private function renderNavigation()
    {
        $next_link = CHtml::link('next',$this->createPageUrl($this->getCurrentPage(false)+1));
        echo '<div class="navigation">'.$next_link.'</div>';
    }

    private function theresNoMorePages()
    {
        return $this->getPages()->getCurrentPage() >= $this->getPages()->getPageCount();
    }
}
