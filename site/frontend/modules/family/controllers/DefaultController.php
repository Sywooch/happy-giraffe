<?php

class DefaultController extends HController
{
	public function actionSignup()
	{
        $json = Yii::app()->user->model->getFamilyData();
        $this->layout = '//layouts/simple';
        $this->render('signup', compact('json'));
	}

    public function actionSave()
    {
        $babies = Yii::app()->request->getPost('babies');
        if ($babies !== null)
            foreach ($babies as $babyData) {
                $baby = new Baby();
                $baby->attributes = $babyData;
                $baby->parent_id = Yii::app()->user->id;
                $baby->save();
                print_r($baby->errors);
            }
    }
}