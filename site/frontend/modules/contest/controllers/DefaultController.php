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
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
//				'roles'=>array('admin'),
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
        $contest = Contest::model()->with(array(
            'prizes' => array('with' => 'product'),
            'works' => array('limit' => 15),
            'winners',
        ))->findByPk($id);
        if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');

        $this->contest = $contest;

        $this->render('view', array(
            'contest' => $contest,
        ));
    }

    public function actionList($id, $sort = 'work_time')
    {
        $contest = Contest::model()->with('winners')->findByPk($id);
        if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');

        $works = ContestWork::model()->get($id, $sort);

        $this->contest = $contest;

        $this->render('list', array(
            'contest' => $contest,
            'works' => $works->data,
            'pages' => $works->pagination,
            'sort' => $sort,
        ));
    }

    public function actionRules($id)
    {
        $contest = Contest::model()->with('winners')->findByPk($id);
        if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');

        $this->contest = $contest;

        $this->render('rules', array(
            'contest' => $contest,
        ));
    }

    public function actionWork($id)
    {
        $work = ContestWork::model()->findByPk($id);
        $others = ContestWork::model()->findAll(array(
            'limit' => 5,
            'condition' => 'work_id!=:current',
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
}