<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 19/08/14
 * Time: 19:49
 */

class HeaderGuestWidget extends CWidget
{
    public function run()
    {
        $clubs = CommunityClub::model()->findAll(array(
            'condition' => 't.id <= :id',
            'params' => array(':id' => 18),
            'order' => 't.id ASC',
        ));
        $this->render('HeaderGuestWidget', compact('clubs'));
    }
} 