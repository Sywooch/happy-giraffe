<?php

/**
 * This is the model class for table "externallinks__links".
 *
 * The followings are the available columns in table 'externallinks__links':
 * @property string $id
 * @property string $site_id
 * @property string $url
 * @property string $our_link
 * @property string $author_id
 * @property string $created
 * @property integer $link_type
 * @property double $link_cost
 * @property integer $system_id
 *
 * The followings are the available model relations:
 * @property Keyword[] $keywords
 * @property ELSystem $system
 * @property SeoUser $author
 * @property ELSite $site
 */
class ELLink extends HActiveRecord
{
    const TYPE_LINK = 1;
    const TYPE_COMMENT = 2;
    const TYPE_POST = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ELLink the static model class
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
		return 'externallinks__links';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, url, our_link, author_id, created, link_type', 'required'),
			array('link_type, system_id', 'numerical', 'integerOnly'=>true),
			array('link_cost', 'numerical'),
			array('site_id, author_id', 'length', 'max'=>11),
			array('url', 'length', 'max'=>2048),
			array('our_link', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_id, url, our_link, author_id, created, link_type, link_cost, system_id', 'safe', 'on'=>'search'),
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
			'keywords' => array(self::MANY_MANY, 'Keywords', 'externallinks__anchors(link_id, keyword_id)'),
			'system' => array(self::BELONGS_TO, 'ELSystem', 'system_id'),
			'author' => array(self::BELONGS_TO, 'SeoUser', 'author_id'),
			'site' => array(self::BELONGS_TO, 'ELSite', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_id' => 'Site',
			'url' => 'Url',
			'our_link' => 'Our Link',
			'author_id' => 'Author',
			'created' => 'Created',
			'link_type' => 'Link Type',
			'link_cost' => 'Link Cost',
			'system_id' => 'System',
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
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('our_link',$this->our_link,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('link_type',$this->link_type);
		$criteria->compare('link_cost',$this->link_cost);
		$criteria->compare('system_id',$this->system_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function checkCount()
    {
        return 0;
    }
}