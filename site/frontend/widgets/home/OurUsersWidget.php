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
        $criteria->select = array('id', 'first_name', 'last_name', 'avatar_id');
        $criteria->with = 'avatar';
        $criteria->condition = 'avatar_id IS NOT NULL';
        $users = User::model()->active()->findAll($criteria);

        $this->render('OurUsersWidget', compact('users'));
    }
}