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
                items: '.masonry-news-list_item'
            });

            // Setup controls for the navigation carousel
            $('#masonry-news-list-jcarousel .prev')
                .on('inactive.jcarouselcontrol', function() {
                    $(this).addClass('inactive');
                })
                .on('active.jcarouselcontrol', function() {
                    $(this).removeClass('inactive');
                })
                .jcarouselControl({
                    target: '-=1'
            });

            $('#masonry-news-list-jcarousel .next')
                .on('inactive.jcarouselcontrol', function() {
                    $(this).addClass('inactive');
                })
                .on('active.jcarouselcontrol', function() {
                    $(this).removeClass('inactive');
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
