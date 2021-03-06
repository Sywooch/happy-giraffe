<?php
/**
 * @author Никита
 * @date 20/04/16
 */

namespace site\frontend\modules\posts\widgets\author;

class AuthorWidget extends \CWidget
{
    public $post;
    
    public function run()
    {
        $authorView = \Yii::app()->user->checkAccess('moderator') ? 'default' : $this->post->templateObject->getAttr('authorView', 'default');
        
        switch ($authorView) {
            case 'default':
                $this->render('_user', array('user' => $this->post->user));
                break;
            case 'club':
                $post = $this->post;
                
                $clubData = $post->templateObject->getAttr('clubData');
                
                $clubId = $clubData['id'];
                
                $this->render('_club', compact('post', 'clubId'));
                break;
        }
    }
}