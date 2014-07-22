<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 20/06/14
 * Time: 19:23
 */

class VacancyController extends HController
{
    const VACANCY_BACKEND_DEVELOPER = 'backend';
    const VACANCY_FRONTEND_DEVELOPER = 'frontend';

    public function actionForm($type)
    {
        $model = new VacancyForm($type);

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vacancyForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['VacancyForm'])) {
            $model->attributes = $_POST['VacancyForm'];
            $success = $model->validate();
            if ($success)
                $model->send();
            echo CJSON::encode(compact('success'));
        } else {
            $this->layout = '//layouts/common';
            $this->pageTitle = ($type == 'backend') ? 'Вакансия «Web-разработчик»' : 'Вакансия «Frontend-разработчик»';
            $this->render('form', compact('model', 'type'));
        }
    }

    public function actionUpload()
    {
        sleep(1);
        $model = new CvForm();
        if ($model->validate() && $model->save()) {
            echo $model->result();
        }
    }
} 