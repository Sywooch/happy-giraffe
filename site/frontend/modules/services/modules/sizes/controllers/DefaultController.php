<?php

class DefaultController extends HController
{
    public function actionWomenUnderwear()
    {
        $this->render('women_underwear');
    }

    public function actionMenShoes()
    {
        $this->render('men_shoes');
    }

    public function actionWomenShoes()
    {
        $this->render('women_shoes');
    }

    public function actionMenClothes()
    {
        $this->render('men_clothes');
    }

    public function actionWomenClothes()
    {
        $this->render('women_clothes');
    }

    public function actionChildrenClothes()
    {
        $this->render('children_clothes');
    }

    public function actionSocks()
    {
        $this->render('socks');
    }

    public function beforeAction($action)
    {
        Yii::app()->clientScript->registerScript('size-module', 'function change(which) {
            for (var i = 0; i < document.form1.elements.length; i++) {
                if ((document.form1.elements[i].type == "select-one")) {
                    document.form1.elements[i].selectedIndex = which;
                }
            }
        }', CClientScript::POS_HEAD);
        return parent::beforeAction($action);
    }
}