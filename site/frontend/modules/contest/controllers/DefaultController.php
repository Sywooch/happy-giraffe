<?php

class DefaultController extends Controller
{
    public $layout='//layouts/contest';
    public $contest;

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view','list','rules', 'work'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('statement'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->layout = '//layouts/main';
        $contests = Contest::model()->findAll();
        $this->render('index', array(
            'contests' => $contests,
        ));
    }

    public function actionView($id)
    {
        $this->pageTitle = 'Фотоконкурс "Веселая семейка"';

        $criteria=new CDbCriteria;
        //$criteria->with = array('works', 'works.author');
        $criteria->compare('author.blocked',0);
        $criteria->compare('author.deleted',0);
        $criteria->compare('t.id',$id);

        $contest = Contest::model()->with(array(
            'prizes' => array('with' => 'product'),
            'works' => array('limit' => 15),
            'works.author'
        ))->find($criteria);
        if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');

        $this->contest = $contest;

        $this->render('view', array(
            'contest' => $contest,
        ));
    }

    public function actionList($id, $sort = 'created')
    {
        $this->pageTitle = 'Участники фотоконкурса "Веселая семейка"';
        $contest = Contest::model()->findByPk($id);
        if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');

        $this->contest = $contest;

        $works = new ContestWork('search');
        $works->unsetAttributes();
        $works->contest_id = $this->contest->primaryKey;
        $works = $works->search($sort);

        $this->render('list', array(
            'contest' => $contest,
            'works' => $works->data,
            'pages' => $works->pagination,
            'sort' => $sort,
        ));
    }

    public function actionRules($id)
    {
        $this->pageTitle = 'Правила фотоконкурса "Веселая семейка"';
        $contest = Contest::model()->findByPk($id);
        if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');

        $this->contest = $contest;

        $this->render('rules', array(
            'contest' => $contest,
        ));
    }

    public function actionWork($id)
    {
        $work = ContestWork::model()->findByPk($id);
        if ($work === null)
            throw new CHttpException(404, 'Такой работы не существует.');
        $this->pageTitle = '"' . $work->title . '" на фотоконкурсе "Веселая семейка"';
        $others = ContestWork::model()->findAll(array(
            'limit' => 5,
            'condition' => 'id != :current',
            'params' => array(':current' => $id),
        ));
        if ($work === null) throw new CHttpException(404, 'Такой работы не существует.');

        $this->contest = $work->contest;

        $this->render('work', array(
            'work' => $work,
            'others' => $others,
        ));
    }

    public function actionPreview()
    {
        $dst = '/upload/contest/preview/' . time() . '_' . $_FILES['ContestWork']['name']['work_image'];
        FileHandler::run($_FILES['ContestWork']['tmp_name']['work_image'], Yii::getPathOfAlias('webroot') . $dst, array(
            'accurate_resize' => array(
                'width' => 177,
                'height' => 109,
            ),
        ));
        echo Yii::app()->baseUrl . $dst;
    }

    public function actionStatement($id)
    {
        $this->pageTitle = 'Участвовать в фотоконкурсе "Веселая семейка"';
        $this->contest = Contest::model()->findByPk($id);

        if(!$this->contest->isStatement)
            throw new CHttpException(404, 'Вы уже участвуете в этом конкурсе');

        $model = new ContestWork('upload');
        if(isset($_POST['ContestWork']))
        {
            if(isset($_POST['ajax']) && $_POST['ajax']==='attach-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            $model->attributes = $_POST['ContestWork'];
            $model->contest_id = $id;
            $model->user_id = Yii::app()->user->id;
            if($model->save())
            {
                $attach = new AttachPhoto;
                $attach->entity = get_class($model);
                $attach->entity_id = $model->primaryKey;
                if(isset($_POST['photo_id']))
                    $attach->photo_id = $_POST['photo_id'];
                else if(isset($_POST['photo_fsn']))
                {
                    $photo = new AlbumPhoto;
                    $photo->author_id = $model->user_id;
                    $photo->title = $model->title;
                    $photo->file_name = $_POST['photo_fsn'];
                    if($photo->create(true))
                        $attach->photo_id = $photo->id;
                }
                $attach->save();
                $this->redirect(array('/contest/view', 'id' => $this->contest->primaryKey));
            }
        }
        $this->render('statement', array('model' => $model));
    }
}