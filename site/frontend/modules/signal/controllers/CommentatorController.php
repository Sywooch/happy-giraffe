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
            'ajaxOnly + take, decline, history',
        );
    }

    protected function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('commentator_panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

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

    public function actionStatistic($period = null){
        if (empty($period))
            $period = date("Y-m");
        $this->render('statistic', compact('period'));
    }

    public function actionBlog()
    {
        $this->renderPartial('_blog_posts', array('blog_posts'=>$this->userBlogPosts()));
    }

    public function userBlogPosts()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id = ' . $this->user->id
            )
        );

        return CommunityContent::model()->findAll($criteria);
    }

    public function actionClub()
    {
        $this->renderPartial('_club_posts', array('club_posts'=>$this->userClubPosts()));
    }

    public function userClubPosts(){
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id IS NULL'
            )
        );

        return  CommunityContent::model()->findAll($criteria);
    }

    public function actionComments()
    {
        $this->renderPartial('_comments', array('comments_count'=>$this->userComments()));
    }

    public function userComments()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';

        return  Comment::model()->count($criteria);
    }

    public function actionPosts()
    {
        //пользовательские темы
        $criteria = new CDbCriteria;
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00" AND author_id != '.$this->user->id;
        $criteria->order = 'created desc';
        $criteria->with = array(
            'author' => array(
                'condition' => 'author.group = 0',
                'together'=>true,
            )
        );
        $posts = CommunityContent::model()->findAll($criteria);

        //новые темы членов нашей команды
        $criteria = new CDbCriteria;
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00" AND author_id != '.$this->user->id;
        $criteria->order = 'created desc';
        $criteria->with = array(
            'author' => array(
                'condition' => 'author.group > 0',
                'together'=>true,
            )
        );
        $posts = array_merge($posts, CommunityContent::model()->findAll($criteria));

        //Статьи которые завтра будут на главной
        $criteria = new CDbCriteria;
        $criteria->order = 'created desc';
        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_INTERESTING, 2));
        $posts = array_merge($posts, CommunityContent::model()->findAll($criteria));

        //Статьи которые размещаются в соц сетях

        $this->renderPartial('_posts', compact('posts'));
    }

    public function actionAdditionalPosts()
    {
        //themes with 0 comments
        $criteria = new CDbCriteria(array(
            'condition' => 'comments.id IS NULL',
            'with' => array(
                'comments'=>array(
                    'select'=>'id',
                    'together'=>true,
                ),
                'rubric' => array(
                    'select'=>'id',
                    'condition' => 'user_id IS NULL',
                    'with' => array(
                        'community' => array(
                            'select' => 'id',
                        )
                    ),
                ),
            ),
            'limit' => 10,
        ));
        $posts = CommunityContent::model()->findAll($criteria);

        $this->renderPartial('_posts', compact('posts'));
    }

    public function actionIAmWorking(){
        $this->commentator->WorksToday(Yii::app()->user->id);
        $this->redirect($this->createUrl('/signal/commentator/index'));
    }

    public function blogVisits()
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $ga->setProfile('ga:53688414');
        $ga->setDateRange(date("Y-m"). '-01', date('Y-m-d'));
        $report = $ga->getReport(array(
            'metrics'=>urlencode('ga:visitors,ga:pageViews'),
            'filters'=>urlencode('ga:pagePath=~' . '/user/83/blog/*'),
        ));
        var_dump($report);
        $report = $ga->getReport(array(
            'metrics'=>urlencode('ga:visitors,ga:uniquePageviews'),
            'filters'=>urlencode('ga:pagePath=~' . '/user/83/*'),
        ));
        var_dump($report);
        Yii::app()->end();
        if(!$report || !isset($report['/user/83/blog/']))
            return false;
        $count = $report['/user/83/blog/']['ga:uniquePageviews'];
    }
}
