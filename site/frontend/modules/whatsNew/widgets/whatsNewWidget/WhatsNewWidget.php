<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/11/12
 * Time: 11:21 AM
 * To change this template use File | Settings | File Templates.
 */
class WhatsNewWidget extends CWidget
{
    /**
     * module Id, controller Id, action Id []
     * @var array
     */
    public $routes = array(
        array('blog', array('list', 'view')),
        array('community', array('list', 'view')),
        array('cook/recipe', array('index', 'tag', 'view', 'cookBook')),
    );
    public $type = EventManager::WHATS_NEW_ALL;
    public $checkVisible = true;

    public function run()
    {
        if (!$this->checkVisible || $this->showThere()){
            $dp = EventManager::getDataProvider($this->type, 13);
            //for friends
            $dp->pagination->pageSize = 13;

            $this->registerScripts();
            $this->render('index', compact('dp'));
        }
    }

    public function showThere()
    {
        if (Yii::app()->request->isAjaxRequest)
            return false;

        foreach ($this->routes as $route)
            if (Yii::app()->controller->uniqueId == $route[0] && in_array(Yii::app()->controller->action->id, $route[1]))
                return true;

        return false;
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/whatsNew.js', CClientScript::POS_HEAD);
    }
}
