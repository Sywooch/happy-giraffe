<?php
/**
 * Author: alexk984
 * Date: 23.08.12
 */
class CommentatorController extends HController
{
    public $layout = 'commentator';
    /**
     * @var User
     */
    public $user;
    /**
     * @var CommentatorWork
     */
    public $commentator;

    public function filters()
    {
        return array(
            'ajaxOnly + blog, club, comments',
        );
    }

    protected function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('commentator_panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        Yii::import('site.frontend.modules.cook.models.*');

        $this->user = Yii::app()->user->model;
        $this->commentator = CommentatorWork::getCurrentUser();
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (!$this->commentator->IsWorksToday(Yii::app()->user->id))
            $this->redirect('/signal/commentator/statistic');

        $this->render('index');
    }

    public function actionStatistic($period = null)
    {
        if (empty($period))
            $period = date("Y-m");
        $this->render('statistic', compact('period'));
    }

    public function actionHelp(){
        $this->render('help');
    }

    public function actionBlog()
    {
        $this->renderPartial('_blog_posts', array('blog_posts' => $this->commentator->blogPosts()));
    }

    public function actionClub()
    {
        $this->renderPartial('_club_posts', array('club_posts' => $this->commentator->clubPosts()));
    }

    public function actionComments()
    {
        $this->renderPartial('_comments');
    }

    public function actionIAmWorking()
    {
        $this->commentator->WorksToday(Yii::app()->user->id);
        $this->redirect($this->createUrl('/signal/commentator/index'));
    }

    public function actionSkip()
    {
        $res = $this->commentator->skipComment();

        if ($res) {
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_comments', array(), true)
            );
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function getSeVisits()
    {
        //ga:organicSearches
        $period = '2012-08';
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $ga->setProfile('ga:53688414');
        $ga->setDateRange($period . '-01', $period . '-31');
        $report = $ga->getReport(array(
            'metrics' => urlencode('ga:organicSearches'),
            'filters' => urlencode('ga:pagePath=~'.'/community/33/forum/post/*'),
            'max-results'=>'1000'
        ));

        var_dump($report);
    }
}
