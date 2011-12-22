<?php

class DefaultController extends Controller
{
    public $layout = 'names';
    public $likes = 0;

    public function actionIndex($letter = null)
    {
        if ($letter === null)
            $dataProvider = new CActiveDataProvider('Name', array('pagination' => array('pageSize' => 2)));
        else {
            $criteria = new CDbCriteria;
            $criteria->compare('name', $letter . '%', true, 'AND', false);
            $dataProvider = new CActiveDataProvider('Name', array('criteria' => $criteria, 'pagination' => array('pageSize' => 2)));
        }

        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    public function actionTop10()
    {
        $topMen = Name::model()->Top10Man();
        $topWomen = Name::model()->Top10Woman();

        $this->render('top10', array(
            'topMen' => $topMen,
            'topWomen' => $topWomen,
        ));
    }

    public function actionSaint()
    {
        $model = new BabyDateForm();
        $this->render('saint', array(
            'model' => $model,
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
        $name = $this->LoadModelByName($name);
        $this->render('name_view', array('name' => $name));
    }

    public function actionLike($id)
    {
        $name = $this->LoadModelById($id);
        $res = $name->like(Yii::app()->user->getId());
        echo CJSON::encode($res);
    }

    public function actionCreateFamous($id)
    {
        $model = new NameFamous;
        $name = $this->LoadModelById($id);
        $this->performAjaxValidation($model);
        $model->name = $name;

        if (isset($_POST['NameFamous'])) {
            $model->attributes = $_POST['NameFamous'];
            $model->image=CUploadedFile::getInstance($model,'image');
            $model->name_id = $name->id;

            if ($model->save()){
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
}