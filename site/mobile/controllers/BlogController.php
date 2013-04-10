<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/13/13
 * Time: 8:00 AM
 * To change this template use File | Settings | File Templates.
 */
class BlogController extends MController
{
    public function actionView($user_id, $content_id)
    {
        $content = BlogContent::model()->active()->full()->findByPk($content_id);

        $next = BlogContent::model()->active()->blog()->findAll(array(
            'order' => 't.id DESC',
            'condition' => 't.id < :current_id AND rubric.user_id = :user_id',
            'params' => array(':current_id' => $content_id, ':user_id' => $user_id),
            'limit' => 5,
        ));

        $this->pageTitle = $content->title;
        $this->render('view', compact('content', 'next'));
    }
}
