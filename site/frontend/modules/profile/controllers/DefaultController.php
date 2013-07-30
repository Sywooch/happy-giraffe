<?php

class DefaultController extends HController
{
    public $layout = '//layouts/common_new';
    public $tempLayout = true;

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $user_id);
        $criteria->scopes = array('active');
        $criteria->with = array(
            'status',
            'purpose',
            'avatar' => array('select' => array('fs_name', 'author_id')),
            'address' => array('select' => array('country_id', 'region_id', 'city_id')),
            'partner',
            'babies',
            'mood',
            'score',
            'albumsCount',
        );
        $user = User::model()->find($criteria);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        $this->render('index', compact('user'));
    }

    public function actionAbout(){
        $user = Yii::app()->user->getModel();
        $user->about = Yii::app()->request->getPost('about');
        $user->update(array('about'));

        echo CJSON::encode(array('status' => true, 'about' => $user->about));
    }
}