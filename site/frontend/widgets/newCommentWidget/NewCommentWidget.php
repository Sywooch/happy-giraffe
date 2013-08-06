<?php

class NewCommentWidget extends CWidget
{
    /**
     * @var HActiveRecord модель, к которой привязываются комментарии
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

    public function init()
    {
        if ($this->model) {
            $this->entity = get_class($this->model);
            $this->entity_id = $this->model->primaryKey;
        } elseif ($this->entity) {
            $model = call_user_func(array($this->entity, 'model'));
            $this->model = $model->findByPk($this->entity_id);
        }
    }

    public function run()
    {
        self::registerScripts();

        if ($this->registerScripts === false) {
            $this->objectName = 'new_comment_' . $this->entity . $this->entity_id . time();

            if ($this->gallery)
                $this->render('gallery_view', array('comments' => $this->getComments()));
            else
                $this->render('view', array('comments' => $this->getComments()));
        }
    }

    public static function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile($baseUrl . '/comment.js', CClientScript::POS_HEAD)
            ->registerScriptFile('/javascripts/knockout.mapping-latest.js');
    }

    /**
     * Возвращает информацию о комментариях
     * @return array
     */
    private function getComments()
    {
        if ($this->isAlbumComments())
            return $this->getAlbumComments();

        $criteria = new CDbCriteria;
        $criteria->condition = 't.entity=:entity AND t.entity_id=:entity_id';
        $criteria->params = array(':entity' => $this->entity, ':entity_id' => $this->entity_id);
        $criteria->with = array('author' => array(
            'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
            'with' => 'avatar',
        ));

        if ($this->full) {
            $dataProvider = new CActiveDataProvider('Comment', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 1000,
                ),
            ));
            return $dataProvider->getData();
        } else {
            $criteria->order = 't.created DESC';
            $criteria->limit = 3;
            return array_reverse(Comment::model()->findAll($criteria));
        }
    }

    /**
     * Возвращает информацию о комментариях к альбому - комментарии к альбому + комментарии к фото из альбома
     * @return array
     */
    private function getAlbumComments()
    {
        $photoIds = Yii::app()->db->createCommand()
            ->select('id')
            ->from('album__photos')
            ->where('album_id = :album_id', array(':album_id'=>$this->entity_id))
            ->queryColumn();

        $criteria = new CDbCriteria;
        $criteria->condition = 't.entity="Album" AND t.entity_id=:entity_id';
        if (!empty($photoIds))
            $criteria->condition .= ' OR t.entity="AlbumPhoto" AND t.entity_id IN (' . implode(',', $photoIds) . ')';
        $criteria->params = array(':entity_id' => $this->entity_id);
        $criteria->with = array('author' => array(
            'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
            'with' => 'avatar',
        ));

        if ($this->full) {
            $dataProvider = new CActiveDataProvider('Comment', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 1000,
                ),
            ));
            return $dataProvider->getData();
        } else {
            $criteria->order = 't.created DESC';
            $criteria->limit = 3;
            return array_reverse(Comment::model()->findAll($criteria));
        }
    }

    /**
     * Комментарии к альбому?
     * @return bool
     */
    public function isAlbumComments()
    {
        return ($this->entity == 'Album');
    }
}