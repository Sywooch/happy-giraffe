<?php
/**
 * Случайное фото
 *
 * Случайные новые фотографии, доступные для публичного просмотра.
 *
 * Author: choo
 * Date: 15.05.2012
 */
class RandomPhotosWidget extends CWidget
{
    public function run()
    {
        $photos = AlbumPhoto::model()->findAll(array(
            'limit' => '10',
            'with' => array(
                'album' => array(
                    'select' => false,
                    'scopes' => 'noSystem',
                ),
            ),
            'condition' => 'DATE_SUB(CURDATE(), INTERVAL 3 DAY) <= t.created AND album.permission = 0',
            'order' => 'RAND()',
        ));

        $this->render('RandomPhotosWidget', compact('photos'));
    }
}
