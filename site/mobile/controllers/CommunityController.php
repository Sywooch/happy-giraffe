<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/4/13
 * Time: 5:06 PM
 * To change this template use File | Settings | File Templates.
 */
class CommunityController extends MController
{
    public function actionIndex()
    {
        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'order' => 't.created DESC',
                'scopes' => array('active', 'full'),
            ),
            'pagination' => array(
                'pageSize' => 3,
            ),
        ));

        $this->render('list', compact('dp'));
    }

    public function actionList($community_id)
    {
        $dp = CommunityContent::model()->getMobileContents($community_id);

        $this->render('list', compact('dp'));
    }

    public function actionView($community_id, $content_type_slug, $content_id)
    {
        $content = CommunityContent::model()->active()->full()->findByPk($content_id);

        $next = CommunityContent::model()->active()->community()->findAll(array(
            'order' => 't.id DESC',
            'condition' => 't.id < :current_id AND rubric.community_id = :community_id',
            'params' => array(':current_id' => $content_id, ':community_id' => $community_id),
            'limit' => 3,
        ));

        $this->render('view', compact('content', 'next'));
    }

    public function actionBlogList()
    {
        $dp = new CActiveDataProvider('BlogContent', array(
            'criteria' => array(
                'order' => 't.created DESC',
                'scopes' => array('active', 'full', 'blog'),
            ),
            'pagination' => array(
                'pageSize' => 3,
            ),
        ));

        $this->render('list', compact('dp'));
    }

    public function actionUser($user_id)
    {
        $user = User::model()->findByPk($user_id);

        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'order' => 't.created DESC',
                'scopes' => array('active', 'full'),
            ),
            'pagination' => array(
                'pageSize' => 3,
            ),
        ));

        $this->render('user', compact('user', 'dp'));
    }
}
