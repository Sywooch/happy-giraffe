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
 * @property InnerLink[] $outputLinks
 * @property InnerLink[] $inputLinks
 * @property int $outputLinksCount
 * @property int $inputLinksCount
 * @property SearchEngineVisits[] $visits
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
        return 'pages';
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
            'visits' => array(self::HAS_MANY, 'SearchEngineVisits', 'page_id'),

            'outputLinksCount' => array(self::STAT, 'InnerLink', 'page_id'),
            'inputLinksCount' => array(self::STAT, 'InnerLink', 'page_to_id'),
            'taskCount' => array(self::STAT, 'SeoTask', 'article_id'),
            'phrasesCount' => array(self::STAT, 'PagesSearchPhrase', 'page_id'),
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
            'entity_id' => 'Entity id',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('entity', $this->entity);
        $criteria->compare('entity_id', $this->entity_id);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('keyword_group_id', $this->keyword_group_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

//    public function beforeSave()
//    {
//        $this->number = self::getDbConnection()->createCommand('select MAX(number) from ' . $this->tableName())->queryScalar() + 1;
//        return parent::beforeSave();
//    }

    public function beforeDelete()
    {
        if ($this->keywordGroup !== null)
            $this->keywordGroup->delete();
        return parent::beforeDelete();
    }

    /**
     * @return CommunityContent
     */
    public function getArticle()
    {
        if (empty($this->entity) || empty($this->entity_id))
            return null;

        $model = CActiveRecord::model($this->entity)->resetScope()->findByPk($this->entity_id);
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
        $cache_id = 'page_link_' . $this->id . ((int)$icon);
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            if (!empty($this->entity)) {
                $model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
                if ($model !== null)
                    $value = CHtml::link($icon ? '' : $model->title, 'http://www.happy-giraffe.ru' . $model->url, array('target' => '_blank'));
            } else
                $value = CHtml::link($this->url, $this->url, array('target' => '_blank'));
            Yii::app()->cache->set($cache_id, $value);
        }

        return $value;
    }

    /**
     * Ищет статью по урлу, если не находит, то создает. Добавляет кейврд в группу
     *
     * @param string $url
     * @param array $keywords
     * @param bool $add_keywords
     * @return Page
     */
    public function getOrCreate($url, $keywords = array(), $add_keywords = false)
    {
        $url = trim($url);
        if (!is_array($keywords))
            $keywords = array($keywords);

        $model = Page::model()->findByAttributes(array('url' => $url));
        if ($model === null) {
            $keyword_group = new KeywordGroup();
            if (!empty($keywords)) {
                $keyword_group->keywords = Keyword::model()->findAllByPk($keywords);
                $keyword_group->withRelated->save(true, array('keywords'));
            } else
                $keyword_group->save();

            $model = new Page();
            $model->url = $url;

            list($entity, $entity_id) = Page::ParseUrl($url);

            if (empty($entity_id))
                return false;

            if ($entity != null && $entity_id != null) {
                $article = CActiveRecord::model($entity)->findByPk($entity_id);
                if ($article !== null) {
                    $exist = Page::model()->findByAttributes(array(
                        'entity' => $entity,
                        'entity_id' => $entity_id,
                    ));
                    if ($exist !== null) {
                        $model = $exist;
                        if ($add_keywords && !empty($keywords)) {
                            #TODO надо добавлять кейворды а не заменять на новые
                            $model->keywordGroup->keywords = Keyword::model()->findAllByPk($keywords);
                            $model->keywordGroup->withRelated->save(true, array('keywords'));
                        }
                    } else {
                        $model->entity = $entity;
                        $model->entity_id = $entity_id;
                        $model->keyword_group_id = $keyword_group->id;
                        $model->save();
                    }
                } else {
                    $model = null;
                }
            } else {
                $model->keyword_group_id = $keyword_group->id;
                $model->save();
            }
        } else {
            if ($add_keywords && !empty($keywords)) {
                #TODO надо добавлять кейворды а не заменять на новые
                $model->keywordGroup->keywords = Keyword::model()->findAllByPk($keywords);
                $model->keywordGroup->withRelated->save(true, array('keywords'));

            }
        }
        return $model;
    }

    public static function getPage($url)
    {
        $model = Page::model()->findByAttributes(array('url' => $url));
        if ($model === null)
            return self::getOrCreate($url);
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

        if (get_class($model) !== 'BlogContent' && get_class($model) !== 'CommunityContent')
            return 'http://www.happy-giraffe.ru/community/';

        if ($model->getIsFromBlog()) {
            return 'http://www.happy-giraffe.ru/user/';
        } elseif (isset($model->rubric->community_id))
            return 'http://www.happy-giraffe.ru/community/' . $model->rubric->community_id; else
            return 'http://www.happy-giraffe.ru/community/';
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

    public function CanBeLinkDonor()
    {
        if (strpos($this->url, 'http://www.happy-giraffe.ru/cook/recipe/') === 0)
            return true;
        if (strpos($this->url, 'http://www.happy-giraffe.ru/cook/multivarka/') === 0)
            return true;
        if (strpos($this->url, 'http://www.happy-giraffe.ru/community/') === 0
            && strpos($this->url, '/forum/') !== false
        )
            return true;
        if (strpos($this->url, 'http://www.happy-giraffe.ru/recipeBook/recipe') === 0)
            return true;
        if (strpos($this->url, 'http://www.happy-giraffe.ru/user/') === 0
            && strpos($this->url, '/blog/post') !== false
        )
            return true;

        return false;
    }

    public function TestUrlParsing()
    {
        $r = Page::ParseUrl('http://www.happy-giraffe.ru/cook/recipe/18484/');
        print_r($r);
        $r = Page::ParseUrl('http://www.happy-giraffe.ru/cook/multivarka/16126/');
        print_r($r);
        $r = Page::ParseUrl('http://www.happy-giraffe.ru/placentaThickness/');
        print_r($r);
        $r = Page::ParseUrl('http://www.happy-giraffe.ru/community/31/forum/post/33879/');
        print_r($r);
        $r = Page::ParseUrl('http://www.happy-giraffe.ru/user/10/blog/post27381/');
        print_r($r);
    }
}