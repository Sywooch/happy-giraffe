<?php

class DefaultController extends HController
{
    public $layout = '//layouts/main';


    public function filters()
    {
        return array(
            'accessControl',
            'Remove + ajaxOnly'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Мои баллы';

        $num = Yii::app()->request->getPost('num', 0);
        $page = Yii::app()->request->getPost('page', 0);

        ScoreInput::getInstance()->readAll(Yii::app()->user->id);

        $list = ScoreInput::getInstance()->getList(Yii::app()->user->id, $num, $page);
        $score = Yii::app()->user->getModel()->score;

        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('list', compact('list', 'score'));
        else
            $this->render('index', compact('list', 'score'));
    }
}