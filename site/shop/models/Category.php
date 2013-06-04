<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property string $category_id
 * @property string $category_root
 * @property string $category_lft
 * @property string $category_rgt
 * @property integer $category_level
 * @property string $category_name
 * @property string $category_text
 * @property string $category_keywords
 * @property string $category_description
 *
 * @property Category $nextSibling
 * @property Category $prevSibling
 * @property AttributeSet[] attributeSets
 * @property Product[] products
 *
 * @method boolean moveAfter($category) moveAfter(Category $category)
 * @method boolean moveBefore($category) moveBefore(Category $category)
 */
class Category extends HActiveRecord
{
    public function getDescendatsIds()
    {
        $descendantsIds = array();
        $descendants = $this->descendants()->findAll();
        foreach ($descendants as $node) $descendantsIds[] = $node->primaryKey;
        return $descendantsIds;
    }

    public function getChildrenIds()
    {
        $childrenIds = array();
        $children = $this->children()->findAll();
        foreach ($children as $node) $childrenIds[] = $node->primaryKey;
        return $childrenIds;
    }

    public function getAncestorsIds()
    {
        $ancestorsIds = array();
        $ancestors = $this->ancestors()->findAll();
        foreach ($ancestors as $node) $ancestorsIds[] = $node->primaryKey;
        return $ancestorsIds;
    }

    public function getParentIds()
    {
        $parent = $this->parent;
        return ($parent === null) ? null : $parent->primaryKey;
    }

    public function getBrandsCount()
    {
        return Yii::app()->db->createCommand()
            ->select('count(DISTINCT `product_brand_id`)')
            ->from('shop__product')
            ->where('product_category_id = :category_id', array(':category_id' => $this->primaryKey))
            ->queryScalar();
    }

    public $accusativeName = 'категорию';

    public $parentId;
    public $defAttributes = array(
        'category_name', 'category_text', 'category_keywords', 'category_description',
    );

    public function behaviors()
    {
        return array(
            'tree' => array(
                'class' => 'site.frontend.extensions.trees.NestedSetBehavior',
                'hasManyRoots' => false,
                'leftAttribute' => 'category_lft',
                'rightAttribute' => 'category_rgt',
                'levelAttribute' => 'category_level',
            )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Category the static model class
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
        return 'shop__category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_name', 'required'),
            array('category_name', 'length', 'max' => 150),
            array('category_keywords, category_description', 'length', 'max' => 250),
            array('category_text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('category_id, category_name, category_text, category_keywords, category_description', 'safe', 'on' => 'search'),
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
            'attributeSets' => array(self::MANY_MANY, 'AttributeSet', 'shop__category_attribute_set_map(category_id, attribute_set_id)'),
            'products' => array(self::HAS_MANY, 'Product', 'product_category_id'),
            'productsCount' => array(self::STAT, 'Product', 'product_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'category_id' => 'Category',
            'category_root' => 'Category Root',
            'category_lft' => 'Category Lft',
            'category_rgt' => 'Category Rgt',
            'category_level' => 'Category Level',
            'category_name' => 'Имя',
            'category_text' => 'Описание',
            'category_keywords' => 'Keywords',
            'category_description' => 'Descriptions',
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

        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('category_root', $this->category_root, true);
        $criteria->compare('category_lft', $this->category_lft, true);
        $criteria->compare('category_rgt', $this->category_rgt, true);
        $criteria->compare('category_level', $this->category_level);
        $criteria->compare('category_name', $this->category_name, true);
        $criteria->compare('category_text', $this->category_text, true);
        $criteria->compare('category_keywords', $this->category_keywords, true);
        $criteria->compare('category_description', $this->category_description, true);

        $criteria->order = $this->tree->hasManyRoots ? $this->tree->rootAttribute . ', ' . $this->tree->leftAttribute : $this->tree->leftAttribute;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getNameExt()
    {
        return str_repeat('---', $this->category_level - 1) . ' ' . $this->category_name;
    }

    public function save($runValidation = true, $attributes = null)
    {
        $attributes = $attributes ? array_diff($attributes, $this->defAttributes) : $this->defAttributes;
        $this->tree->save($runValidation, $attributes);
    }

    public function listAll($forhtml = true, $category_id = null)
    {
        $category_level = 'category_level';
        if ($category_id) {
            $category = Y::command()
                ->select()
                ->from($this->tableName())
                ->where('category_id=:category_id', array(
                ':category_id' => $category_id,
            ))
                ->limit(1)
                ->queryRow();

            $category_level = "(category_level - {$category['category_level']}) AS category_level";
        }
        $list = Y::command()
            ->select(array_merge($this->defAttributes, array('category_id', $category_level)))
            ->from($this->tableName())
            ->order('category_root, category_lft');
        if ($category_id) {
            $list->where('category_lft>=:category_lft AND category_rgt<=:category_rgt', array(
                ':category_lft' => $category['category_lft'],
                ':category_rgt' => $category['category_rgt'],
            ));
        }
        $list = $list->queryAll();
        if (!$forhtml) {
            return $list;
        }
        $html = array();
        foreach ($list as $category) {
            $html[$category['category_id']] = str_repeat('---', $category['category_level'] - 1) . ' ' . $category['category_name'];
        }
        return $html;
    }

    /**
     * @return AttributeSetMap[]
     */
    public function GetAttributesMap(){
        $attrMap = array();
        foreach ($this->attributeSets as $attrSet) {
            $attrMap = array_merge($attrMap, $attrSet->set_map);
        }
        return $attrMap;
    }

    /**
     * @return AttributeSet|null
     */
    public function GetAttributeSet()
    {
        if (!empty($this->attributeSets))
            return $this->attributeSets[0];
        else
            return null;
    }

    /**
     * @return bool
     */
    public function HasAgeFilter(){
        if (!empty($this->attributeSets))
            return $this->GetAttributeSet()->age_filter;
        return null;
    }

    /**
     * @return bool
     */
    public function HasSexFilter(){
        if (!empty($this->attributeSets))
            return $this->GetAttributeSet()->sex_filter;
        return null;
    }
}