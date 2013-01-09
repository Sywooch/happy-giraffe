<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/9/12
 * Time: 9:27 AM
 * To change this template use File | Settings | File Templates.
 */
class AlbumsCommand extends CConsoleCommand
{
    public function actionFixPhoto($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $photo->getPreviewPath(210, null, Image::WIDTH, false, AlbumPhoto::CROP_SIDE_CENTER, true);
    }

    public function actionTest()
    {
        Yii::import('site.frontend.extensions.EPhpThumb.*');

        $this->getPreviewPath(300, 1000);
    }

    public function getPreviewPath($width = 100, $height = 100, $master = false)
    {
        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed


        $thumb = $thumb->create('F:/mira.jpg');
        var_dump($thumb->getCurrentDimensions());
        $thumb = $thumb->resize($width, $height);
        $thumb->save('F:/mira2.jpg');
    }
}
