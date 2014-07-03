<?php
/**
 * Контроллер для загрузки фото
 */

namespace site\frontend\modules\photo\controllers;
use site\frontend\modules\photo\components\InlinePhotoModifier;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\upload\AttachForm;
use site\frontend\modules\photo\models\upload\ByUrlUploadForm;
use site\frontend\modules\photo\models\upload\FromComputerUploadForm;
use site\frontend\modules\photo\models\upload\PopupForm;

class UploadController extends \HController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionFromAlbumsStep1()
    {
        $album = PhotoAlbum::model()->find();

        $a = \HJSON::encode(array('albums' => $album), array(
            'site\frontend\modules\photo\models\PhotoAlbum' => array(
                'id',
                'title',
                'description',
                'photoCollection' => array(
                    'site\frontend\modules\photo\models\PhotoCollection' => array(
                        'id',
                        '(int)attachesCount',
                        'cover',
                    ),
                ),
            ),
        ));

        $this->render('test', compact('a'));
    }

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

    public function actionRotate()
    {
        $photoId = \Yii::app()->request->getPost('photoId');
        $angle = \Yii::app()->request->getPost('angle');

        $photo = Photo::model()->findByPk($photoId);
        $success = InlinePhotoModifier::rotate($photo, $angle);
        echo \HJSON::encode(array('photo' => $photo));
    }

    public function actionAttach()
    {
        $form = new AttachForm();
        $form->attributes = $_POST;
        echo $form->save();
    }
} 