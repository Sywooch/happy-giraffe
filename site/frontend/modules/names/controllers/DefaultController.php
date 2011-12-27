<?php

class DefaultController extends Controller
{
    public $layout = 'names';
    public $likes = 0;

    public function actionIndex($letter = null, $gender = null)
    {
        $this->SetLikes();
        $criteria = new CDbCriteria;
        $show_all = false;
        if ($letter !== null) {
            $criteria->compare('name', $letter . '%', true, 'AND', false);
            $show_all = true;
        }
        if (!empty($gender))
            $criteria->compare('gender', $gender);

        if (!$show_all) {
            $count = Name::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 30;
            $pages->applyLimit($criteria);
            $names = Name::model()->findAll($criteria);
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('index_data', array(
                    'names' => $names,
                    'pages' => $pages,
                    'likes'=>Name::GetLikeIds()
                ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => $pages,
                    'likes'=>Name::GetLikeIds()
                ));
        } else {
            $names = Name::model()->findAll($criteria);
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('index_data', array(
                    'names' => $names,
                    'pages' => null,
                    'likes'=>Name::GetLikeIds()
                ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => null,
                    'likes'=>Name::GetLikeIds()
                ));
        }
    }

    public function actionTop10()
    {
        $this->SetLikes();
        $topMen = Name::model()->Top10Man();
        $topWomen = Name::model()->Top10Woman();

        $this->render('top10', array(
            'topMen' => $topMen,
            'topWomen' => $topWomen,
            'likes'=>Name::GetLikeIds()
        ));
    }

    public function actionSaint()
    {
        $this->SetLikes();
        $model = new BabyDateForm();
        $this->render('saint', array(
            'model' => $model,
            'likes'=>Name::GetLikeIds()
        ));
    }

    public function actionSaintCalc()
    {
        if (isset($_POST['BabyDateForm'])) {
            $modelForm = new BabyDateForm();
            $modelForm->attributes = $_POST['BabyDateForm'];
            if (!$modelForm->validate())
                Yii::app()->end();

            $data = $modelForm->CalculateData();
            $this->renderPartial('saint_res', array(
                'data' => $data,
                'modelForm' => $modelForm
            ));
        }
    }

    public function actionLikes()
    {
        $this->SetLikes();
        if (!Yii::app()->user->isGuest)
            $data = Name::model()->GetLikes(Yii::app()->user->getId());
        else
            $data = null;

        $this->render('likes', array(
            'data' => $data
        ));
    }

    public function actionName($name)
    {
        $this->SetLikes();
        $name = $this->LoadModelByName($name);
        $this->render('name_view', array('name' => $name));
    }

    public function actionLike($id)
    {
        $name = $this->LoadModelById($id);
        echo CJSON::encode(array(
            'count'=>Name::GetLikesCount(Yii::app()->user->getId()),
            'success'=>$name->like(Yii::app()->user->getId()),
        ));
    }

    public function actionCreateFamous($id)
    {
        $model = new NameFamous;
        $name = $this->LoadModelById($id);
        $this->performAjaxValidation($model);
        $model->name = $name;

        if (isset($_POST['NameFamous'])) {
            $model->attributes = $_POST['NameFamous'];
            $model->image = CUploadedFile::getInstance($model, 'image');
            $model->name_id = $name->id;

            if ($model->save()) {
                $model->SaveImage();
                $this->redirect(array('name', 'name' => $model->name->name));
            }
        }

        $this->render('create_famous', array(
            'model' => $model,
        ));
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'name-famous-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @param string $name
     * @return Name
     */
    public function LoadModelByName($name)
    {
        $model = Name::model()->findByAttributes(array('name' => $name));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id
     * @return Name
     * @throws CHttpException
     */
    public function LoadModelById($id)
    {
        $model = Name::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function SetLikes(){
        if (!Yii::app()->user->isGuest)
            $this->likes = Name::GetLikesCount(Yii::app()->user->getId());
    }
}