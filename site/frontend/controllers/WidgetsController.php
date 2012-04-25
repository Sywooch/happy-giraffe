<?php

Yii::import('application.widgets.profile.*');

class WidgetsController extends HController
{
    public function actionIndex()
    {
        $widgets = ProfileWidget::model()->findAll();
        $this->render('index', array(
            'widgets' => $widgets,
        ));
    }

    public function actionShow()
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id = Yii::app()->user->id;
        $boxes = ProfileWidgetBox::model()->findAll();
        $this->render('show', array(
            'boxes' => $boxes,
        ));
    }

    public function actionAdd($widget_id)
    {
        $box = new ProfileWidgetBox;
        $box->user_id = Yii::app()->user->id;
        $box->widget_id = $widget_id;
        $box->settings = $box->widget()->object->defaults;
        $box->position_x = 1;
        $criteria = new EMongoCriteria;
        $criteria->user_id = Yii::app()->user->id;
        $box->position_y = ProfileWidgetBox::model()->count($criteria) + 1;
        $box->save();

        $this->redirect(array('settings', 'box_id' => $box->primaryKey));
    }

    public function actionSettings($box_id)
    {
        $box = ProfileWidgetBox::model()->findByPk(new MongoID($box_id));

        if (isset($_POST['Settings']))
        {
            $box->settings = $_POST['Settings'];
            if ($box->save()) {
                $this->redirect(array('show', '#' => $box_id));
            }
        }

        $this->render('settings', array(
            'box' => $box,
        ));
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $modelPk = Yii::app()->request->getPost('modelPk');
            $model = ProfileWidgetBox::model()->findByPk(new MongoID($modelPk));
            if ($model === null) {
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
            }

            echo $model->delete();
        }
    }
}
