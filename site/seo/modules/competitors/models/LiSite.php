<?php

/**
 * This is the model class for table "li_sites".
 *
 * The followings are the available columns in table 'li_sites':
 * @property string $id
 * @property string $url
 * @property string $site_url
 * @property integer $visits
 * @property string $password
 * @property integer $public
 * @property integer $active
 */
class LiSite extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LiSite the static model class
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
		return 'li_sites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('url, site_url', 'required'),
			array('visits, public, active', 'numerical', 'integerOnly'=>true),
			array('url, site_url, password', 'length', 'max'=>100),

		);
	}
}