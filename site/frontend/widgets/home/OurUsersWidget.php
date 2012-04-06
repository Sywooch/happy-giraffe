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
        $criteria->limit = 12;
        $criteria->condition = ' in_favourites = 1 ';
        $criteria->order = ' RAND() ';
        $users = User::model()->findAll($criteria);

        $this->render('OurUsersWidget', compact('users'));
    }
}