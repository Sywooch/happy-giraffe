<?php

class WidgetsController extends Controller
{
    public function actionIndex()
    {
        $widgets = ProfileWidget::model()->findAll();
        $this->render('index', array(
            'widgets' => $widgets,
        ));
    }
}
