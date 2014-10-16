<?php

namespace site\frontend\modules\posts\models;

/**
 * This is the model class for table "post__contents".
 *
 * The followings are the available columns in table 'post__contents':
 * @property string $id
 * @property string $url
 * @property string $authorId
 * @property string $title
 * @property string $text
 * @property string $html
 * @property string $preview
 * @property string $labels
 * @property string $dtimeCreate
 * @property string $dtimeUpdate
 * @property string $dtimePublication
 * @property string $originService
 * @property string $originEntity
 * @property string $originEntityId
 * @property string $originManageInfo
 * @property integer $isDraft
 * @property integer $uniqueIndex
 * @property integer $isNoindex
 * @property integer $isNofollow
 * @property integer $isAutoMeta
 * @property integer $isAutoSocial
 * @property integer $isRemoved
 * @property string $meta
 * @property string $social
 * @property string $template
 *
 * The followings are the available model relations:
 * @property PostLabels[] $postLabels
 */
class Content extends \CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post__contents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('authorId, title, html, labels, dtimeCreate, originService, originEntity, originEntityId, originManageInfo', 'required'),
            array('isDraft, uniqueIndex, isNoindex, isNofollow, isAutoMeta, isAutoSocial, isRemoved', 'numerical', 'integerOnly' => true),
            array('url, title', 'length', 'max' => 255),
            array('authorId, dtimeCreate, dtimeUpdate, dtimePublication', 'length', 'max' => 10),
            array('originService, originEntity, originEntityId', 'length', 'max' => 100),
            array('text, preview, meta, social, template', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, url, authorId, title, text, html, preview, labels, dtimeCreate, dtimeUpdate, dtimePublication, originService, originEntity, originEntityId, originManageInfo, isDraft, uniqueIndex, isNoindex, isNofollow, isAutoMeta, isAutoSocial, isRemoved, meta, social, template', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'labelModels' => array(self::MANY_MANY, '\site\frontend\modules\posts\models\Label', 'post__tags(contentId, labelId)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'url' => 'Url',
            'authorId' => 'Author',
            'title' => 'Title',
            'text' => 'Text',
            'html' => 'Html',
            'preview' => 'Preview',
            'labels' => 'Labels',
            'dtimeCreate' => 'Dtime Create',
            'dtimeUpdate' => 'Dtime Update',
            'dtimePublication' => 'Dtime Publication',
            'originService' => 'Origin Service',
            'originEntity' => 'Origin Entity',
            'originEntityId' => 'Origin Entity',
            'originManageInfo' => 'Origin Manage Info',
            'isDraft' => 'Is Draft',
            'uniqueIndex' => 'Unique Index',
            'isNoindex' => 'Is Noindex',
            'isNofollow' => 'Is Nofollow',
            'isAutoMeta' => 'Is Auto Meta',
            'isAutoSocial' => 'Is Auto Social',
            'isRemoved' => 'Is Removed',
            'meta' => 'Meta',
            'social' => 'Social',
            'template' => 'Template',
        );
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
        $criteria->compare('url', $this->url, true);
        $criteria->compare('authorId', $this->authorId, true);
        /** @todo Переписать условие для тегов */
        $criteria->compare('labels', $this->labels, true);

        $criteria->compare('originService', $this->originService, true);
        $criteria->compare('originEntity', $this->originEntity, true);
        $criteria->compare('originEntityId', $this->originEntityId, true);

        $criteria->compare('isDraft', $this->isDraft);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function defaultScope()
    {
        return array(
            'condition'=> $this->getTableAlias(true, false) . '`isRemoved`=0',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Content the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
