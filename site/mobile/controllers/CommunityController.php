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

    public function actionView($content_id)
    {
        $content = MobileCommunityContent::model()->findByPk($content_id);

        echo $content->community->id;

        //$this->render('view', compact('content'));
    }

    public function actionComments($content_id)
    {

    }
}
