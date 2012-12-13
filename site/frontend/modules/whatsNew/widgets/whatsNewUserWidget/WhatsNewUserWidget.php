<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/13/12
 * Time: 1:23 PM
 * To change this template use File | Settings | File Templates.
 */
class WhatsNewUserWidget extends CWidget
{
    public $user;

    public function run()
    {
        $dp = FriendEventManager::getDataProvider($this->user);
        if ($dp->itemCount > 0) {
            $this->registerScripts();
            $this->render('index', compact('dp'));
        }
    }

    public function registerScripts()
    {
        $js = '
            var $container = $("#whatsNewUserWidgetList .items");

            $container.imagesLoaded(function() {
                $container.isotope({
                    itemSelector : ".masonry-news-list_item"
                });
            });
        ';

        Yii::app()->clientScript
            ->registerCssFile('/stylesheets/user.css')
            ->registerCssFile('/stylesheets/isotope.css')
            ->registerScriptFile('/javascripts/jquery.isotope.min.js')
            ->registerScript('whatsNew-widget', $js)
        ;
    }
}
