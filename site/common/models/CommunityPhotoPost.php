<?php

/**
 * This is the model class for table "club_community_photo_post".
 *
 * The followings are the available columns in table 'club_community_photo_post':
 * @property string $id
 * @property string $location
 * @property string $location_image
 * @property string $content_id
 * @property integer $is_published
 * @property string $lat
 * @property string $long
 * @property string $zoom
 *
 * The followings are the available model relations:
 * @property CommunityContent $content
 * @property CommunityPhoto[] $photos
 */
class CommunityPhotoPost extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommunityPhotoPost the static model class
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
		return 'club_community_photo_post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_id', 'required'),
			array('is_published', 'numerical', 'integerOnly'=>true),
			array('location, location_image', 'length', 'max'=>256),
			array('content_id', 'length', 'max'=>11),
			array('lat, long', 'length', 'max'=>255),
			array('zoom', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, location, location_image, content_id, is_published, lat, long, zoom', 'safe', 'on'=>'search'),
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
			'photos' => array(self::HAS_MANY, 'CommunityPhoto', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'location' => 'Location',
			'location_image' => 'Location Image',
			'content_id' => 'Content',
			'is_published' => 'Is Published',
			'lat' => 'Lat',
			'long' => 'Long',
			'zoom' => 'Zoom',
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
		$criteria->compare('location',$this->location,true);
		$criteria->compare('location_image',$this->location_image,true);
		$criteria->compare('content_id',$this->content_id,true);
		$criteria->compare('is_published',$this->is_published);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('long',$this->long,true);
		$criteria->compare('zoom',$this->zoom,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getPhotoUrl($num)
    {
        if (isset($this->photos[$num])) {
            return $this->photos[$num]->url;
        }
        return '';
    }

    public function getImageUrl()
    {
        return '/upload/morning/location/'.$this->location_image;
    }

    public function getMapUrl()
    {
        return "http://maps.google.com/maps?q={$this->location}&hl=ru";
    }
}