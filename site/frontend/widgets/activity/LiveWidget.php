<?php
/**
 * Author: choo
 * Date: 15.05.2012
 */
class LiveWidget extends CWidget
{
    public function run()
    {
        $criteria = new CDbCriteria(array());
        $criteria->limit = 5;
        $criteria->order = 'created DESC';
        $criteria->condition = 'type_id != 4 AND community_id != :news';
        $criteria->params = array(':news' => Community::COMMUNITY_NEWS);

        $live = CommunityContent::model()->full()->findAll($criteria);

        $this->render('LiveWidget', compact('live'));
    }
}
