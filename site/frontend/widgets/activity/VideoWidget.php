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
        $videoIds = Favourites::getIdListForView(Favourites::BLOCK_VIDEO, 1);
        if (! empty($videoIds)) {
            $video = CommunityContent::model()->findByPk($videoIds[0]);
            $data = new Video($video->video->link);
            $this->render('VideoWidget', compact('video', 'data'));
        }
    }
}
