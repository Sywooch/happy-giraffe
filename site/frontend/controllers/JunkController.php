<?php
/**
 * Author: choo
 * Date: 27.06.2012
 */
class JunkController extends HController
{
    function actionIndex()
    {
        $video = new Video('http://rutube.ru/tracks/4208872.html');
        echo $video->title;
    }
}
