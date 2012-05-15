<?php
/**
 * Хотят общаться
 *
 * Author: choo
 * Date: 15.05.2012
 */
class WantToChatWidget extends CWidget
{
    public $onlyButton = false;

    public function run()
    {
        $this->registerScripts();
        if ($this->onlyButton) {
            $this->render('_chatButton');
        } else {
            $users = WantToChat::getList();
            $this->render('WantToChatWidget', compact('users'));
        }
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile($baseUrl . '/' . 'wantToChat.js');
    }
}
