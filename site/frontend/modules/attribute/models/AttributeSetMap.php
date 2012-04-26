<?php

/**
 * This is the model class for table "{{product_attribute_set_map}}".
 *
 * The followings are the available columns in table '{{product_attribute_set_map}}':
 * @property string $map_id
 * @property string $map_set_id
 * @property string $map_attribute_id
 * @property string $map_attribute_title
 * @property integer $pos
 *
 * @property AttributeSet $map_set
 * @property Attribute $map_attribute
 */
class AttributeSetMap extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return AttributeSetMap the static model class
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
        return 'shop__product_attribute_set_map';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('map_set_id, map_attribute_id', 'required'),
            array('map_set_id, map_attribute_id', 'length', 'max' => 10),
            array('map_attribute_title', 'length', 'max' => 2),
            array('pos', 'numerical', 'integerOnly' => true),
            array('pos', 'default', 'value' => 0),

            array('map_attribute_id', 'aunique'),
//			array('map_attribute_title','tunique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('map_id, map_set_id, map_attribute_id, map_attribute_title, pos', 'safe', 'on' => 'search'),
        );
    }

    public function aunique($attribute, $attributes)
    {
        $where = array('and', 'map_set_id=:map_set_id', 'map_attribute_id=:map_attribute_id');
        $params = array(
            ':map_set_id' => $this->map_set_id,
            ':map_attribute_id' => $this->map_attribute_id,
        );
        if (!$this->getIsNewRecord()) {
            $where[] = 'map_id<>:map_id';
            $params[':map_id'] = $this->map_id;
        }

        if (Y::command()->select('map_id')->from($this->tableName())->where($where, $params)->queryScalar())
            $this->addError($attribute, 'In this set alrady exist such attribute');
    }

    public function tunique($attribute, $attributes)
    {
        $where = array('and', 'map_set_id=:map_set_id', 'map_attribute_title=:map_attribute_title');
        $params = array(
            ':map_set_id' => $this->map_set_id,
            ':map_attribute_title' => $this->map_attribute_title,
        );
        if (!$this->getIsNewRecord()) {
            $where[] = 'map_id<>:map_id';
            $params[':map_id'] = $this->map_id;
        }

        if (Y::command()->select('map_id')->from($this->tableName())->where($where, $params)->queryScalar())
            $this->addError($attribute, 'In this set alrady exist such title');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'map_attribute' => array(self::BELONGS_TO, 'Attribute', 'map_attribute_id'),
            'map_set' => array(self::BELONGS_TO, 'AttributeSet', 'map_set_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'map_id' => 'Map',
            'map_set_id' => 'Map Set',
            'map_attribute_id' => 'Map Attribute',
            'map_attribute_title' => 'Map Attribute Title',
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

        $criteria->compare('map_id', $this->map_id, true);
        $criteria->compare('map_set_id', $this->map_set_id, true);
        $criteria->compare('map_attribute_id', $this->map_attribute_id, true);
        $criteria->compare('map_attribute_title', $this->map_attribute_title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function MoveAfter($after_id)
    {
        if (empty($after_id)) {
            Yii::app()->db->createCommand('Update ' . $this->tableName()
                . ' SET pos = pos+1 WHERE map_set_id=' . $this->map_set_id)->execute();

            $this->map_set->brand_pos++;
            $this->map_set->update(array('brand_pos'));
            $this->pos = 0;
        } else {
            if ($after_id == 'brand') {
                $new_pos = $this->map_set->brand_pos;

            } else {
                $after = AttributeSetMap::model()->findByAttributes(array('map_attribute_id' => $after_id));
                $new_pos = $after->pos;
            }
            Yii::app()->db->createCommand('Update ' . $this->tableName()
                . ' SET pos = pos+1 WHERE pos > ' . $new_pos . ' AND map_set_id=' . $this->map_set_id)->execute();

            if ($this->map_set->brand_pos > $new_pos) {
                $this->map_set->brand_pos++;
                $this->map_set->update(array('brand_pos'));
            }

            $this->pos = $new_pos + 1;
        }

        return $this->update(array('pos'));
    }

    public function MaxPosition()
    {
        return Yii::app()->db->createCommand('Select MAX(pos) FROM ' . AttributeSetMap::model()->tableName())->queryScalar() + 1;
    }
}