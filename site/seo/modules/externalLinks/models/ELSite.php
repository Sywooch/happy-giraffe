<?php

/**
 * This is the model class for table "externallinks__sites".
 *
 * The followings are the available columns in table 'externallinks__sites':
 * @property string $id
 * @property string $url
 * @property integer $type
 * @property integer $status
 * @property string $created
 * @property integer $bad_rating
 * @property integer $comments_count
 *
 * The followings are the available model relations:
 * @property ELAccount $account
 * @property ELLink[] $links
 * @property ELTask[] $tasks
 */
class ELSite extends HActiveRecord
{
    const STATUS_NORMAL = 0;
    const STATUS_GOOD = 1;
    const STATUS_BLACKLIST = 2;

    const TYPE_SITE = 1;
    const TYPE_FORUM = 2;
    const TYPE_BLOG = 3;

    public $comment;
    public $buttons;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ELSite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_seo;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'externallinks__sites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url', 'required'),
			array('type, status, comments_count, bad_rating', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, type, status, created', 'safe', 'on'=>'search'),
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
			'account' => array(self::HAS_ONE, 'ELAccount', 'site_id'),
			'links' => array(self::HAS_MANY, 'ELLink', 'site_id'),
            'linksCount' => array(self::STAT, 'ELLink', 'site_id'),
			'tasks' => array(self::HAS_MANY, 'ELTask', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
			'type' => 'Type',
			'status' => 'Status',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created);
		$criteria->compare('comments_count',$this->comments_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array('pageSize' => 100),
		));
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
        );
    }

    public function getCommentsCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NOT NULL';
        $criteria->compare('site_id', $this->id);
        $criteria->compare('type', ELTask::TYPE_COMMENT);

        return ELTask::model()->count($criteria);
    }

    public function addToBlacklist()
    {
        $this->status = ELSite::STATUS_BLACKLIST;
        ELTask::model()->updateAll(array('closed'=>date("Y-m-d H:i:s")), 'site_id = :site_id AND closed IS NULL', array(
            ':site_id'=> $this->id
        ));
        return $this->save();
    }

    public function removeFromBlacklist()
    {
        ELTask::model()->deleteAll('site_id = '.$this->id);
        $this->bad_rating = 0;
        $this->status = self::STATUS_GOOD;
        $this->save();
        ELTask::createRegisterTask($this->id, Yii::app()->user->id);
    }

    public function getComment()
    {
        foreach($this->links as $link)
            if (empty($link->check_link_time))
                return 'ссылка удалена';

        return '';
    }

    public function getCssClass(){
        return 'red-'.$this->bad_rating;
    }

    public function getBlackListButtons()
    {
        $result = CHtml::hiddenField('site_id', $this->id);
        $result .= CHtml::link(CHtml::image('/images/bad_mark.png'), 'javascript:;', array('onclick'=>'ExtLinks.downgrade(this)'));
        $result .= '&nbsp;&nbsp;'.CHtml::link(CHtml::image('/images/good_mark.png'),
            '#removeFromBlfancybox', array(
                'class' => 'fancy',
                'onclick'=>'if ($(this).prev().prev().val() !== undefined) $("#site_id").val($(this).prev().prev().val());'
            ));

        return $result;
    }

    public function getGreyListButtons()
    {
        return '<a href="javascript:;" class="icon-blacklist" onclick="ExtLinks.AddToBL2('.$this->id.')">ЧС</a>';
    }

    public function getTitle()
    {
        if ($this->type == self::TYPE_FORUM)
            return 'форум';
        if ($this->type == self::TYPE_BLOG)
            return 'блог';
        if ($this->type == self::TYPE_SITE)
            return 'сайт';

        return 'неизвестно';
    }

    public function getUrl(){
        if (strpos('http', $this->url) === 0)
            return 'http://'.$this->url;

        return $this->url;
    }
}