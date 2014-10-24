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
 * @property array $labelsArray
 * @property string $dtimeCreate
 * @property string $dtimeUpdate
 * @property string $dtimePublication
 * @property string $originService
 * @property string $originEntity
 * @property string $originEntityId
 * @property string $originManageInfo
 * @property string $originManageInfoObject
 * @property integer $isDraft
 * @property integer $uniqueIndex
 * @property integer $isNoindex
 * @property integer $isNofollow
 * @property integer $isAutoMeta
 * @property integer $isAutoSocial
 * @property integer $isRemoved
 * @property string $meta
 * @property \site\frontentd\modules\posts\models\MetaInfo $metaObject
 * @property string $social
 * @property string $socialObject
 * @property string $template
 * @property string $templateObject
 *
 * The followings are the available model relations:
 * @property PostLabels[] $labelModels
 */
class Content extends \CActiveRecord implements \IHToJSON, \IPreview
{

    protected $labelDelimiter = '|';
    protected $_relatedModels = array();

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
            array('text', 'filter', 'filter' => array($this, 'fillText'), 'on' => 'oldPost'),
            array('meta', 'filter', 'filter' => array($this->metaObject, 'serialize')),
            array('social', 'filter', 'filter' => array($this->socialObject, 'serialize')),
            array('template', 'filter', 'filter' => array($this->templateObject, 'serialize')),
            array('originManageInfo', 'filter', 'filter' => array($this->originManageInfoObject, 'serialize')),
            array('authorId, title, html, labels, dtimeCreate, originService, originEntity, originEntityId, originManageInfo', 'required'),
            array('isDraft, isNoindex, isNofollow, isAutoMeta, isAutoSocial, isRemoved', 'boolean'),
            array('uniqueIndex', 'numerical', 'integerOnly' => true),
            array('url, title', 'length', 'max' => 255),
            array('authorId, dtimeCreate, dtimeUpdate, dtimePublication', 'length', 'max' => 10),
            array('originService, originEntity, originEntityId', 'length', 'max' => 100),
            array('text, preview, meta, social, template', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, url, authorId, title, text, html, preview, labels, dtimeCreate, dtimeUpdate, dtimePublication, originService, originEntity, originEntityId, originManageInfo, isDraft, uniqueIndex, isNoindex, isNofollow, isAutoMeta, isAutoSocial, isRemoved, meta, social, template', 'safe', 'on' => 'search'),
        );
    }

    public function fillText()
    {
        return trim(preg_replace('~\s+~', ' ', strip_tags($this->html)));
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

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => 'dtimeUpdate',
                'publicationAttribute' => 'dtimePublication',
                'owerwriteAttributeIfSet' => false,
            ),
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

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'url' => (string) $this->url,
            'authorId' => (int) $this->authorId,
            'title' => (string) $this->title,
            'text' => (string) $this->text,
            'html' => (string) $this->html,
            'preview' => (string) $this->preview,
            'labels' => $this->labelsArray,
            'dtimeCreate' => (int) $this->dtimeCreate,
            'dtimeUpdate' => (int) $this->dtimeUpdate,
            'dtimePublication' => is_null($this->dtimePublication) ? null : (int) $this->dtimePublication,
            'originService' => (string) $this->originService,
            'originEntity' => (string) $this->originEntity,
            'originEntityId' => (string) $this->originEntityId,
            'originManageInfo' => $this->originManageInfoObject->toJSON(),
            'isDraft' => (bool) $this->isDraft,
            'uniqueIndex' => is_null($this->uniqueIndex) ? null : (int) $this->uniqueIndex,
            'isNoindex' => (bool) $this->isNoindex,
            'isNofollow' => (bool) $this->isNofollow,
            'isAutoMeta' => (bool) $this->isAutoMeta,
            'isAutoSocial' => (bool) $this->isAutoSocial,
            'isRemoved' => (bool) $this->isRemoved,
            'meta' => $this->metaObject->toJSON(),
            'social' => $this->socialObject->toJSON(),
            'template' => $this->templateObject->toJSON(),
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
            'condition' => $this->getTableAlias(true, false) . '.`isRemoved`=0',
        );
    }

    public function afterSave()
    {
        /** @todo убрать в поведение */
        $labels = $this->labelsArray;
        $oldLabels = $this->labelModels;
        foreach ($oldLabels as $oldLabel)
        {
            $i = array_search($oldLabel->text, $labels);
            if ($i === false)
            {
                // старого тега больше нет
                PostTags::model()->deleteByPk(array('labelId' => $oldLabel->id, 'contentId' => $this->id));
            }
            else
            {
                // тег уже есть
                unset($labels[$i]);
            }
        }
        $ids = array();
        foreach ($labels as $label)
        {
            $model = Label::model()->findByAttributes(array('text' => $label));
            if (!$model)
            {
                $model = new Label();
                $model->text = $label;
                $model->save();
            }
            if ($model->id && !isset($ids[$model->id]))
            {
                $tag = new PostTags();
                $tag->attributes = array('labelId' => $model->id, 'contentId' => $this->id);
                $tag->save();
            }
            $ids[$model->id] = 1;
        }

        return parent::afterSave();
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

    public function getPreviewPhoto()
    {
        /** @todo Реализовать */
    }

    public function getPreviewText()
    {
        /** @todo Реализовать */
    }

    public function getLabelsArray()
    {
        return explode($this->labelDelimiter, $this->labels);
    }

    public function setLabelsArray($array)
    {
        $this->labels = implode($this->labelDelimiter, $array);
    }

    public function getOriginManageInfoObject()
    {
        if (!isset($this->_relatedModels['originalManageInfo']))
            $this->_relatedModels['originalManageInfo'] = new ManageInfo($this->originManageInfo);

        return $this->_relatedModels['originalManageInfo'];
    }

    public function getMetaObject()
    {
        if (!isset($this->_relatedModels['metaObject']))
            $this->_relatedModels['metaObject'] = new MetaInfo($this->originManageInfo);

        return $this->_relatedModels['metaObject'];
    }

    public function getSocialObject()
    {
        if (!isset($this->_relatedModels['socialObject']))
            $this->_relatedModels['socialObject'] = new SocialInfo($this->originManageInfo);

        return $this->_relatedModels['socialObject'];
    }

    public function getTemplateObject()
    {
        if (!isset($this->_relatedModels['templateObject']))
            $this->_relatedModels['templateObject'] = new TemplateInfo($this->originManageInfo);

        return $this->_relatedModels['templateObject'];
    }

    /* scopes */

    public function byEntity($entity, $entityId)
    {
        $this->dbCriteria->addColumnCondition(array(
            'originEntity' => $entity,
            'originEntityId' => $entityId,
        ));

        return $this;
    }

}
