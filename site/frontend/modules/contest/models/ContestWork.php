<?php

/**
 * This is the model class for table "club_contest_work".
 *
 * The followings are the available columns in table 'club_contest_work':
 * @property string $id
 * @property string $contest_id
 * @property string $user_id
 * @property integer $title
 * @property string $created
 * @property integer $rate
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Contest $contest
 * @property AttachPhoto $photoAttach
 */
class ContestWork extends HActiveRecord
{
    public $file;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContestWork the static model class
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
		return 'contest__works';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_id, user_id, title', 'required'),
			array('id, contest_id, user_id, rate', 'length', 'max'=>10),
            array('file', 'required', 'on' => 'upload', 'message' => 'Необходимо выбрать фотографию'),
            array('removed', 'boolean'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, contest_id, user_id, title, created', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'user_id'),
			'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
            'photoAttach' => array(self::HAS_ONE, 'AttachPhoto', 'entity_id', 'condition' => '`photoAttach`.`entity` = :entity', 'params' => array(':entity' => get_class($this))),
            'winner' => array(self::HAS_ONE, 'ContestWinner', 'work_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => '`remove`.`entity` = :entity', 'params' => array(':entity' => get_class($this))),
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
            'pingable' => array(
                'class' => 'site.common.behaviors.PingableBehavior',
            ),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contest_id' => 'Contest',
			'user_id' => 'User',
			'title' => 'Название фото',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($sort = false)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('contest_id',$this->contest_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('title',$this->title);
		$criteria->compare('created',$this->created,true);

        if($sort)
        {
            $criteria->order = $sort . ' desc';
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 25,
            ),
		));
	}

    public function afterSave()
    {
        if ($this->isNewRecord){
            $relatedModel = $this->contest;

            if ($relatedModel->hasAttribute('last_updated')) {
                $relatedModel->last_updated = new CDbExpression('NOW()');
                $relatedModel->update(array('last_updated'));
            }

            $relatedModel->sendEvent();

            UserScores::addScores($this->user_id, ScoreAction::ACTION_CONTEST_PARTICIPATION, 1, $this);
            FriendEventManager::add(FriendEvent::TYPE_CONTEST_PARTICIPATED, array('id' => $this->id, 'user_id' => $this->author_id));
        }

        parent::afterSave();
    }

    public function getNeighboringWorks()
    {
        $prev = Yii::app()->db->createCommand('select id from ' . $this->tableName() . ' where contest_id = ' . $this->contest_id . ' and id < ' . $this->id . ' limit 1')->queryRow();
        $next = Yii::app()->db->createCommand('select id from ' . $this->tableName() . ' where contest_id = ' . $this->contest_id . ' and id > ' . $this->id . ' limit 1')->queryRow();
        return array(
            'prev' => $prev ? $prev['id'] : false,
            'next' => $next ? $next['id'] : false
        );
    }

    public function getParedDownTitle()
    {
        if(!file_exists($this->photoAttach->photo->getPreviewPath(150, 150)))
            return false;
        $photo_size = getimagesize($this->photoAttach->photo->getPreviewUrl(150, 150));
        $width = $photo_size[0];
        $text = Str::truncate($this->title, 0.54*$width);
        return $text;
    }

    public function getUrlParams()
    {
        return array(
            'albums/singlePhoto',
            array(
                'contest_id' => $this->contest_id,
                'photo_id' => $this->photoAttach->photo->id,
                'entity' => 'Contest',
            ),
        );
    }

    public function getUrl($comments = false, $absolute = false)
    {
        list($route, $params) = $this->urlParams;

        if ($comments)
            $params['#'] = 'comment_list';

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }

    public function getPosition()
    {
        return $this->count('rate > :rate AND contest_id = :contest_id', array(':rate' => $this->rate, ':contest_id' => $this->contest_id)) + 1;
    }

    public function getRssContent()
    {
        return CHtml::image($this->photoAttach->photo->getPreviewUrl(960, 627, Image::HEIGHT), $this->title);
    }

    public function getShareImage()
    {
        return $this->photoAttach->photo->getPreviewUrl(180, 180);
    }

    public function getAuthor_id()
    {
        return $this->user_id;
    }

    public function beforeDelete()
    {
        self::model()->updateByPk($this->id, array('removed' => 1));

        if ($this->remove->type != 0)
            UserNotification::model()->create(UserNotification::CONTEST_WORK_REMOVED, array('model' => $this));

        return false;
    }

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);

        return array(
            'condition' => ($alias) ? $alias . '.removed = 0' : 'removed = 0',
        );
    }
}