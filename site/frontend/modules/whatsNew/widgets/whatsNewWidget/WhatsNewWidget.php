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
        if (! Yii::app()->user->isGuest) {
            $dp = EventManager::getIndex(6);
            $this->registerScripts();
            $this->render('index', compact('dp'));
        }
    }

    public function registerScripts()
    {
        $js = "
            $('#masonry-news-list-jcarousel').jcarousel({
                list: '#masonry-news-list-jcarousel-ul',
                items: '.masonry-news-list_item'
            });

            // Setup controls for the navigation carousel
            $('#masonry-news-list-jcarousel .prev')
                .jcarouselControl({
                    target: '-=1'
            });

            $('#masonry-news-list-jcarousel .next')
                .on('click', function() {
                    if($('.masonry-news-list_item:eq(4)').hasClass('jcarousel-item-visible'))
                        window.location.href = '" . Yii::app()->createUrl('/whatsNew/default/index') . "';
                })
                .jcarouselControl({
                    target: '+=1'
                });


        ";

        Yii::app()->clientScript
            ->registerScript('whatsNew-widget', $js)
        ;
    }
}
