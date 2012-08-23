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
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id = ' . $this->user->id
            )
        );
        $blog_records_count = CommunityContent::model()->count($criteria);
        echo $blog_records_count;

        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id IS NULL'
            )
        );
        $club_records_count = CommunityContent::model()->count($criteria);
        echo $club_records_count;

        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';
        $club_records_count = Comment::model()->count($criteria);
        echo $club_records_count;

        //themes with 0 comments
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user->id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id IS NULL'
            )
        );
        $criteria->limit = 5;
        $club_records_without_comments = CommunityContent::model()->count($criteria);

        $this->render('index');
    }
}
