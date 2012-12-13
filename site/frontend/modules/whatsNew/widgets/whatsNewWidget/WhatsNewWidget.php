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
    public function run()
    {
        $dp = EventManager::getIndex(6);
        $this->registerScripts();
        $this->render('index', compact('dp'));
    }

    public function registerScripts()
    {
        $js = "
            $('#masonry-news-list-jcarousel').jcarousel({
                list: '#masonry-news-list-jcarousel-ul',
                items: '.masonry-news-list_item',
                initCallback: mycarousel_initCallback,
            });



            function mycarousel_initCallback(carousel, state) {
                alert('123');
            };
        ";

        Yii::app()->clientScript
            ->registerScript('whatsNew-widget', $js)
        ;
    }
}
