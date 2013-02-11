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
    public function actionList($community_id)
    {
        $dp = CommunityContent::model()->getMobileContents($community_id);

        $this->render('list', compact('dp'));
    }

    public function actionView($community_id, $content_type_slug, $content_id)
    {
        $post = CommunityContent::model()->findByPk($content_id);

        $this->render('view', compact('post'));
    }
}
