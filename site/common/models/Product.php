<?php
Yii::import('site.frontend.extensions.geturl.EGetUrlBehavior');
Yii::import('site.frontend.extensions.status.EStatusBehavior');

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property string $product_id
 * @property string $product_articul
 * @property string $product_category_id
 * @property string $product_brand_id
 * @property string $product_sex
 * @property string $product_age_range_id
 * @property string $product_title
 * @property string $product_price
 * @property string $product_buy_price
 * @property string $product_sell_price
 * @property string $product_slug
 * @property string $product_text
 * @property string $product_image
 * @property string $product_keywords
 * @property string $product_description
 * @property string $product_time
 * @property integer $product_rate
 * @property integer $product_status
 * @property AgeRange $ageRange
 * @property array $cart_attributes
 * @property string $height
 * @property string $weight
 * @property integer $age_from
 * @property integer $age_to
 * *
 * @property Category $category
 * @property ProductBrand $brand
 * @property ProductItem $items
 */
class Product extends HActiveRecord implements IECartPosition
{
    const SCENARIO_SELECT_CATEGORY = 1;
    const SCENARIO_FILL_PRODUCT = 2;

    public $cart_attributes;

    public $accusativeName = 'Товар';

    public function getId()
    {
        return 'Product_' . $this->product_id;
    }

    public function getPrice()
    {
        return intval($this->product_sell_price)
            ? $this->product_sell_price
            : $this->product_price;
    }

