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
                    'condition' => 'user_id IS NULL'
                ),
            ),
            'limit' => 10,
        ));
        $posts = CommunityContent::model()->findAll($criteria);

        $this->renderPartial('_posts', compact('posts'));
    }
}
