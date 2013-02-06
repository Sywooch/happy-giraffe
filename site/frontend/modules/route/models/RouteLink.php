<?php

/**
 * This is the model class for table "routes__links".
 *
 * The followings are the available columns in table 'routes__links':
 * @property string $route_from_id
 * @property string $route_to_id
 * @property string $keyword
 *
 * The followings are the available model relations:
 * @property Route $routeFrom
 * @property Route $routeTo
 */
class RouteLink extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RouteLink the static model class
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
        return 'routes__links';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('route_from_id, route_to_id, keyword', 'required'),
            array('route_from_id, route_to_id', 'length', 'max' => 11),
            array('keyword', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('route_from_id, route_to_id, keyword', 'safe', 'on' => 'search'),
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
            'routeTo' => array(self::BELONGS_TO, 'Route', 'route_to_id'),
            'routeFrom' => array(self::BELONGS_TO, 'Route', 'route_from_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'route_from_id' => 'Route1',
            'route_to_id' => 'Route2',
            'keyword' => 'keyword',
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

        $criteria = new CDbCriteria;

        $criteria->compare('route_from_id', $this->route_from_id, true);
        $criteria->compare('route_to_id', $this->route_to_id, true);
        $criteria->compare('keyword', $this->keyword, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function test($id)
    {
        $route = Route::model()->findByPk($id);

        $key = new RouteKeyword;
        $key->route_id = $route->id;
        $key->text = 'расстояние ' . $route->cityFrom->name . ' ' . $route->cityTo->name;
        $key->wordstat = rand(10, 300);
        $key->save();
    }
}