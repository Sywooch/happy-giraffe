<?php

class DefaultController extends HController
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
                'actions'=>array('index','view','list','rules','prizes', 'work', 'results', 'canParticipate'),
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

    public function init()
    {
        parent::init();

        Yii::import('site.frontend.widgets.user.UserCoreWidget');
    }

    public function actionIndex()
    {
        $this->layout = '//layouts/main';
        $this->pageTitle = 'Наши конкурсы';

        $dp = Contest::model()->getActiveList();

        $this->render('index', compact('dp'));
    }

    public function actionView($id)
    {
        $contest = Contest::model()->findByPk($id);
        if ($contest === null)
            throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->contest = $contest;
        $this->pageTitle = 'Фотоконкурс «' . $contest->title . '» на Веселом Жирафе';

        $sort = 'created';
        $works = new ContestWork('search');
        $works->unsetAttributes();
        $works->contest_id = $this->contest->id;
        $works = $works->search($sort);
        $works->pagination->pageSize = 12;

        $this->render('view', compact('contest', 'works', 'sort'));
    }

    public function actionList($id, $sort = 'created')
    {
        $contest = Contest::model()->findByPk($id);
        if ($contest === null)
            throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->contest = $contest;
        $this->pageTitle = 'Участники конкурса «' . $contest->title . '»';

        $works = new ContestWork('search');
        $works->unsetAttributes();
        $works->contest_id = $this->contest->id;
        $works = $works->search($sort);

        $this->render('list', compact('contest', 'works', 'sort'));
    }

    public function actionRules($id)
    {
        $contest = Contest::model()->findByPk($id);
        if ($contest === null)
            throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->contest = $contest;
        $this->pageTitle = 'Правила фотоконкурса «' . $contest->title . '»';

        $this->render('rules', compact('contest'));
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

    public function actionResults($id)
    {
        $contest = Contest::model()->findByPk($id);
        if ($contest === null)
            throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->contest = $contest;
        $this->pageTitle = 'Результаты фотоконкурса «' . $contest->title . '»';

        $this->render('results');
    }

    public function actionPrizes($id)
    {
        $contest = Contest::model()->findByPk($id);
        if ($contest === null)
            throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->contest = $contest;
        $this->pageTitle = 'Призы фотоконкурса «' . $contest->title . '»';

        $this->render('prizes');
    }

    public function actionStatement($id)
    {
        $this->contest = Contest::model()->findByPk($id);

//        if ($this->contest->getCanParticipate() !== true)
//            throw new CHttpException(404);

        $this->pageTitle = 'Участвовать в фотоконкурсе "' . $this->contest->title . '"';

        $model = new ContestWork('upload');
        if(isset($_POST['ContestWork']))
        {
            if(isset($_POST['ajax']) && $_POST['ajax']==='attach-form')
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            $transaction=$model->dbConnection->beginTransaction();
            try {
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
                    $transaction->commit();
                    $this->redirect(array('/contest/default/view', 'id' => $this->contest->primaryKey));
                }
            }
            catch(Exception $e)
            {
                $transaction->rollback();
            }
        }
        $this->render('statement', array('model' => $model));
    }

    public function actionCanParticipate($id)
    {
        $contest = Contest::model()->findByPk($id);
        $statement = $contest->getCanParticipate();

        $response = array(
            'status' => $statement,
        );

        if ($statement == Contest::STATEMENT_STEPS)
            $response['id'] = Yii::app()->user->id;

        echo CJSON::encode($response);
    }
}