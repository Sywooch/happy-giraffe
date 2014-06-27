<?php
/**
 * Контроллер для загрузки фото
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\models\upload\ByUrlUploadForm;
use site\frontend\modules\photo\models\upload\FromComputerUploadForm;
use site\frontend\modules\photo\models\upload\PopupForm;

class UploadController extends \HController
{
    /**
     * Выводит попап загрузки фото
     */
    public function actionForm()
    {
        $form = new PopupForm();
        $form->attributes = $_GET;
        if ($form->validate()) {
            $this->renderPartial('form', compact('form'));
        }
    }

    /**
     * Обработка загрузки с компьютера
     */
    public function actionFromComputer()
    {
        $form = new FromComputerUploadForm();
        $form->file = \CUploadedFile::getInstanceByName('image');
        echo $form->save();
    }

    /**
     * Обработка загрузки по URL
     */
    public function actionByUrl()
    {
        $form = new ByUrlUploadForm();
        $form->attributes = $_POST;
        echo $form->save();
    }
} 