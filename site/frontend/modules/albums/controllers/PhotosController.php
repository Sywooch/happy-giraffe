<?php
class PhotosController extends AController
{
    public function actionAdd($a)
    {
        $album = Album::model()->findByPk($a);
        if (!$album)
            throw new CHttpException(404, 'Альбом не найден');

        if (isset($_FILES['file'])) {
            // HTML5 upload
            if (Yii::app()->request->isPostRequest) {
                $file = CUploadedFile::getInstanceByName('file');
                $model = new AlbumPhoto();
                $model->album_id = $a;
                $model->user_id = $album->user_id;
                $model->file = $file;
                if($model->create())
                    echo 1;
                else
                    echo 0;
                Yii::app()->end();
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.js' => false,
                'jquery-ui.min.js' => false,
                'jquery.yiilistview.js' => false,
                'jquery.ba-bbq.js' => false,
                'jquery-ui.css' => false,
            );
            $this->renderPartial('add', array(
                'album' => $album
            ), false, true);
        }
        else
            $this->render('add', array(
                'album' => $album
            ));
    }
}
