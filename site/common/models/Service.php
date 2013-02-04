<?php

/**
 * This is the model class for table "services".
 *
 * The followings are the available columns in table 'services':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property int $photo_id
 * @property int $show
 * @property int $using_count
 *
 * The followings are the available model relations:
 * @property ServiceCategory $category
 * @property AlbumPhoto $photo
 */
class Service extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Service the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'services';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, description, url', 'required'),
            array('title, url', 'length', 'max' => 255),
            array('url', 'url'),
            array('photo_id', 'numerical', 'integerOnly' => true),
            array('category_id', 'exist', 'attributeName' => 'id', 'className' => 'ServiceCategory'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, url', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::BELONGS_TO, 'ServiceCategory', 'category_id'),
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
            'commentsCount' => array(self::STAT, 'Comment', 'entity_id', 'condition' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
        );
    }

    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('url',$this->url,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array('pageSize' => 100),
        ));
    }

    public function scopes()
    {
        return array(
            'visible' => array(
                'condition' => '`show`=1'
            ),
        );
    }

    public function getImage()
    {
        if (!empty($this->photo_id)) {
            return CHtml::image($this->photo->getPreviewUrl(70, 70));
        }

        return '';
    }

    public function userUsedService()
    {
        $this->incCount();
        if (! Yii::app()->user->isGuest) {
            ServiceUser::addCurrentUser($this->id);
            FriendEventManager::add(FriendEvent::TYPE_SERVICE_USED, array('service_id' => $this->id, 'user_id' => Yii::app()->user->id));
        }
    }

    public function incCount()
    {
        Yii::app()->db->createCommand('update ' . $this->tableName() . ' set using_count = using_count+1 where id=' . $this->id)->execute();
    }

    /**
     * @param int $limit
     * @return User[]
     */
    public function getLastUsers($limit = 20)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'avatar_id IS NOT NULL AND deleted=0';
        $criteria->compare('service_id', $this->id);
        $criteria->order = 'use_time desc';
        $criteria->limit = $limit;
        $criteria->join = 'LEFT JOIN users ON users.id=t.user_id';
        $users = ServiceUser::model()->findAll($criteria);
        if (empty($users))
            return array();

        $ids = array();
        foreach ($users as $user)
            $ids[] = $user->user_id;

        $criteria = new CDbCriteria;
        $criteria->compare('id', $ids);
        $users = User::model()->findAll($criteria);

        $sorted_users = array();

        $i = 0;
        while ($i < count($ids)) {
            foreach ($users as $user)
                if ($user->id == $ids[$i]) {
                    $sorted_users[] = $user;
                    break;
                }

            $i++;
        }

        return $sorted_users;
    }

    /**
     * @return int
     */
    public function usersCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('service_id', $this->id);
        return ServiceUser::model()->cache(10)->count($criteria);
    }

    public function getUrl($comments = false)
    {
        return $comments ? $this->url . '#comment_list' : $this->url;
    }

    public function getUnknownClassCommentsCount()
    {
        return $this->commentsCount;
    }
}