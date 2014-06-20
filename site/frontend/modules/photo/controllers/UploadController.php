<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/05/14
 * Time: 10:38
 */

namespace site\frontend\modules\photo\controllers;

use site\frontend\modules\photo\models\upload\FromComputerUploadForm;

class UploadController extends \HController
{
    public function actionForm()
    {
        $this->renderPartial('form');
    }

    public function actionUpload()
    {
        $this->render('upload');
    }

    public function actionFromComputer()
    {
        sleep(10);
        $form = new FromComputerUploadForm();
        echo $form->save();
    }
} 