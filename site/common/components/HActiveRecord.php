<?php
/**
 * Author: choo
 * Date: 25.04.2012
 */
class HActiveRecord extends CActiveRecord
{
    private $_entities = array(
        'post' => 'Пост',
        'video' => 'Видео',
        'photo' => 'Фото',
    );

    public function getPhotoCollection()
    {
        return $this->photos;
    }

    public function getPhotoCollectionDependency()
    {
        $sql = "
            SELECT MAX(p.created) FROM album__photo_attaches pa
            INNER JOIN album__photos p ON pa.photo_id = p.id
            WHERE pa.entity = :entity AND pa.entity_id = :entity_id;
        ";

        return array(
            'class'=>'system.caching.dependencies.CDbCacheDependency',
            'sql' => $sql,
            'params' => array(':entity' => get_class($this), ':entity_id' => $this->id),
        );
    }

    public function getErrorsText()
    {
        $errorText = '';
        foreach ($this->getErrors() as $error) {
            foreach($error as $errorPart)
                $errorText.= $errorPart.' ';
        }

        return $errorText;
    }

    public function getShare($service)
    {
        switch ($service) {
            case 'vkontakte':
                $url = 'http://vk.com/share.php?title={title}&description={description}&url={url}&image={image}';
                break;
            case 'odnoklassniki':
                $url = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments={description}&st._surl={url}';
                break;
        }

        return strtr($url, array(
            '{title}' => urlencode($this->shareTitle),
            '{description}' => urlencode($this->shareDescription),
            '{image}' => urlencode($this->shareImage),
            '{url}' => urlencode($this->shareUrl),
        ));
    }

    public function getShareTitle()
    {
        return ($this->hasAttribute('title') ? $this->title : '');
    }

    public function getShareDescription()
    {
        return ($this->hasAttribute('description') ? $this->description : '');
    }

    public function getShareImage()
    {
        return (isset($this->getMetaData()->relations['photo']) && $this->photo instanceof AlbumPhoto) ? $this->photo->getPreviewPath(180, 180) : '';
    }

    public function getShareUrl()
    {
        return $this->getUrl(false, true);
    }

    public function getRelatedModel($condition = '', $params = array())
    {
        return ($this->hasAttribute('entity') && $this->hasAttribute('entity_id')) ? CActiveRecord::model($this->entity)->resetScope()->findByPk($this->entity_id, $condition, $params) : null;
    }

    public function getEntity()
    {
        switch (get_class($this)) {
            case 'AlbumPhoto':
                return 'photo';
            case 'CookRecipe':
                return 'cook';
            case 'CommunityContent':
            case 'BlogContent':
                return $this->type_id == 1 ? 'post' : 'video';
        }
    }

    public function getEntityTitle()
    {
        return $this->_entities[$this->entity];
    }

    public function getCacheId($keyword)
    {
        return __CLASS__ . $this->primaryKey . $keyword;
    }

    public function getLikedUsers($limit)
    {
        $likes = HGLike::model()->findAllByEntity($this);

        $usersIds = array_map(function($like) {
            return $like['user_id'];
        }, $likes);

        $criteria = new CDbCriteria();
        $criteria->limit = $limit;
        if (! Yii::app()->user->isGuest)
            $criteria->compare('t.id', '<>' . Yii::app()->user->id);
        $criteria->addInCondition('t.id', $usersIds);
        $users = User::model()->findAll($criteria);

        return $users;
    }

    public function getFavouritedUsers($limit)
    {
        $favourites = Favourite::model()->getAllByModel($this, $limit);
        $users = array_map(function($favourite) {
            return $favourite->user;
        }, $favourites);
        return $users;
    }

    public function getEntityName()
    {
        $reflect = new ReflectionClass($this);
        return $reflect->getShortName();
    }
//    protected function beforeFind()
//    {
//        parent::$db = $this->getConnectionForSelect();
//        parent::beforeFind();
//    }
//
//    protected function afterFind()
//    {
//        parent::$db = null;
//        parent::afterFind();
//    }
//
//    protected function getConnectionForSelect()
//    {
//        $connectionIds = Yii::app()->params['selectConnections'];
//        if ($connectionIds === null)
//            return null;
//
//        $resultConnection = null;
//        $minLoad = 100;
//        foreach ($connectionIds as $id) {
//            if (isset(Yii::app()->$id) && Yii::app()->$id instanceof CDbConnection) {
//                $connection = Yii::app()->$id;
//                $load = $this->getLoad($connection);
//                if ($load < $minLoad)
//                    $resultConnection = $connection;
//            }
//        }
//        return $resultConnection;
//    }
//
//    protected function getLoad(CDbConnection $connection)
//    {
//        return $this->getActiveConnectionsCount($connection) / $this->getConnectionsLimit($connection);
//    }
//
//    protected function getConnectionsLimit(CDbConnection $connection)
//    {
//        return $connection->cache(3600)->createCommand('SELECT @@MAX_CONNECTIONS;')->queryScalar();
//    }
//
//    protected function getActiveConnectionsCount(CDbConnection $connection)
//    {
//        return $connection->cache(60)->createCommand('SHOW STATUS WHERE `variable_name` = \'Threads_connected\';')->queryScalar();
//    }
}
