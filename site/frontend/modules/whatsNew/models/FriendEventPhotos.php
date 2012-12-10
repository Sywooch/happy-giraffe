<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:41 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventPhotos extends FriendEvent
{
    public $type = FriendEvent::TYPE_PHOTOS_ADDED;
    public $album_id;

    private $_album;
    private $_photos;

    public function init()
    {
        $this->_album = $this->_getAlbum();
        $this->_photos = $this->_getPhotos();
    }

    public function getAlbum()
    {
        return $this->_album;
    }

    public function setAlbum($album)
    {
        $this->_album = $album;
    }

    private function _getAlbum()
    {
        return Album::model()->findByPk($this->album_id);
    }

    public function getPhotos()
    {
        return $this->_photos;
    }

    public function setPhotos($photos)
    {
        $this->_photos = $photos;
    }

    private function _getPhotos()
    {
        $criteria = new CDbCriteria(array(
            'limit' => 9,
            'condition' => 'album_id = :album_id',
            'params' => array(':album_id' => $this->album_id),
            'order' => 'created DESC',
        ));

        return AlbumPhoto::model()->findAll($criteria);
    }

    public function getLabel()
    {
        return HDate::simpleVerb('Добавил', $this->user->gender) . ' фото в альбом';
    }

    public function createBlock()
    {
        $this->album_id = (int) $this->params['album_id'];
        $this->user_id = (int) $this->params['user_id'];

        parent::createBlock();
    }

    public function updateBlock($new)
    {
        $this->updated = time();
        $this->save();
    }

    public function getStack()
    {
        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'album_id' => array(
                    'equals' => (int) $this->params['album_id'],
                ),
            ),
        ));

        return FriendEvent::model($this->type)->find($criteria);
    }
}
