<?php
/**
 * Видео дня
 *
 * Отображает отмеченные видео.
 *
 * Author: choo
 * Date: 15.05.2012
 */
class VideoWidget extends CWidget
{
    public function run()
    {
        $videoIds = Favourites::getIdList(Favourites::BLOCK_VIDEO, 1);
        $video = CommunityContent::model()->findByPk($videoIds[0]);
        $this->render('VideoWidget', compact('video'));
    }
}
