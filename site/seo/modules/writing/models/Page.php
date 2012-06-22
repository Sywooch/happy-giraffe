<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $url
 * @property string $keyword_group_id
 * @property int $number
 *
 * The followings are the available model relations:
 * @property KeywordGroup $keywordGroup
 * @property PagesSearchPhrase[] $phrases
 */
class Page extends CActiveRecord
{
    public $keywords;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Page the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    public function tableName()
    {
        return 'happy_giraffe_seo.pages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url', 'required'),
            array('keywords', 'required', 'on' => 'check'),
            array('keywords', 'safe', 'on' => 'check'),
            array('entity', 'length', 'max' => 255),
            array('url', 'unique'),
            array('url', 'url'),
            array('entity_id, keyword_group_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, entity, entity_id, keyword_group_id', 'safe', 'on' => 'search'),
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
            'keywordGroup' => array(self::BELONGS_TO, 'KeywordGroup', 'keyword_group_id'),
            'phrases' => array(self::HAS_MANY, 'PagesSearchPhrase', 'page_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'entity' => 'Entity',
            'entity_id' => 'Entity',
            'keyword_group_id' => 'Keyword Group',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('entity', $this->entity, true);
        $criteria->compare('entity_id', $this->entity_id, true);
        $criteria->compare('keyword_group_id', $this->keyword_group_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        $this->number = self::getDbConnection()->createCommand('select MAX(number) from ' . $this->tableName())->queryScalar() + 1;
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        $this->keywordGroup->delete();
        Yii::app()->db_seo->createCommand('update pages set number = number - 1 WHERE id >' . $this->id)->execute();
        return parent::beforeDelete();
    }

    public function getArticle()
    {
        $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($model === null)
            return null;
        return $model;
    }

    public function getKeywords()
    {
        $keys = array();
        foreach ($this->keywordGroup->keywords as $keyword) {
            $keys [] = $keyword->name;
        }

        return implode('<br>', $keys);
    }

    public function getArticleLink($icon = false)
    {
        if (!empty($this->entity)) {
            $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
            if ($model !== null)
            return CHtml::link($icon ? '' : $model->title, 'http://www.happy-giraffe.ru' . $model->getUrl(), array('target' => '_blank'));
        }
        return CHtml::link($this->url, $this->url, array('target' => '_blank'));
    }

    /**
     * Ищет статью по урлу, если не находит, то создает. Добавляет кейврд в группу
     * @param string $url
     * @param int $keyword_id
     * @return Page
     */
    public function getOrCreate($url, $keyword_id = null)
    {
        $model = Page::model()->findByAttributes(array('url' => $url));
        if ($model === null) {
            $keyword_group = new KeywordGroup();
            $keyword_group->keywords = array($keyword_id);
            $keyword_group->save();

            $model = new Page();
            $model->url = $url;

            preg_match("/\/([\d]+)\/$/", $url, $match);
            if (isset($match[1])) {
                $id = $match[1];

                $article = CommunityContent::model()->findByPk($id);
                if ($article !== null) {
                    $exist = Page::model()->findByAttributes(array(
                        'entity' => 'CommunityContent',
                        'entity_id' => $article->id,
                    ));
                    if ($exist !== null) {
                        $model = $exist;
                        //$exist->keywordGroup->addKeyword($keyword_id);
                    } else {
                        $model->entity = 'CommunityContent';
                        $model->entity_id = $article->id;
                        $model->keyword_group_id = $keyword_group->id;
                        $model->save();
                    }
                } else {
                    throw new CHttpException(401, 'Статья с другим урлом');
                }
            } else {
                $model->keyword_group_id = $keyword_group->id;
                $model->save();
            }
        } else {
            //$model->keywordGroup->addKeyword($keyword_id);
        }

        return $model;
    }
}