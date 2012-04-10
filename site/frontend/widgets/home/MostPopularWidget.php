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
        $criteria->order = ' t.id DESC ';
        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_INTERESTING));

        $models = CommunityContent::model()->full()->findAll($criteria);
        $this->render('MostPopularWidget', compact('models'));
    }
}