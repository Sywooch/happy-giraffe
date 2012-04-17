<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class MostPopularWidget extends SimpleWidget
{
    public function run(){
        $criteria = new CDbCriteria;
        $criteria->limit = 2;
        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_INTERESTING, 2));

        $models = CommunityContent::model()->full()->findAll($criteria);
        $this->render('MostPopularWidget', compact('models'));
    }
}