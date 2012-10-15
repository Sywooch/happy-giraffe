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
                'actions'=>array('index','view','list','rules', 'work', 'results', 'canParticipate'),
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
        Yii::import('site.frontend.widgets.user.UserCoreWidget');
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
        ))->findByPk($id);
        if ($contest === null)
            throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->pageTitle = 'Фотоконкурс "' . $contest->title . '" на Веселом Жирафе';

        $this->contest = $contest;

        $sort = 'created';
        $works = new ContestWork('search');
        $works->unsetAttributes();
        $works->contest_id = $this->contest->id;
        $works = $works->search($sort);
        $works->pagination->pageSize = 12;

        $this->render('view', array(
            'contest' => $contest,
            'works' => $works,
            'sort' => $sort,
        ));
    }

    public function actionList($id, $sort = 'created')
    {
        $contest = Contest::model()->findByPk($id);
        if ($contest === null)
            throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->pageTitle = 'Участники конкурса "' . $contest->title . '"';

        $this->contest = $contest;

        $works = new ContestWork('search');
        $works->unsetAttributes();
        $works->contest_id = $this->contest->id;
        $works = $works->search($sort);

        if (Yii::app()->request->isAjaxRequest) {
            $result = array(
                'html' => $this->renderPartial('list', array(
                    'contest' => $contest,
                    'works' => $works,
                    'sort' => $sort,
                ), true),
            );
            echo CJSON::encode($result);
        } else {
            $this->render('list', array(
                'contest' => $contest,
                'works' => $works,
                'sort' => $sort,
            ));
        }
    }

    public function actionRules($id)
    {
        $contest = Contest::model()->findByPk($id);
        if ($contest === null) throw new CHttpException(404, 'Такого конкурса не существует.');
        $this->pageTitle = 'Правила фотоконкурса "' . $contest->title . '"';

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

    public function actionResults($id, $work = false)
    {
        $winners = array(117, 128, 248, 43, 220);
        $this->contest = Contest::model()->findByPk($id);
        if($work && $index = array_search($work, $winners))
        {
            $model = ContestWork::model()->findByPk($work);
        }
        else
        {
            $index = 0;
            $model = ContestWork::model()->findByPk($winners[0]);
        }
        $this->render('results', array('work' => $model, 'winners' => $winners, 'index' => $index));
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
        $this->contest = Contest::model()->findByPk($id);

        if($this->contest->isStatement !== true && Yii::app()->user->id != 12936)
            throw new CHttpException(404);

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
        $statement = $contest->isStatement;

        $response = array(
            'status' => $statement,
        );

        if ($statement == 1)
            $response['id'] = Yii::app()->user->id;

        echo CJSON::encode($response);
    }
}