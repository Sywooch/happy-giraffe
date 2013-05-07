<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class MostPopularWidget extends SimpleWidget
{
    public function run(){
        $models = Favourites::getArticlesByDate(Favourites::BLOCK_INTERESTING, date("Y-m-d"), 2);
        $this->render('MostPopularWidget', compact('models'));
    }
}