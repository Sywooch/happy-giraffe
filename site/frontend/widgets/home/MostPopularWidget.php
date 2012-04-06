<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class MostPopularWidget extends SimpleWidget
{
    public function run(){
        $models = Rating::model()->findTopWithEntity('CommunityContent', 2);
        $this->render('MostPopularWidget', compact('models'));
    }
}