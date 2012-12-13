<?php

/**
 * This is the model class for table "{{community_video}}".
 *
 * The followings are the available columns in table '{{community_video}}':
 * @property string $id
 * @property string $link
 * @property string $text
 * @property string $content_id
 * @property string $player_favicon
 * @property string $player_title
 * @property integer $photo_id
 *
 * @property AlbumPhoto $photo
 */
class CommunityVideo extends HActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return CommunityVideo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array(
			'cut' => array(
                'class' => 'site.common.behaviors.CutBehavior',
				'attributes' => array('text'),
				'edit_routes' => array('community/edit'),
			),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text'),
                'options' => array(
                    'AutoFormat.Linkify' => true,
                ),
            ),
            'externalImages' => array(
                'class' => 'site.common.behaviors.ExternalImagesBehavior',
                'attributes' => array('text'),
            ),
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community__videos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, text', 'required'),
			array('content_id', 'required', 'on' => 'edit'),
			array('link', 'length', 'max' => 255),
            array('link', 'url'),
			array('content_id', 'length', 'max' => 11),
			array('content_id, photo_id', 'numerical', 'integerOnly' => true),
			array('content_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityContent'),	
			
			//array('text', 'filter', 'filter' => array('Filters', 'add_nofollow')),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, link, text, content_id, player_favicon, player_title', 'safe', 'on'=>'search'),
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
			'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
			'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'link' => 'Ссылка на видео',
			'text' => 'Текст',
			'content_id' => 'Content',
			'player_favicon' => 'Player Favicon',
			'player_title' => 'Player Title',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('content_id',$this->content_id,true);
		$criteria->compare('player_favicon',$this->player_favicon,true);
		$criteria->compare('player_title',$this->player_title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->searchPreview(Yii::app()->user->id);
        else {
            if (isset($this->content->author_id))
                $this->searchPreview($this->content->author_id);
        }

        return parent::beforeSave();
    }

    public function getPhoto(){
        return $this->photo;
    }

    public function getEmbed()
    {
        if (empty($this->embed)){
            $this->searchPreview($this->content->author_id);
            $this->update(array('photo_id', 'embed'));
        }
        return $this->embed;
    }

    public function searchPreview($author_id)
    {
        $video = new Video($this->link);
        if (empty($video->image))
            return false;

        $photo = AlbumPhoto::createByUrl($video->image, $author_id, 6);
        $this->photo_id = $photo->id;
        $this->embed = $video->code;
    }

    public function getResizedEmbed($width)
    {
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');

        $doc = phpQuery::newDocumentHTML($this->getEmbed(), $charset = 'utf-8');
        $iframe = $doc->find('iframe');
        $ratio = pq($iframe)->attr('width') / $width;
        $height = round(pq($iframe)->attr('height') / $ratio);

        $iframe->attr('width', $width);
        $iframe->attr('height', $height);

        return $doc->html();
    }
}