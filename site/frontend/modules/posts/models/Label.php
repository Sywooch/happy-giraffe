<?php

namespace site\frontend\modules\posts\models;

/**
 * This is the model class for table "post__labels".
 *
 * The followings are the available columns in table 'post__labels':
 * @property string $id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property PostContents[] $postContents
 */
class Label extends \CActiveRecord
{

    // запомним соответствие тег-id
    protected static $_tags = null;

    protected static function _getTags()
    {
        if (is_null(self::$_tags)) {
            self::$_tags = \Yii::app()->apc->get('labels-cache', self::$_tags) ? : array();
        }
        return self::$_tags;
    }

    protected static function _addTags($tags)
    {
        self::$_tags = \CMap::mergeArray(self::$_tags, $tags);
        \Yii::app()->apc->set('labels-cache', self::$_tags);
    }

    protected static function _addTag($id, $text)
    {
        self::$_tags[$text] = $id;
        \Yii::app()->apc->set('labels-cache', self::$_tags);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post__labels';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('text', 'required'),
            array('text', 'length', 'max' => 300),
            array('id, text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'postContents' => array(self::MANY_MANY, '\site\frontend\modules\posts\models\PostContents', 'post__tags(labelId, contentId)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'text' => 'Text',
        );
    }

    public static function getIdByLabel($label, $autoCreate = false)
    {
        // поищем теги в кеше
        $cacheTags = self::_getTags();
        if (isset($cacheTags[$label])) {
            return $cacheTags[$label];
        }

        // пошаримся в базе
        $model = self::model()->findByAttributes(array('text' => $label));
        if (!$model && $autoCreate) {
            // Добавим новую запись
            $model = new Label();
            $model->text = $label;
            $model->save();
        }
        // запишем в кеш
        self::_addTag($model->id, $model->text);
        return $model ? $model->id : null;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Получение списка идентификаторов, по списку "ярлыков"
     * 
     * @param type $labels
     */
    public static function getIdsByLabels($labels)
    {
        $tagIds = array();

        // поищем теги в кеше
        $cacheTags = self::_getTags();
        foreach ($labels as $k => $label) {
            if (isset($cacheTags[$label])) {
                $tagIds[] = $cacheTags[$label];
                unset($labels[$k]);
            }
        }

        if (!empty($labels)) {
            // Спросим id в базе
            $labelModels = \site\frontend\modules\posts\models\Label::model()->byTags($labels)->findAll();
            foreach ($labelModels as $label) {
                // Запомним и добавим к списку
                $cacheTags[$label['text']] = $label->id;
                $tagIds[] = $label->id;
            }
            self::_addTags($cacheTags);
        }

        return $tagIds;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PostLabels the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function byTags($tags)
    {
        $criteria = $this->getDbCriteria();
        $criteria->compare('text', $tags);

        return $this;
    }

}
