<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/4/13
 * Time: 5:06 PM
 * To change this template use File | Settings | File Templates.
 */
class CommunityController extends CController
{
    public function actionList($community_id)
    {

    }

    public function actionView($community_id, $content_type_slug, $content_id)
    {
        $content = CommunityContent::model()->full()->with('rubric.community.mobileCommunity')->findByPk($content_id);
        $mobileCommunity = $content->rubric->community->mobileCommunity;

        $this->render('view', compact('content', 'mobileCommunity'));
    }

    public function actionComments($content_id)
    {

    }
}
