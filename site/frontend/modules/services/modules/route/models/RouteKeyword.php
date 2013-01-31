<?php

/**
 * This is the model class for table "routes__keywords".
 *
 * The followings are the available columns in table 'routes__keywords':
 * @property string $id
 * @property string $route_id
 * @property string $text
 * @property integer $wordstat
 * @property integer $used
 *
 * The followings are the available model relations:
 * @property Route $route
 */
class RouteKeyword extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RouteKeyword the static model class
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
		return 'routes__keywords';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('route_id, text', 'required'),
			array('wordstat, used', 'numerical', 'integerOnly'=>true),
			array('route_id', 'length', 'max'=>10),
			array('text', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, route_id, text, wordstat, used', 'safe', 'on'=>'search'),
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
			'route' => array(self::BELONGS_TO, 'Route', 'route_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'route_id' => 'Route',
			'text' => 'Text',
			'wordstat' => 'Wordstat',
			'used' => 'Used',
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
		$criteria->compare('route_id',$this->route_id,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('wordstat',$this->wordstat);
		$criteria->compare('used',$this->used);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function test()
    {
        $routes = Route::model()->findAll();
        foreach ($routes as $route) {
            $key = new RouteKeyword;
            $key->route_id = $route->id;
            $key->text = 'маршрут '.$route->cityFrom->name . ' ' . $route->cityTo->name;
            $key->wordstat = rand(10, 300);
            $key->save();
        }
    }
}