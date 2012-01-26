<?php
Yii::import('site.frontend.modules.names.models.*');

class NamesController extends BController
{
    public $layout = '//layouts/main';

    public function actionIndex()
    {
        $names = Name::model()->findAll();
        $this->render('index', array('names' => $names));
    }

    public function actionCreate()
    {
        $name = new Name;

        if (!empty($_POST['title'])) {
            $name->name = $_POST['title'];
            $name->gender = 0;
            if ($name->save()) {
                $response = array(
                    'status' => true,
                    'id' => $name->id
                );
            } else {
                $response = array(
                    'status' => false,
                );
            }

            echo CJSON::encode($response);
            Yii::app()->end();
        }

        $this->render('view', array('name' => $name));
    }

    public function actionUpdate($id)
    {
        $name = $this->loadModel($id);
        $this->render('view', array('name' => $name));
    }

    /**
     * @param int $id model id
     * @return Name
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Name::model()->with(array(
            'nameFamouses',
            'nameSaintDates' => array('order' => 'month, day'),
            'nameMiddles' => array('order' => 'nameMiddles.id'),
            'nameOptions' => array('order' => 'nameOptions.id'),
            'nameSweets' => array('order' => 'nameSweets.id')
        ))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionTestMy()
    {
        $names = Name::model()->findAll();
        foreach ($names as $name) {
            /**
             * @var Name $name
             */
            $vals = explode(',', $name->options);
            foreach ($vals as $val) {
                $val = trim($val);
                if (empty($val))
                    continue;
                $model = new NameOption();
                $model->name_id = $name->id;
                $model->value = trim($val);
                $model->save();
            }

            $vals = explode(',', $name->middle_names);
            foreach ($vals as $val) {
                $val = trim($val);
                if (empty($val))
                    continue;
                $model = new NameMiddle();
                $model->name_id = $name->id;
                $model->value = trim($val);
                $model->save();
            }

            $vals = explode(',', $name->sweet);
            foreach ($vals as $val) {
                $val = trim($val);
                if (empty($val))
                    continue;
                $model = new NameSweet();
                $model->name_id = $name->id;
                $model->value = trim($val);
                $model->save();
            }
        }
    }

    public function actionAddValue()
    {
        $text = Yii::app()->request->getPost('text');
        $name_id = Yii::app()->request->getPost('modelId');
        $modelName = Yii::app()->request->getPost('modelName');
        if (empty($text))
            CJSON::encode(array('status' => false));

        $model = new $modelName;
        $model->name_id = $name_id;
        $model->value = $text;

        if ($model->save()) {
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_item_view', array('model' => $model), true)
            );
        } else {
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionAddSaintDate()
    {
        $day = Yii::app()->request->getPost('day');
        $month = Yii::app()->request->getPost('month');
        $model_id = Yii::app()->request->getPost('model_id');

        if (!empty($day) && !empty($month)) {
            $saintDate = new NameSaintDate;
            $saintDate->name_id = $model_id;
            $saintDate->day = $day;
            $saintDate->month = $month;

            if ($saintDate->save()) {
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('_saint_date', array('model' => $saintDate), true)
                );
            } else {
                $response = array(
                    'status' => false,
                );
            }
        } else {
            $response = array(
                'status' => false,
            );
        }
        echo CJSON::encode($response);
    }

    public function actionAddFamous()
    {
        $attributes = Yii::app()->request->getPost('NameFamous');

        if (!empty($attributes)) {
            $famous = new NameFamous;
            $famous->attributes = $attributes;

            if ($famous->save()) {
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('_famous', array('model' => $famous), true)
                );
            } else {
                $response = array(
                    'status' => false,
                    'error'=>$famous->getErrors()
                );
            }
        } else {
            $response = array(
                'status' => false,
            );
        }
        echo CJSON::encode($response);
    }

    public function actionUploadPhoto(){

    }
}

