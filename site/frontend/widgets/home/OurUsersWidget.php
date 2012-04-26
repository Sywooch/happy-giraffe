<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class OurUsersWidget extends SimpleWidget
{
    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 15;
        $criteria->order = ' RAND() ';
        $criteria->select = array('id');
        $criteria->with = 'avatar';
        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_SIMPLE));
        $users = User::model()->findAll($criteria);

        $this->render('OurUsersWidget', compact('users'));
    }
}