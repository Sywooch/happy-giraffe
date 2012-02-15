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
        $box->save();

        $class = $box->widget()->class;
        $widget = new $class;
        $widget->init();

        foreach ($widget->defaults as $name => $value)
        {
            $setting = new ProfileWidgetSetting;
            $setting->box_id = $box->primaryKey;
            $setting->attribute_name = $name;
            $setting->attribute_value = $value;
            $setting->save();
        }

        $this->redirect(array('settings', 'box_id' => $box->primaryKey));
    }

    public function actionSettings($box_id)
    {
        $box = ProfileWidgetBox::model()->findByPk(new MongoID($box_id));
        $this->render('settings', array(
            'box' => $box,
            'settings' => ProfileWidgetSetting::model()->getUserSettings(Yii::app()->user->id),
        ));
    }
}
