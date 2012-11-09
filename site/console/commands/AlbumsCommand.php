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
}
