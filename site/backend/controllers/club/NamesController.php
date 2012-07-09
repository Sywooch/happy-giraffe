<?php
Yii::import('site.frontend.modules.services.modules.names.models.*');

class NamesController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('names'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex($letter = null, $gender = null)
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'name';
        $show_all = false;
        if ($letter !== null && strlen($letter) < 3) {
            $criteria->compare('name', strtolower($letter) . '%', true, 'AND', false);
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
                ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => $pages,
                ));
        } else {
            $names = Name::model()->findAll($criteria);
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('index_data', array(
                    'names' => $names,
                    'pages' => null,
                ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => null,
                ));
        }
    }

    public function actionCreate()
    {
        $name = new Name('edit');

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
            'famous',
            'nameSaintDates' => array('order' => 'month, day'),
//            'nameMiddles' => array('order' => 'nameMiddles.id'),
//            'nameOptions' => array('order' => 'nameOptions.id'),
//            'nameSweets' => array('order' => 'nameSweets.id')
        ))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
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
            if (empty($attributes['id'])) {
                $famous = new NameFamous;
                $famous->attributes = $attributes;
                if (!empty($attributes['photo'])) {
                    $famous->photo = $attributes['photo'];
                    $famous->SaveImage();
                }
                if ($famous->save()) {
                    $response = array(
                        'status' => true,
                        'html' => $this->renderPartial('_famous', array('model' => $famous), true)
                    );
                } else {
                    $response = array(
                        'status' => false,
                        'error' => $famous->getErrors()
                    );
                }
            } else {
                $famous = $this->loadFamousModel($attributes['id']);
                $famous->attributes = $attributes;
                if (!empty($attributes['photo'])) {
                    $famous->DeletePhoto();
                    $famous->photo = $attributes['photo'];
                    $famous->SaveImage();
                }
                if ($famous->save()) {
                    $response = array(
                        'status' => true,
                        'info' => $famous->name->name . ' ' . $famous->last_name . ', ' . $famous->description,
                        'url' => $famous->GetUrl()
                    );
                } else {
                    $response = array(
                        'status' => false,
                        'error' => $famous->getErrors()
                    );
                }
            }
        } else {
            $response = array(
                'status' => false,
            );
        }
        echo CJSON::encode($response);
    }

    public function actionUploadPhoto()
    {
        $path = Yii::getPathOfAlias('site.frontend.www.temp_upload');
        $image = CUploadedFile::getInstanceByName('photo');
        if (!empty($image)) {
            if ($image->saveAs($path . '/' . $image->name)) {
                $response = array(
                    'status' => true,
                    'image' => Yii::app()->params['frontend_url'] . 'temp_upload/' . $image->name,
                    'name' => $image->name,
                );
            }
            else
            {
                $response = array(
                    'status' => false,
                );
            }
            echo CJSON::encode($response);
        } else
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'empty photo',
            ));
    }

    public function actionFamousInfo()
    {
        $id = Yii::app()->request->getPost('id');
        $model = $this->loadFamousModel($id);
        echo CJSON::encode(array_merge($model->attributes, array('url' => $model->GetUrl())));
    }

    public function actionNotFilled(){
        $names = Name::model()->findAll('description IS NULL OR description = "" ');

        $this->render('not_filed',compact('names'));
    }


    /**
     * @param int $id model id
     * @return NameFamous
     * @throws CHttpException
     */
    public function loadFamousModel($id)
    {
        $model = NameFamous::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}

