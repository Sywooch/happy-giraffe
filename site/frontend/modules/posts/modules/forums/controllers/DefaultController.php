<?php
/**
 * @author Никита
 * @date 27/10/15
 */

namespace site\frontend\modules\posts\modules\forums\controllers;


use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\modules\forums\components\TagHelper;
use site\frontend\modules\posts\modules\forums\widgets\feed\FeedWidget;

class DefaultController extends \LiteController
{
    public $litePackage = 'forum-homepage';
    public $hideUserAdd = true;

    //public $layout = '//layouts/lite/test';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionClub($club, $feedForumId = null, $feedTab = null)
    {
        $club = \CommunityClub::model()->findByAttributes(['slug' => $club]);
        if (! $club) {
            throw new \CHttpException(404);
        }
        if ($feedForumId !== null) {
            $feedForum = \Community::model()->findByPk($feedForumId);
            if (! $feedForum) {
                throw new \CHttpException(404);
            }
        } else {
            $feedForum = null;
        }
        $this->render('club', compact('club', 'feedForum', 'feedTab'));
    }

    public function actionRubric($rubricId)
    {
        $rubric = \CommunityRubric::model()->findByPk($rubricId); // @todo нарушаем SOA
        if (! $rubric) {
            throw new \CHttpException(404);
        }
        $this->render('rubric', compact('rubric'));
    }
}