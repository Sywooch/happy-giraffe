<?php
/**
 * Author: alexk984
 * Date: 23.08.12
 */
class CommentatorController extends HController
{
    public $layout = 'main';
    /**
     * @var User
     */
    public $user;

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
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::import('site.seo.components.*');
        //echo $this->blogVisits();
        $metrika = new YandexMetrica();
        $metrika->searchesCount();

        $this->render('index');
    }

    public function actionBlog()
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

        $blog_posts = CommunityContent::model()->findAll($criteria);
        $this->renderPartial('_blog_posts', compact('blog_posts'));
    }

    public function actionClub()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id IS NULL'
            )
        );

        $club_posts = CommunityContent::model()->findAll($criteria);
        $this->renderPartial('_club_posts', compact('club_posts'));
    }

    public function actionComments()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';

        $comments = Comment::model()->findAll($criteria);
        $this->renderPartial('_comments', compact('comments'));
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

    public function FriendsCount()
    {
        //SELECT count(id) FROM `friend_requests` WHERE status="accepted" and `updated` > "2012-08-01 13:44:35"
    }

    public function getMessagesCount()
    {
        $dialogs = Dialog::model()->findAll(array(
            'with'=>array(
                'dialogUsers'=>array(
                    'condition'=>'dialogUsers.user_id = '.$this->user->id
                ),
                'messages'=>array(
                    'condition'=>'messages.created >= "'.date("Y-m").'-01 00:00:00"'
                ),
                'together'=>true
            )
        ));

        $res = 0;
        foreach($dialogs as $dialog)
            $res += count($dialog->messages);

        return $res;
    }

    public function blogVisits()
    {
        //http://www.happy-giraffe.ru/user/83/blog/
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
