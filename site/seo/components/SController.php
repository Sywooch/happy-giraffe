<?php
/**
 * Author: alexk984
 * Date: 13.05.12
 */
class SController extends CController
{
    public $pageTitle = '';
    public $fast_nav = array();

    public function filters()
    {
        return array(
            'accessControl',
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

    public function getUserModules(){
        if (Yii::app()->user->checkAccess('superuser'))
            return array(
                'Ключевые слова'=>$this->createUrl('/competitors/default/index'),
                'Готовое'=>$this->createUrl('/writing/existArticles/index'),
                'Продвижение'=>$this->createUrl('/promotion/queries/admin'),
            );

        if (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('editor'))
            return array(
                'Ключевые слова'=>$this->createUrl('/competitors/default/index'),
                'Продвижение'=>$this->createUrl('/promotion/queries/admin'),
            );

        return array();
    }
}
