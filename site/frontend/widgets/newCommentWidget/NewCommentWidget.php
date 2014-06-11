<?php

class NewCommentWidget extends CWidget
{
    /**
     * @var HActiveRecord|CommunityContent модель, к которой привязываются комментарии
     */
    public $model;
    /**
     * @var string Название класса модели
     */
    public $entity;
    /**
     * @var int Primary key модели
     */
    public $entity_id;
    /**
     * @var bool Имя созданного js объекта
     */
    public $objectName = false;
    /**
     * @var bool показываем ли все комментарии
     */
    public $full = true;
    /**
     * @var bool Только загрузить скрипты
     */
    public $registerScripts = false;
    /**
     * @var bool Если галерея, всё работает немного иначе
     */
    public $gallery = false;
    public $notice = '';

    public function init()
    {
        if ($this->model) {
            $this->entity = get_class($this->model);
            if ($this->entity == 'CommunityContent' || $this->entity == 'BlogContent') {
                if ($this->model->getIsFromBlog())
                    $this->entity = 'BlogContent';
                else
                    $this->entity = 'CommunityContent';
            }
            $this->entity_id = $this->model->primaryKey;
        } elseif ($this->entity) {
            $model = call_user_func(array($this->entity, 'model'));
            $this->model = $model->findByPk($this->entity_id);
        }
    }

    public function run()
    {
        Yii::app()->clientScript->registerPackage('ko_comments');

        if ($this->registerScripts === false) {
            $this->objectName = 'new_comment_' . $this->entity . $this->entity_id . time();
            if ($this->gallery)
                $this->render('gallery_view');
            else
                $this->render('view');
        }
    }

    /**
     * Возвращает информацию о комментариях
     * @return array
     */
    public function getComments()
    {
        if ($this->isAlbumComments())
            $criteria = $this->getAlbumComments();
        elseif ($this->isPhotoPost())
            $criteria = $this->getGalleryComments(); else
            $criteria = $this->getCommentsCriteria();

        $criteria->order = 't.created DESC';
        $criteria->limit = 100;

        return Comment::model()->findAll($criteria);
    }

    /**
     * @return CDbCacheDependency
     */
    public function getCacheDependency()
    {
        $cacheDependency = new CDbCacheDependency('select GREATEST(MAX(created),MAX(updated)) from comments WHERE entity=:entity AND entity_id=:entity_id');

        if ($this->isAlbumComments()) {
            $photoIds = $this->getAlbumsPhotoIds();
            if (!empty($photoIds))
                $cacheDependency = new CDbCacheDependency('select GREATEST(MAX(created),MAX(updated)) from comments WHERE entity=:entity AND entity_id=:entity_id OR entity="AlbumPhoto" AND entity_id IN (' . implode(',', $photoIds) . ')');
        } elseif ($this->isPhotoPost()) {
            $photoIds = $this->getGalleryPhotoIds();
            if (!empty($photoIds))
                $cacheDependency = new CDbCacheDependency('select GREATEST(MAX(created),MAX(updated)) from comments WHERE entity=:entity AND entity_id=:entity_id OR entity="AlbumPhoto" AND entity_id IN (' . implode(',', $photoIds) . ')');
        }
        $cacheDependency->params = array(':entity' => $this->entity, ':entity_id' => $this->entity_id);

        return $cacheDependency;
    }

    /**
     * Возвращает комментарии к статье
     * @return CDbCriteria
     */
    public function getCommentsCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.entity=:entity AND t.entity_id=:entity_id';
        $criteria->params = array(':entity' => $this->entity, ':entity_id' => $this->entity_id);
        $criteria->with = array('author' => array(
            'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
        ));
        return $criteria;
    }

    /**
     * Возвращает информацию о комментариях к альбому - комментарии к альбому + комментарии к фото из альбома
     * @return CDbCriteria
     */
    private function getAlbumComments()
    {
        return $this->getCriteriaWithPhotos($this->getAlbumsPhotoIds());
    }

    /**
     * @return int[]
     */
    private function getAlbumsPhotoIds()
    {
        return Yii::app()->db->createCommand()
            ->select('id')
            ->from('album__photos')
            ->where('album_id = :album_id', array(':album_id' => $this->entity_id))
            ->queryColumn();
    }

    /**
     * Возвращает информацию о комментариях к фотопосту - комментарии к фотопосту + комментарии к фото из фотопоста
     * @return CDbCriteria
     */
    private function getGalleryComments()
    {
        return $this->getCriteriaWithPhotos($this->getGalleryPhotoIds());
    }

    /**
     * @return int[]
     */
    private function getGalleryPhotoIds()
    {
        return Yii::app()->db->createCommand()
            ->select('photo_id')
            ->from('community__content_gallery_items')
            ->where('gallery_id = :gallery_id', array(':gallery_id' => $this->model->gallery->id))
            ->queryColumn();
    }

    /**
     * Возвращает комменты поста + комменты фоток
     *
     * @param int[] $photoIds
     * @return CDbCriteria
     */
    public function getCriteriaWithPhotos($photoIds)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.entity=:entity AND t.entity_id=:entity_id';
        if (!empty($photoIds))
            $criteria->condition .= ' OR t.entity="AlbumPhoto" AND t.entity_id IN (' . implode(',', $photoIds) . ')';
        $criteria->params = array(':entity_id' => $this->entity_id, ':entity' => $this->entity);
        $criteria->with = array('author' => array(
            'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
            'with' => 'avatar',
        ));

        return $criteria;
    }

    /**
     * Комментарии к альбому?
     * @return bool
     */
    public function isAlbumComments()
    {
        return ($this->entity == 'Album');
    }

    /**
     * Комментарии к фотопосту?
     * @return bool
     */
    public function isPhotoPost()
    {
        return (($this->entity == 'CommunityContent' || $this->entity == 'BlogContent') && $this->model->type_id == CommunityContent::TYPE_PHOTO_POST);
    }

    public function isSummaryPhotoComments()
    {
        return $this->isAlbumComments() || $this->isPhotoPost();
    }
}