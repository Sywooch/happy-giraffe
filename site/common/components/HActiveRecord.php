<?php
/**
 * Author: choo
 * Date: 25.04.2012
 */
class HActiveRecord extends CActiveRecord
{
    private $_attributes;
    private $_related;

    private $_apiRelated;
    private static $_apiMd = array();

    private $_entities = array(
        'post' => 'Пост',
        'video' => 'Видео',
        'photo' => 'Фото',
    );

    public function getPhotoCollection()
    {
        /** @var site\frontend\modules\photo\components\PhotoCollectionBehavior $behavior */
        if ($behavior = $this->asa('PhotoCollectionBehavior')) {
            return $behavior->getPhotoCollection();
        }

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

    public function apiRelations()
    {
        return array();
    }

    public function getApiRelated($name, $refresh = false, $params = array())
    {
        $md = $this->getApiMd();
        /** @var ApiRelation $relation */
        $relation = $md[$name];
        $a = $relation->className;
        $params = $relation->params;
        $params['id'] = $this->{$relation->foreignKey};

        print_r($params);
        die;

        $model = $a::model()->query('get', $params);
        return $model;
    }

    public function getApiMd()
    {
        $className = get_class($this);
        if(! array_key_exists($className, self::$_apiMd))
        {
            self::$_apiMd[$className] = array();
            foreach ($this->apiRelations() as $name => $config) {
                if (isset($config[0], $config[1], $config[2])) {
                    self::$_apiMd[$className][$name] = new site\frontend\components\api\ApiRelation($config[0], $config[1], $config[2], array_slice($config,3));
                } else {
                    throw new CException('Неверное описание API-отношеня');
                }
            }
        }
        return self::$_apiMd[$className];
    }

    public function __get($name)
    {
        if(isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        elseif(isset($this->getMetaData()->columns[$name]))
            return null;
        elseif(isset($this->_related[$name]))
            return $this->_related[$name];
        elseif(isset($this->getMetaData()->relations[$name]))
            return $this->getRelated($name);
        elseif(($apiMd = $this->getApiMd()) && isset($apiMd[$name])) {
            return $this->getApiRelated($name);
        }
        else
            return CComponent::__get
    }
}