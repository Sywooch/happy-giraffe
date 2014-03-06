<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 06/03/14
 * Time: 17:06
 * To change this template use File | Settings | File Templates.
 */

class CommunityQuestionWidget extends CWidget
{
    public $forumId;

    public function run()
    {
        if ($this->forumId == 2) {
            $model = new CommunityQuestionForm();
            $this->render('CommunityQuestionWidget', compact('model'));
        }
    }
}