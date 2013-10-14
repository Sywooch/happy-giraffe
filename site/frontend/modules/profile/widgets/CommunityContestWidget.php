<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/14/13
 * Time: 4:38 PM
 * To change this template use File | Settings | File Templates.
 */

class CommunityContestWidget extends CWidget
{
    public $user;

    public function run()
    {
        $work = CommunityContestWork::model()->find(array(
            'with' => array(
                'content',
                'contest',
            ),
            'scopes' => array('active'),
            'condition' => 'content.user_id = :user_id',
            'params' => array(':user_id' => $this->user->id),
            'order' => new CDbExpression('RAND()'),
        ));

        $this->render('')
    }
}