    public function behaviors()
    {
        return array(
            'getUrl' => array(
                'class' => 'site.frontend.extensions.geturl.EGetUrlBehavior',
                'route' => 'product/view',
                'dataField' => array(
                    'id' => 'product_id',
                    'title' => 'product_slug',
                ),
            ),
            'statuses' => array(
                'class' => 'site.frontend.extensions.status.EStatusBehavior',
                // Поле зарезервированное для статуса
                'statusField' => 'product_status',
                'statuses' => array(
                    0 => 'deleted',
                    1 => 'published',
                    2 => 'view only',
                ),
            ),
            'ages' => array(
                'class' => 'site.frontend.extensions.status.EStatusBehavior',
                // Поле зарезервированное для статуса
                'statusField' => 'product_age_range_id',
                'statuses' => $this->getAgeRanges(),
            ),
            'sexs' => array(
                'class' => 'site.frontend.extensions.status.EStatusBehavior',
                // Поле зарезервированное для статуса
                'statusField' => 'product_sex',
                'statuses' => AgeRange::model()->getGenderList(),
            ),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Product the static model class
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
        return 'shop__product';
    }

    public function primaryKey()
    {
        return 'product_id';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_category_id', 'required', 'on' => self::SCENARIO_SELECT_CATEGORY),
            array('product_category_id', 'length', 'max' => 10, 'on' => self::SCENARIO_SELECT_CATEGORY),

            array('product_title, product_price, product_articul', 'required', 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_rate, product_status', 'numerical', 'integerOnly' => true, 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_price, product_buy_price, product_sell_price', 'numerical', 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_articul', 'length', 'max' => 32, 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_brand_id, product_age_range_id, product_time', 'length', 'max' => 10, 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_title, product_slug', 'length', 'max' => 150, 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_keywords, product_description', 'length', 'max' => 250, 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_age_range_id', 'in', 'range' => array_keys($this->getAgeRanges()), 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_sex', 'in', 'range' => array_keys(AgeRange::model()->getGenderList()), 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_text', 'safe', 'on' => self::SCENARIO_FILL_PRODUCT),

            array('product_image', 'safe',
                'on' => self::SCENARIO_FILL_PRODUCT
            ),

            array('product_slug', 'site.frontend.extensions.translit.ETranslitFilter', 'translitAttribute' => 'product_title', 'on' => self::SCENARIO_FILL_PRODUCT),

            array('product_time', 'default', 'value' => time(), 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_rate', 'default', 'value' => 0, 'on' => self::SCENARIO_FILL_PRODUCT),
            array('product_status', 'default', 'value' => 1, 'on' => self::SCENARIO_FILL_PRODUCT),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('product_id, product_category_id, product_age_range_id, product_sex, product_title, product_text, product_slug, product_image, product_keywords, product_description, product_time, product_rate, product_brand_id, product_price, product_buy_price, product_sell_price, product_status, product_articul', 'safe', 'on' => 'search'),
            array('cart_attributes', 'safe'),
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
            'images' => array(self::HAS_MANY, 'ProductImage', 'product_id', 'condition' => 'type = 0'),
            'main_image' => array(self::HAS_ONE, 'ProductImage', 'product_id', 'condition' =>'type = 1'),
            'comments' => array(self::HAS_MANY, 'ProductComment', 'product_id'),
            'videos' => array(self::HAS_MANY, 'ProductVideo', 'product_id'),
            'brand' => array(self::BELONGS_TO, 'ProductBrand', 'product_brand_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'product_category_id'),
            'ageRange' => array(self::BELONGS_TO, 'AgeRange', 'product_age_range_id'),
            'items' => array(self::HAS_MANY, 'ProductItem', 'product_id'),
            'presents' => array(self::HAS_MANY, 'ProductPresent', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'product_id' => 'Product',
            'product_articul' => 'Артикул',
            'product_category_id' => 'Категория',
            'product_brand_id' => 'Бренд',
            'product_age_range_id' => 'Возраст',
            'product_sex' => 'Пол',
            'product_type' => 'Тип',
            'product_title' => 'Наименование',
            'product_price' => 'Стоимость',
            'product_buy_price' => 'Покупная цена',
            'product_sell_price' => 'Акционная цена',
            'product_slug' => 'Slug',
            'product_text' => 'Описание',
            'product_image' => 'Изображение',
            'product_keywords' => 'Keywords',
            'product_description' => 'Descriptions',
            'product_time' => 'Дата',
            'product_rate' => 'Рейтинг',
            'product_status' => 'Статус',

            'imageCount' => 'Кол-во изображений',
            'subProductCount' => 'Кол-во подпробуктов',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($crit = null)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('product_articul', $this->product_articul, true);
        $criteria->compare('product_category_id', $this->product_category_id);
        $criteria->compare('product_brand_id', $this->product_brand_id);
        $criteria->compare('product_age_range_id', $this->product_age_range_id);
        $criteria->compare('product_sex', $this->product_sex);
        $criteria->compare('product_title', $this->product_title, true);
        $criteria->compare('product_price', $this->product_price, true);
        $criteria->compare('product_buy_price', $this->product_buy_price, true);
        $criteria->compare('product_sell_price', $this->product_sell_price, true);
        $criteria->compare('product_slug', $this->product_slug, true);
        $criteria->compare('product_text', $this->product_text, true);
        $criteria->compare('product_image', $this->product_image, true);
        $criteria->compare('product_keywords', $this->product_keywords, true);
        $criteria->compare('product_description', $this->product_description, true);
        $criteria->compare('product_time', $this->product_time, true);
        $criteria->compare('product_rate', $this->product_rate);
        $criteria->compare('product_status', $this->product_status);

        if ($crit)
            $criteria->mergeWith($crit);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getItemsCount()
    {
        $count = 0;
        foreach($this->items as $item)
            $count += $item->count;
        return $count;
    }

    public function getBrands()
    {
        static $brands;

        if (!$brands)
            $brands = Y::command()
                ->select('brand_id, brand_title')
                ->from(ProductBrand::model()->tableName())
                ->order('brand_title')
                ->queryAll(false);

        return CHtml::listData($brands, 0, 1);
    }

    public function getAgeRanges()
    {
        static $ranges;

        if (!$ranges)
            $ranges = Y::command()
                ->select('id, title')
                ->from(AgeRange::model()->tableName())
                ->order('position')
                ->queryAll(false);
        return CHtml::listData($ranges, 0, 1);
    }

    public function getImageCount()
    {
        return Y::command()
            ->select('COUNT(image_id)')
            ->from(ProductImage::model()->tableName())
            ->where('image_product_id=:image_product_id', array(
            ':image_product_id' => $this->product_id,
        ))
            ->queryScalar();
    }

    public function getPhotoCollection()
    {
        $photos = array();
        foreach($this->images as $image)
        {
            array_push($photos, $image->photo);
        }
        return $photos;
    }

    public function getSubProductCount()
    {
        return Y::command()
            ->select('COUNT(link_id)')
            ->from('shop__product_link')
            ->where('link_main_product_id=:link_main_product_id', array(
            ':link_main_product_id' => $this->product_id,
        ))
            ->queryScalar();
    }

    public function listsAll($term = '', $val = 'product_title', $search_fields = array('product_title', 'product_text'))
    {
        $row = Y::command()
            ->select($val)
            ->from($this->tableName())
            ->limit(30);

        $where = array();
        if ($term) {
            if (is_string($search_fields))
                $search_fields = explode(',', $search_fields);

            if (count($search_fields) == 1) {
                $where = array('like', reset($search_fields), "%$term%");
            }
            else
            {
                $where[] = 'or';
                foreach ($search_fields as $field)
                {
                    $where[] = array('like', $field, "%$term%");
                }
            }
            $row->where($where);
        }

        return $row
            ->queryAll();
    }

    public function listAll($val = 'product_title', $criteria = null)
    {
        $select = is_array($val)
            ? array_merge($val, array('product_id'))
            : array('product_id', $val);

        $list = Y::command()
            ->select($select)
            ->from($this->tableName());

        if ($criteria && $criteria instanceof CDbCriteria) {
            $array = $criteria->toArray();
            if ($array['condition'])
                $list = $list->where($array['condition'], $array['params']);
        }

        $list = $list->queryAll();

        return is_array($val) ? $list : CHtml::listData($list, 'product_id', $val);
    }

    public function getAttributesText()
    {
        $attrs = array();
        $attributeMap = $this->category->attributesMap;
        foreach ($attributeMap as $attribute)
        {
            if ($attribute->map_attribute->attribute_in_price != 1)
            {
                $attr = $attribute->map_attribute;
                $value = $this->GetAttributeValue($attr);
                $attrs[$attr->attribute_title] = $value;
            }
        }
        return $attrs;
        $eav = Y::command()
            ->select('attribute_id, attribute_title, eav_attribute_value, attribute_type')
            ->from('shop__product_eav')
            ->leftJoin('shop__product_attribute', 'eav_attribute_id=attribute_id')
            ->where('eav_product_id=:eav_product_id', array(
            ':eav_product_id' => $this->product_id,
        ))
            ->order('attribute_id')
            ->queryAll();

        Yii::import('attribute.models.Attribute');
        $value_ids = array();
        foreach ($eav as $val)
        {
            if ($val['attribute_type'] == Attribute::TYPE_ENUM) {
                $value_ids[] = $val['eav_attribute_value'];
            }
        }
        if ($value_ids) {
            $enum = Y::command()
                ->select('value_id, value_value')
                ->from('shop__product_attribute_value')
                ->where(array('in', 'value_id', $value_ids))
                ->queryAll();

            $enum = CHtml::listData($enum, 'value_id', 'value_value');
        }

        foreach ($eav as $key => $val)
        {
            switch ($val['attribute_type'])
            {
                case Attribute::TYPE_MEASURE:
                    break;
                case Attribute::TYPE_ENUM:
                    if (isset($enum[$val['eav_attribute_value']])) {
                        $eav[$key]['eav_attribute_value'] = $enum[$val['eav_attribute_value']];
                    }
                    else
                    {
                        unset($eav[$key]);
                    }
                    break;
                case Attribute::TYPE_BOOL:
                    $eav[$key]['eav_attribute_value'] = $val['eav_attribute_value'] ? 'Да' : 'Нет';
                    break;
                case Attribute::TYPE_INTG:
                case Attribute::TYPE_TEXT:
                default:
                    break;
            }
        }

        $eav_text = Y::command()
            ->select('attribute_id, attribute_title, shop__product_eav_text_values.value as eav_attribute_value')
            ->from('shop__product_eav_text')
            ->leftJoin('shop__product_attribute', 'eav_attribute_id=attribute_id')
            ->leftJoin('shop__product_eav_text_values', 'shop__product_eav_text_values.id=value_id')
            ->where('eav_product_id=:eav_product_id', array(
            ':eav_product_id' => $this->product_id,
        ))
            ->order('attribute_id')
            ->queryAll();

        return array_merge($eav, $eav_text);
    }

    protected function beforeDelete()
    {
        Y::command()
            ->update($this->tableName(), array(
            'product_status' => 0,
        ), 'product_id=:product_id', array(
            ':product_id' => $this->product_id,
        ));
        return true;
    }

    /**
     * @param CDbCriteria $mcriteria
     *
     * @return array
     */public function findPresents($mcriteria = false)
    {
        $criteria = new CDbCriteria;
        if($mcriteria)
            $criteria->mergeWith($mcriteria);
        //$criteria->addNotInCondition($this->getTableSchema()->primaryKey, array_keys(CHtml::listData($this->presents, 'present_id', 'present_id')));
        return $this->findAll($criteria);
    }

    /**
     * Add subproduct
     * @param int $productId
     * @param int $subProductId
     * @return void
     */
    public function addSubProduct($productId, $subProductId)
    {
        $command = Yii::app()->db->createCommand();
        $command->insert('shop__product_link', array(
            'link_main_product_id' => $productId,
            'link_sub_product_id' => $subProductId,
        ));
    }

    /**
     * Get subproduct
     * @param int $productId
     * @param int $subProductId
     * @return array
     */
    public function getSubproduct($productId, $subProductId)
    {
        $command = Yii::app()->db->createCommand();
        $command->select()
            ->from('shop__product_link')
            ->where('link_main_product_id = :link_main_product_id AND link_sub_product_id = :link_sub_product_id', array(
            'link_main_product_id' => (int)$_POST['main_product_id'],
            'link_sub_product_id' => (int)$_POST['product_id'],
        ))
            ->limit(1);
        return $command->queryScalar();
    }

    /**
     * Get subproducts
     * @param int $productId
     * @return array
     */
    public function getSubproducts($productId)
    {
        $command = Yii::app()->db->createCommand();
        $command->select()
            ->from('shop__product_link')
            ->where('link_main_product_id = :link_main_product_i', array(
            ':link_main_product_id' => $productId,
        ));
        return $command->queryAll();
    }


    /**
     * Retrieves subproducts of product $productId
     * @param int $productId
     * @return array
     */
    public function getSubProductsByProductId($productId)
    {
        $command = Yii::app()->db->createCommand();
        $command->select('link_sub_product_id')
            ->from('shop__product_link')
            ->where('link_main_product_id = :link_main_product_id');
        $command->params = array(
            ':link_main_product_id' => $productId
        );
        return $command->queryAll();
    }

    /**
     * @param Attribute $attr
     */
    public function GetAttributeValue($attr)
    {
        if ($attr->attribute_type == Attribute::TYPE_BOOL || $attr->attribute_type == Attribute::TYPE_ENUM ||
            $attr->attribute_type == Attribute::TYPE_INTG || $attr->attribute_type == Attribute::TYPE_MEASURE
        )
        {
            $eav = Y::command()
                ->select('eav_id, eav_attribute_value')
                ->from('shop__product_eav')
                ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
                ':eav_product_id' => $this->product_id,
                ':eav_attribute_id' => $attr->attribute_id,
            ))
                ->limit(1)
                ->queryRow();

            if ($attr->attribute_type == Attribute::TYPE_BOOL)
            {
                if ($eav['eav_attribute_value'] == 1)
                    return 'Да';
                elseif ($eav === false)
                    return false;
                else
                    return 'Нет';
            }
            elseif ($attr->attribute_type == Attribute::TYPE_ENUM)
            {
                if ($eav === false)
                    return false;

                $value = AttributeValue::model()->findByPk($eav['eav_attribute_value']);
                if ($value !== null)
                    return $value->value_value;
                else
                    return false;
            }
            elseif ($attr->attribute_type == Attribute::TYPE_MEASURE)
            {
                $value = $eav['eav_attribute_value'] . ' ' . $attr->measure_option->title;
                return $value;
            }

            return $eav['eav_attribute_value'];
        }
        if ($attr->attribute_type == Attribute::TYPE_TEXT)
        {
            $eav_text = Y::command()
                        ->select('shop__product_eav_text_values.value as eav_attribute_value')
                        ->from('shop__product_eav_text')
                        ->leftJoin("shop__product_eav_text_values", "shop__product_eav_text_values.id = shop__product_eav_text.value_id")
                        ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
                        ':eav_product_id' => $this->product_id,
                        ':eav_attribute_id' => $attr->primaryKey,
                    ))
                ->queryScalar();

            return $eav_text;
        }

        return null;
    }

    /**
     * @param $category_id
     * @param $brand_id
     * @return CActiveDataProvider
     */
    public function getAll($category_id, $brand_id) {
        $criteria = new CDbCriteria(array(
            'order' => 'product_id',
            'condition'=> 'product_status = 1'
        ));
        if (!empty($category_id))
        {
            $criteria->mergeWith(array(
                'condition' => 'product_category_id =  :product_category_id',
                'params' => array(
                    ':product_category_id' => $category_id,
                ),
            ));
        }
        if (!empty($brand_id))
        {
            $criteria->mergeWith(array(
                'condition' => 'product_brand_id =  :product_brand_id',
                'params' => array(
                    ':product_brand_id' => $brand_id,
                ),
            ));
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function GetAgeRangeText(){
//        if (!empty($this->ageRange))
//            return $this->ageRange->range_title;
//        else
//            return '';
        $text = '';
        if (!empty($this->age_from)){
            $text .= 'С ';
            if ($this->age_from >= 24){
                $text .= round($this->age_from/12).' лет';
            }else
                $text .= $this->age_from.' месяцев';

        }
        if (!empty($this->age_to)){
            $text .= ' до ';
            if ($this->age_to >= 24){
                $text .= round($this->age_to/12).' лет';
            }else
                $text .= $this->age_to.' месяцев';
        }

        return $text;
    }

    public function GetCardAttributeValues($attr_id){
        $eav_text = Y::command()
            ->select('eav_id, shop__product_eav_text_values.value as eav_attribute_value')
            ->from('shop__product_eav_text')
            ->leftJoin("shop__product_eav_text_values", "shop__product_eav_text_values.id = shop__product_eav_text.value_id")
            ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
            ':eav_product_id' => $this->product_id,
            ':eav_attribute_id' => $attr_id,
        ))
            ->queryAll();

        return $eav_text;
    }
}