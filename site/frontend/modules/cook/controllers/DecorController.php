<?php
class DecorController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Оформление блюд';

        $this->render('index');
    }
}