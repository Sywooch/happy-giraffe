<?php

/**
 * This is the model class for table "routes__links".
 *
 * The followings are the available columns in table 'routes__links':
 * @property string $route_from_id
 * @property string $route_to_id
 * @property string $anchor
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
            array('route_from_id, route_to_id, anchor', 'required'),
            array('route_from_id, route_to_id', 'length', 'max' => 11),
            array('anchor', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('route_from_id, route_to_id, anchor', 'safe', 'on' => 'search'),
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
            'anchor' => 'anchor',
        );
    }

    public function afterSave()
    {
        if ($this->isNewRecord){
            $this->routeFrom->out_links_count++;
            $this->routeFrom->update(array('out_links_count'));
        }

        parent::afterSave();
    }

    public function afterDelete()
    {
        if ($this->isNewRecord){
            $this->routeFrom->out_links_count--;
            $this->routeFrom->update(array('out_links_count'));
        }
    }

    public function getText(){
        $links = $this->getLinks();
        $text = $links[$this->anchor];

        return $this->replacePatterns($text);
    }

    public function replacePatterns($text)
    {
        //{city_from2} и {city_to2}
        $text = str_replace('{city_from}', $this->routeTo->cityFrom->name, $text);
        $text = str_replace('{city_from1}', $this->routeTo->cityFrom->name_from, $text);
        $text = str_replace('{city_from2}', $this->routeTo->cityFrom->name_between, $text);

        $text = str_replace('{city_to}', $this->routeTo->cityTo->name, $text);
        $text = str_replace('{city_to1}', $this->routeTo->cityTo->name_from, $text);
        $text = str_replace('{city_to2}', $this->routeTo->cityTo->name_between, $text);

        return $text;
    }

    public function getLinks()
    {
        if ($this->routeTo->wordstat_value > CRouteLinking::WORDSTAT_LEVEL_2)
            return CRouteLinking::model()->links3;
        if ($this->routeTo->wordstat_value > CRouteLinking::WORDSTAT_LEVEL_1)
            return CRouteLinking::model()->$this->links2;

        return CRouteLinking::model()->$this->links1;
    }
}