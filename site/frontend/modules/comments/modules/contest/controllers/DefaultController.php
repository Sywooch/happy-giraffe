<?php

namespace site\frontend\modules\comments\modules\contest\controllers;

use site\frontend\modules\comments\modules\contest\components\ContestHelper;
use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\quests\components\QuestsManager;
use site\frontend\modules\quests\components\QuestTypes;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\quests\models\Quest;
use site\frontend\modules\referals\components\ReferalsEvents;
use site\frontend\modules\referals\models\UserRefLink;

/**
 * @property CommentatorsContest $contest
 * @private array clubsFilter;
 */
class DefaultController extends \LiteController
{
    public $layout = '/layout';
    public $litePackage = 'contest_commentator';
    public $bodyClass = 'body_competition';
    public $contest;

    const QUESTS_PER_PAGE = 30;

    private $clubsFilter;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('my', 'quests'),
                'users' => array('?'),
            ),
        );
    }

    protected function beforeAction($action)
    {
        $this->loadContest();
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->render('/index');
    }

    public function actionRules()
    {
        $this->render('/rules');
    }

    /**
     * @param string $type community|blog
     *
     * @throws \HttpException
     */
    public function actionQuests($type = 'community')
    {
        //$this->getQuests(Content::BLOG_SERVICE);
        /**
         * @var CommentatorsContestParticipant $participant
         */
        $participant = CommentatorsContestParticipant::model()
            ->byContest($this->contest->id)
            ->byUser(\Yii::app()->user->id)
            ->find();

        if (($settings = $participant->getSettingArray()) && isset($settings['community_filter'])) {
            $clubs = explode(',', $settings['community_filter']);
            $clubsCount = count($clubs);

            if (count($clubs) > 0) {
                $this->clubsFilter = $clubs;
            }
        }

        if ($type == 'community') {
            $model = Content::model()
                ->byService(Content::COMMUNITY_SERVICE);

            if (isset($clubsCount) && $clubsCount > 0) {
                $model->byClubs($clubs);
            }
        } else if ($type == 'blog') {
            $model = Content::model()
                ->byService(Content::BLOG_SERVICE);
        } else {
            throw new \HttpException(404);
        }

        $model->notMine()
            ->withoutUserComments(\Yii::app()->user->id)
            ->byActiveQuest()
            ->orderDesc();

        $model->getDbCriteria()->limit = 30;

        $posts = $model->with()
            ->findAll();

        $title = 'Прокомментировать пост ' . ($type == 'blog' ? 'в блоге' : 'на форуме');

        foreach ($posts as $post) {
            $post->views = PageView::getModel($post->url)->visits;
            $quest = QuestsManager::addQuest(
                \Yii::app()->user->id,
                QuestTypes::COMMENT_POST,
                $post,
                array(),
                null,
                $title,
                $title
            );
        }

        $this->addSocialQuests();

        $link = UserRefLink::model()
            ->byUser(\Yii::app()->user->id)
            ->byEvent(ReferalsEvents::INVITE_TO_CONTEST)
            ->find();

        if (!$link) {
            $link = UserRefLink::generate(ReferalsEvents::INVITE_TO_CONTEST);
            if (!$link->save()) {
                throw new \HttpException(500);
            }
        }

        $socialQuests = Quest::model()
            ->byUser(\Yii::app()->user->id)
            ->byType(QuestTypes::POST_TO_WALL)
            ->byModel((new \ReflectionClass($this->contest))->getShortName(), $this->contest->id)
            ->findAll();

        $user = \User::model()->findByPk(\Yii::app()->user->id);

        $eauth = $this->createSocialObject();

        $this->render('/quests', array(
            'type' => $type,
            'posts' => $posts,
            'clubsCount' => (isset($clubsCount) && $clubsCount != 0)
                ? $clubsCount
                : \CommunityClub::model()->count(),
            'clubs' => \CommunityClub::model()->findAll(),
            'social' => $socialQuests,
            'link' => $link,
            'user' => $user,
            'eauth' => $eauth,
        ));
    }

    /**
     * @return string
     */
    private function createSocialObject()
    {
        $eauth = \Yii::app()->eauth->services;

        $eauth['odnoklassniki']['attachment'] = \CJSON::encode(['media' => [[
            'type' => 'photo',
            'list' =>[['photoId' => ContestHelper::getOkPostImage()]]
        ], [
            'type' => 'text',
            'text' => "СТАНЬ КОММЕНТАТОРОМ МЕСЯЦА!\nhttp://www.happy-giraffe.ru/commentatorsContest/\nЕсли вам нравится общаться с интересными людьми на самые\nактуальные темы, и за это получать  подарки – тогда этот конкурс для вас!\n10 победителей получат приз в размере 1000 рублей!\nУсловия конкурса? Все очень просто - пишите комментарии к\nпостам, которые вам нравятся, и отвечайте на комментарии других пользователей.\nЖдем вас на сайте «Веселый Жираф»!"
        ]]]);

        $eauth['odnoklassniki']['signature'] = md5('st.attachment=' . $eauth['odnoklassniki']['attachment'] . $eauth['odnoklassniki']['client_secret']);

        return $eauth;
    }

    /**
     * @param int $clubId
     *
     * @return bool
     */
    public function isCheckedClub($clubId)
    {
        if (!$this->clubsFilter) {
            return true;
        }

        return in_array($clubId, $this->clubsFilter);
    }

    private function addSocialQuests()
    {
        $socials = array(
            'ok' => 'одноклассники',
            'vk' => 'вконтакте',
            'fb' => 'фейсбук',
        );

        $open = 'Пригласить в конкурс пользователей из ';

        foreach ($socials as $alias => $name) {
            QuestsManager::addQuest(
                \Yii::app()->user->id,
                QuestTypes::POST_TO_WALL,
                $this->contest,
                array(
                    'social_service' => $alias,
                ),
                null,
                $open . $name,
                $open . $name
            );
        }
    }

    /**
     * @param string $service
     * @param Quest[] $quests
     *
     * @return bool
     */
    public function checkSocialService($service, $quests)
    {
        foreach ($quests as $quest) {
            if(!(isset($quest->settings))) {
                continue;
            }

            $settings = \CJSON::decode($quest->settings);

            if (isset($settings['social_service']) && $settings['social_service'] == $service) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $contestId
     */
    public function actionWinners($contestId = null)
    {
        /**
         * @var CommentatorsContest[] $contests
         */
        $contests = CommentatorsContest::model()
            ->notEmpty()
            ->findAll(array(
                'order' => 'id DESC',
                'limit' => 4,
            ));

        if (!$contestId) {
            $contestId = !\Yii::app()->user->isGuest ? $contests[0]->id : $contests[1]->id;
        }

        $this->render('/winners', array(
            'contests' => $contests,
            'winners' => $this->getWinners($contestId),
            'contestId' => $contestId,
        ));
    }

    private function getWinners($contestId)
    {
        return CommentatorsContestParticipant::model()
            ->byContest($contestId)
            ->orderByScore()
            ->findAll(array(
                'limit' => 10,
        ));
    }

    public function actionMy($count = 5)
    {
        $participant = CommentatorsContestParticipant::model()
            ->byContest($this->contest->id)
            ->byUser(\Yii::app()->user->id)
            ->with('user')
            ->find();

        $comments = CommentatorsContestComment::model()
            ->orderDesc()
            ->byContest($this->contest->id)
            ->byParticipant($participant->id)
            ->existingComments()
            ->with('comment')
            ->findAll(array(
                'limit' => $count,
            ));

        $commentsCount = CommentatorsContestComment::model()
            ->byContest($this->contest->id)
            ->byParticipant($participant->id)
            ->count();

        $this->render('/my', array(
            'comments' => $comments,
            'participant' => $participant,
            'commentsCount' => $commentsCount,
            'count' => $count
        ));
    }

    public function actionPulse()
    {
        /**
         * @var CommentatorsContestComment[] $contestComments
         */
        $contestComments = clone CommentatorsContestComment::model()
            ->byContest($this->contest->id)
            ->existingComments()
            ->orderDesc()
            ->with('comment');

        $dp =  new \CActiveDataProvider($contestComments, [
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => 10,
            ],
        ]);

        $participantsCount = CommentatorsContestParticipant::model()
            ->byContest($this->contest->id)
            ->count();

        $commentsCount = CommentatorsContestComment::model()
            ->byContest($this->contest->id)
            ->existingComments()
            ->count();

        $this->render('/pulse', [
            'dp' => $dp,
            'participantsCount' => $participantsCount,
            'commentsCount' => $commentsCount,
        ]);
    }

    protected function loadContest()
    {
        $this->contest = ContestManager::getCurrentActive();
        if (!$this->contest) {
            throw new \HttpException(404);
        }
    }
}