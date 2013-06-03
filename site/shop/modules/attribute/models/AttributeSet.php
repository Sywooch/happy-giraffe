<?php

/**
 * This is the model class for table "shop__product_attribute_set".
 *
 * The followings are the available columns in table 'shop__product_attribute_set':
 * @property string $set_id
 * @property string $set_title
 * @property string $set_text
 * @property integer $age_filter
 * @property integer $sex_filter
 * @property integer $brand_pos
 *
 * The followings are the available model relations:
 * @property Category[] $categories
 * @property AttributeSetMap[] $set_map
 * @property ProductType[] $types
 */
class AttributeSet extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return AttributeSet the static model class
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
        return 'shop__product_attribute_set';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('set_title', 'required'),
            array('age_filter, sex_filter, brand_pos', 'numerical', 'integerOnly' => true),
            array('set_title', 'length', 'max' => 50),
            array('brand_pos', 'default', 'value' => 0),
            array('set_text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('set_id, set_title, set_text, age_filter, sex_filter', 'safe', 'on' => 'search'),
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
            'categories' => array(self::MANY_MANY, 'Category', 'shop__category_attribute_set_map(attribute_set_id, category_id)'),
            'types' => array(self::HAS_MANY, 'ProductType', 'type_attribute_set_id'),
            'set_map' => array(self::HAS_MANY, 'AttributeSetMap', 'map_set_id', 'order'=>'pos asc'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'set_id' => 'Set',
            'set_title' => 'Set Title',
            'set_text' => 'Set Text',
            'age_filter' => 'Age Filter',
            'sex_filter' => 'Sex Filter',
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

        $criteria->compare('set_id', $this->set_id, true);
        $criteria->compare('set_title', $this->set_title, true);
        $criteria->compare('set_text', $this->set_text, true);
        $criteria->compare('age_filter', $this->age_filter);
        $criteria->compare('sex_filter', $this->sex_filter);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeDelete()
    {
        $pasm = new AttributeSetMap;

        Yii::app()->db->createCommand()
            ->delete($pasm->tableName(), 'map_set_id=:map_set_id', array(
            ':map_set_id' => $this->set_id,
        ));

        return parent::beforeDelete();
    }

    public function listAll($term = '', $val = 'set_title')
    {
        if (!is_array($val)) {
            $val = explode(',', $val);

            foreach ($val as $k => $v)
            {
                if (($v = trim($v)))
                    $val[$k] = $v;
                else
                    unset($val[$k]);
            }
        }

        if (!$val)
            return array();

        $command = Y::command()
            ->select(array_merge($val, array('set_id')))
            ->from('shop__product_attribute_set');

        if ($term && is_string($term)) {
            $command->where(array('like', 'set_title', "%$term%"));
        }

        return $command->queryAll();
    }

    public function behaviors()
    {
        return array(
            'ManyToManyBehavior'
        );
    }
}