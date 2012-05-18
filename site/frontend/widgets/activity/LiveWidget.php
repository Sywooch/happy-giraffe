<?php
/**
 * Author: choo
 * Date: 15.05.2012
 */
class LiveWidget extends CWidget
{
    public function run()
    {
        $live = CommunityContent::model()->full()->findAll(array(
            'limit' => 5,
            'order' => 'created DESC',
        ));

        $this->render('LiveWidget', compact('live'));
    }
}
