<?php

/**
 * This is the model class for table "community__photos".
 *
 * The followings are the available columns in table 'community__photos':
 * @property string $id
 * @property string $image
 * @property string $text
 * @property string $post_id
 *
 * The followings are the available model relations:
 * @property CommunityMorningPost $post
 */
class CommunityPhoto extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommunityPhoto the static model class
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
		return 'community__photos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image, post_id', 'required'),
			array('image', 'length', 'max'=>255),
			array('post_id', 'length', 'max'=>11),
			array('text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, image, text, post_id', 'safe', 'on'=>'search'),
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
			'post' => array(self::BELONGS_TO, 'CommunityMorningPost', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image' => 'Image',
			'text' => 'Text',
			'post_id' => 'Post',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('post_id',$this->post_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterDelete()
    {
        $file = Yii::getPathOfAlias('site.common.uploads.photos.morning.originals') .
            DIRECTORY_SEPARATOR . $this->post_id . DIRECTORY_SEPARATOR . $this->image;
        if (file_exists($file))
            unlink($file);
    }

    public function getUrl()
    {
        return implode('/', array(
            Yii::app()->params['photos_url'],
            'morning',
            'originals',
            $this->post->id,
            $this->image,
        ));
    }
}