<?php

Yii::import('application.widgets.profile.*');

class WidgetsController extends Controller
{
    public function actionIndex()
    {
        $widgets = ProfileWidget::model()->findAll();
        $this->render('index', array(
            'widgets' => $widgets,
        ));
    }

    public function actionAdd($widget_id)
    {
        $box = new ProfileWidgetBox;
        $box->user_id = Yii::app()->user->id;
        $box->widget_id = $widget_id;
        $box->settings = $box->widget()->object->defaults;
        $box->save();

        $this->redirect(array('settings', 'box_id' => $box->primaryKey));
    }

    public function actionSettings($box_id)
    {
        $box = ProfileWidgetBox::model()->findByPk(new MongoID($box_id));

        if (isset($_POST['Settings']))
        {
            $box->settings = $_POST['Settings'];
            $box->save();
        }

        $this->render('settings', array(
            'box' => $box,
        ));
    }
}
