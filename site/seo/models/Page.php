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
 * @property int $yandex_pos
 * @property int $google_pos
 * @property int $yandex_week_visits
 * @property int $yandex_month_visits
 * @property int $google_week_visits
 * @property int $google_month_visits
 *
 * The followings are the available model relations:
 * @property KeywordGroup $keywordGroup
 * @property PagesSearchPhrase[] $phrases
 * @property InnerLink[] $outputLinks
 * @property InnerLink[] $inputLinks
 * @property int $outputLinksCount
 * @property int $inputLinksCount
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
            'outputLinks' => array(self::HAS_MANY, 'InnerLink', 'page_id', 'order' => 'date desc'),
            'inputLinks' => array(self::HAS_MANY, 'InnerLink', 'page_to_id', 'order' => 'date desc'),
            'outputLinksCount' => array(self::STAT, 'InnerLink', 'page_id'),
            'inputLinksCount' => array(self::STAT, 'InnerLink', 'page_to_id'),
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

    /**
     * @return CommunityContent
     */
    public function getArticle()
    {
        if (empty($this->entity) || empty($this->entity_id))
            return null;

        $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($model === null)
            return null;
        return $model;
    }

    public function getArticleTitle()
    {
        $model = $this->getArticle();
        if ($model === null)
            return $this->url;
        return $model->title;
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
            if (!empty($keyword_id))
                $keyword_group->keywords = array($keyword_id);
            $keyword_group->save();

            $model = new Page();
            $model->url = $url;

            preg_match("/http:\/\/www.happy-giraffe.ru\/community\/[\d]+\/forum\/(post|video)\/([\d]+)\/$/", $url, $match);
            if (isset($match[2])) {
                $entity_id = $match[2];
                $entity = 'CommunityContent';
            } else {
                preg_match("/http:\/\/www.happy-giraffe.ru\/user\/[\d]+\/blog\/post([\d]+)\/$/", $url, $match);
                if (isset($match[1])) {
                    $entity_id = $match[1];
                    $entity = 'BlogContent';
                } else {
                    preg_match("/http:\/\/www.happy-giraffe.ru\/cook\/multivarka\/([\d]+)\/$/", $url, $match);
                    if (isset($match[1])) {
                        $entity_id = $match[1];
                        $entity = 'MultivarkaRecipe';
                    } else {
                        preg_match("/http:\/\/www.happy-giraffe.ru\/cook\/recipe\/([\d]+)\/$/", $url, $match);
                        if (isset($match[1])) {
                            $entity_id = $match[1];
                            $entity = 'CookRecipe';
                        }
                    }
                }
            }

            if (isset($entity) && isset($entity_id)) {
                $article = CActiveRecord::model($entity)->findByPk($entity_id);
                if ($article !== null) {
                    $exist = Page::model()->findByAttributes(array(
                        'entity' => $entity,
                        'entity_id' => $entity_id,
                    ));
                    if ($exist !== null) {
                        $model = $exist;
                        //$exist->keywordGroup->addKeyword($keyword_id);
                    } else {
                        $model->entity = $entity;
                        $model->entity_id = $entity_id;
                        $model->keyword_group_id = $keyword_group->id;
                        $model->save();
                    }
                } else {
                    return null;
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

    /**
     * @param $period
     * @return PagesSearchPhrase[]
     */
    public function goodPhrases($period = 2)
    {
        $result = array();
        foreach ($this->phrases as $phrase) {
            $visits1 = $phrase->getVisits(2, $period);
            $visits2 = $phrase->getVisits(3, $period);
            if ($visits1 + $visits2 > 0)
                $result [] = $phrase;
        }

        if (empty($result))
            foreach ($this->phrases as $phrase)
                return array($phrase);

        return $result;
    }

    public function getRubricUrl()
    {
        $model = $this->getArticle();
        if ($model === null)
            return 'http://www.happy-giraffe.ru/community/';

        if ($model->getIsFromBlog()) {
            return 'http://www.happy-giraffe.ru/user/';
        } else
            return 'http://www.happy-giraffe.ru/community/' . $model->rubric->community_id . '/forum/rubric/' . $model->rubric_id . '/';
    }

    public function getVisits($se, $period)
    {
        if ($se == 2) {
            if ($period == 1)
                return $this->yandex_week_visits;
            return $this->yandex_month_visits;
        } elseif ($se == 3) {
            if ($period == 1)
                return $this->google_week_visits;
            return $this->google_month_visits;
        }

        return 0;
    }

    public static function ParseUrl($url)
    {
        preg_match("/http:\/\/www.happy-giraffe.ru\/community\/[\d]+\/forum\/(post|video)\/([\d]+)\/$/", $url, $match);
        if (isset($match[2])) {
            $entity_id = $match[2];
            $entity = 'CommunityContent';
        } else {
            //check services
            $service = Service::model()->findByAttributes(array('url' => $url));
            if ($service !== null) {
                $entity_id = $service->id;
                $entity = 'Service';
            } else {
                preg_match("/http:\/\/www.happy-giraffe.ru\/user\/[\d]+\/blog\/post([\d]+)\/$/", $url, $match);
                if (isset($match[1])) {
                    $entity_id = $match[1];
                    $entity = 'BlogContent';
                } else {
                    preg_match("/http:\/\/www.happy-giraffe.ru\/cook\/multivarka\/([\d]+)\/$/", $url, $match);
                    if (isset($match[1])) {
                        $entity_id = $match[1];
                        $entity = 'MultivarkaRecipe';
                    } else {
                        preg_match("/http:\/\/www.happy-giraffe.ru\/cook\/recipe\/([\d]+)\/$/", $url, $match);
                        if (isset($match[1])) {
                            $entity_id = $match[1];
                            $entity = 'CookRecipe';
                        }
                    }
                }
            }
        }

        if (isset($entity) && isset($entity_id))
            return array($entity, $entity_id);

        return array(null, null);
    }
}