<?php
/**
 * @author Никита
 * @date 27/10/15
 */

namespace site\frontend\modules\posts\modules\forums\controllers;


use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget;

class DefaultController extends \LiteController
{
    public $litePackage = 'forum-homepage';
    public $hideUserAdd = true;

    public function actionClub($club, $tab = null)
    {
        $club = \CommunityClub::model()->findByAttributes(['slug' => $club]);
        if (! $club) {
            throw new \CHttpException(404);
        }
        $this->render('club', compact('club', 'tab'));
    }
}