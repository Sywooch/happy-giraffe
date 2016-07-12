<?php
/**
 * @author Никита
 * @date 30/06/16
 */

namespace site\frontend\modules\posts\modules\forums\controllers;


use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

class ClubController extends \LiteController
{
    public $litePackage = 'forum-homepage';
    public $layout = '/layouts/club';

    /**
     * @var \CommunityClub
     */
    public $club;

    public function actionIndex($club, $feedForumId = null, $feedTab = null)
    {
        $this->club = \CommunityClub::model()->findByAttributes(['slug' => $club]);
        if (! $this->club) {
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
        $this->render('index', compact('feedForum', 'feedTab'));
    }

    public function actionRubric($rubricId)
    {
        $rubric = \CommunityRubric::model()->findByPk($rubricId); // @todo нарушаем SOA
        $this->club = $rubric->community->club;
        if (! $rubric) {
            throw new \CHttpException(404);
        }
        $dp = new \CActiveDataProvider(Content::model(), [
            'criteria' => [
                'scopes' => ['byLabels' => [[
                    Label::LABEL_FORUMS,
                    $rubric->community->club->section->toLabel(),
                    $rubric->community->club->toLabel(),
                    $rubric->community->toLabel(),
                    $rubric->toLabel(),
                ]]],
            ],
            'pagination' => [
                'pageVar' => 'page',    
            ],
        ]);
        $this->render('rubric', compact('rubric', 'dp'));
    }
}