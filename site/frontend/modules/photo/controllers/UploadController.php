<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/05/14
 * Time: 10:38
 */

namespace site\frontend\modules\photo\controllers;

use site\frontend\modules\photo\models\upload\ByUrlUploadForm;
use site\frontend\modules\photo\models\upload\FromComputerUploadForm;
use site\frontend\modules\photo\models\upload\PopupForm;

class UploadController extends \HController
{
    public function actionForm()
    {
        $form = new PopupForm();
        $form->attributes = $_GET;
        if ($form->validate()) {
            $this->renderPartial('form', compact('form'));
        }
    }

    public function actionUpload()
    {
        $this->render('upload');
    }

    public function actionFromComputer()
    {
        $i = \CUploadedFile::getInstanceByName('files');
        var_dump($i);
        die;

        $form = new FromComputerUploadForm();
    }

    public function actionByUrl()
    {
        $form = new ByUrlUploadForm();
        $form->attributes = array('url' => 'http://fotoshops.org/uploads/taginator/Oct-2013/image.jpg');
        if ($form->validate()) {
            echo $form->save();
        }
    }
} 