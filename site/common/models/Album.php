<?php

/**
 * This is the model class for table "albums".
 *
 * The followings are the available columns in table 'albums':
 * @property string $id
 * @property integer $title
 * @property string $description
 * @property string $author_id
 * @property integer $type
 * @property integer $permission
 * @property string $created
 * @property string $updated
 * @property integer $removed
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Album extends CActiveRecord
{
    private $_check_access = null;
    public $files = array();

    public static $systems = array(
        1 => 'Личные фотографии',
        2 => 'Диалоги',
    );

    public static $permissions = array(
        'для всех',
        'для друзей',
        'для меня одного',
    );

	/**
	 * Returns the static model of the specified AR class.
	 * @return Album the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'albums';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, author_id', 'required'),
            array('title', 'length', 'max' => 100),
            array('description', 'length', 'max' => 140),
			array('author_id', 'length', 'max'=>10),
            array('type, permission', 'numerical'),
            array('created, updated, files', 'safe'),
            array('removed', 'boolean'),
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
            'photos' => array(self::HAS_MANY, 'AlbumPhoto', 'album_id', 'scopes' => array('active')),
            'photoCount' => array(self::STAT, 'AlbumPhoto', 'album_id', 'condition'=>'removed = 0'),
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => '`remove`.`entity` = :entity', 'params' => array(':entity' => get_class($this)))
		);
	}

    public function defaultScope()
    {
        return array(
            'order' => 'type asc',
        );
    }

    public function scopes()
    {
        return array(
            'full' => array(
                'join' => 'inner join album_photos p on ' . $this->tableAlias . '.id = p.album_id'
            ),
            'active' => array(
                'condition' => $this->tableAlias . '.removed = 0',
            ),
            'noSystem' => array(
                'condition' => $this->tableAlias . '.type = 0 or ' . $this->tableAlias . '.type = 1',
            ),
            'system' => array(
                'condition' => $this->tableAlias . '.type != 0 and ' . $this->tableAlias . '.type != 1',
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            )
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название альбома',
			'description' => 'Описание',
			'author_id' => 'User',
            'created' => 'Дата создания',
            'updated' => 'Дата последнего обновления',
		);
	}

    public function findByUser($author_id, $permission = false, $system = false)
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = array();
        $criteria->addCondition('t.author_id = :author_id');
        $criteria->params[':author_id'] = $author_id;
        if($permission !== false)
        {
            $criteria->addCondition('permission = :permission and (type = 0 || type = 1)');
            $criteria->params[':permission'] = $permission;
        }
        if($system !== false)
        {
            if($system == 1)
                array_push($criteria->scopes, 'system');
            else
                array_push($criteria->scopes, 'noSystem');
        }
        array_push($criteria->scopes, 'active');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getCheckAccess()
    {
        if(!Yii::app()->user->isGuest && Yii::app()->user->id == $this->author_id)
            return true;
        return false;
    }

    public function getAlbumPhotos()
    {
        if($this->isNewRecord)
            return $this->files;
        else
            return $this->photos;
    }

    public function getSystemAlbums()
    {
        $albums = array();
        $criteria = new CDbCriteria;
        $criteria->addCondition('album_id is null');
    }

    public function getIsNotSystem()
    {
        if($this->type == 0 || $this->type == 1)
            return true;
        return false;
    }

    public function afterSave()
    {
        if(count($this->files) > 0)
        {
            foreach($this->files['id'] as $i => $id)
            {
                if($id != '')
                    AlbumPhoto::model()->updateByPk($id, array('title' => $this->files['title'][$i]));
                else
                {
                    $model = new AlbumPhoto;
                    $model->album_id = $this->id;
                    $model->author_id = $this->author_id;
                    $model->title = $this->files['title'][$i];
                    $model->file_name = $this->files['fsn'][$i];
                    $model->create(true);
                }
            }
        }
    }

    public function beforeDelete()
    {
        if (count($this->photos) > 0 ){
            foreach($this->photos as $photo)
                UserSignal::closeRemoved($photo, false);
            UserSignal::sendUpdateSignal();

            Yii::import('site.frontend.modules.scores.models.*');
            UserScores::removeScores($this->author_id, ScoreActions::ACTION_PHOTO, count($this->photos), $this->photos[0]);
        }

        $this->removed = 1;
        $this->save();

        return false;
    }
}