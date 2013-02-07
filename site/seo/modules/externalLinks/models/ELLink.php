<?php

/**
 * This is the model class for table "externallinks__links".
 *
 * The followings are the available columns in table 'externallinks__links':
 * @property string $id
 * @property string $site_id
 * @property string $url
 * @property string $our_link
 * @property string $author_id
 * @property string $created
 * @property string $check_link_time
 * @property integer $link_type
 * @property double $link_cost
 * @property integer $system_id
 *
 * The followings are the available model relations:
 * @property Keyword[] $keywords
 * @property ELSystem $system
 * @property SeoUser $author
 * @property ELSite $site
 */
class ELLink extends HActiveRecord
{
    const TYPE_LINK = 1;
    const TYPE_COMMENT = 2;
    const TYPE_POST = 3;

    const CHECK_DAYS = 7;

    public $anchors;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ELLink the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'externallinks__links';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, url, our_link, author_id, created, link_type', 'required'),
            array('link_cost, system_id', 'required', 'on' => 'paid'),
            array('link_type, system_id', 'numerical', 'integerOnly' => true),
            array('link_cost', 'numerical'),
            array('url, our_link', 'url'),
            array('url', 'unique'),
            array('site_id, author_id', 'length', 'max' => 11),
            array('url', 'length', 'max' => 2048),
            array('our_link', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, site_id, url, our_link, author_id, created, link_type, anchors', 'safe', 'on' => 'search'),
            array('link_cost, system_id', 'unsafe', 'except' => 'paid'),
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
            'keywords' => array(self::MANY_MANY, 'Keyword', 'externallinks__anchors(link_id, keyword_id)'),
            'system' => array(self::BELONGS_TO, 'ELSystem', 'system_id'),
            'author' => array(self::BELONGS_TO, 'SeoUser', 'author_id'),
            'site' => array(self::BELONGS_TO, 'ELSite', 'site_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'site_id' => 'Site',
            'url' => 'Url страницы на которой проставлена ссылка',
            'our_link' => 'Ссылка на нашем сайте',
            'author_id' => 'Автор',
            'created' => 'Дата добавления',
            'link_type' => 'Тип ссылки',
            'link_cost' => 'Стоимость ссылки',
            'system_id' => 'Система',
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
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('our_link', $this->our_link, true);
        $criteria->compare('author_id', $this->author_id);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('link_type', $this->link_type);
        $criteria->compare('link_cost', $this->link_cost);
        $criteria->compare('system_id', $this->system_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord
            && ($this->site->type == ELSite::TYPE_FORUM || $this->site->type == ELSite::TYPE_BLOG)
            && empty($this->link_cost)
        ) {
            $this->check_link_time = date("Y-m-d", strtotime('+' . self::CHECK_DAYS . ' days'));
        }

        return parent::beforeSave();
    }

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);
        return array(
            'order' => ($alias) ? $alias . '.id desc' : 'id desc',
        );
    }

    public function beforeValidate()
    {
        if (strpos($this->our_link, 'http://www.happy-giraffe.ru/') === false)
            $this->addError('our_link', 'Введите урл с НАШЕГО сайта');

        return parent::beforeValidate();
    }

    public static function checkCount()
    {
        return ELLink::model()->count('check_link_time < "' . date("Y-m-d H:i:s") . '" AND check_link_time IS NOT NULL AND check_link_time != "0000-00-00 00:00:00"');
    }

    public function nextCheckTime()
    {
        $days = (time() - strtotime($this->created)) / (3600 * 24);

//        if ($days >= 90)
//            $this->check_link_time = date("Y-m-d H:i:s", strtotime('+36 month'));
//        elseif ($days >= 29)
//            $this->check_link_time = date("Y-m-d H:i:s", strtotime('+2 month')); elseif ($days >= 14)
//            $this->check_link_time = date("Y-m-d H:i:s", strtotime('+15 days')); else
//            $this->check_link_time = date("Y-m-d H:i:s", strtotime('+7 days'));

        $this->check_link_time = null;

        return $this->save();
    }

    public function addToBlacklist()
    {
        $this->check_link_time = null;
        $this->site->bad_rating = 3;
        $this->site->save();
        $this->save();

        return $this->site->addToBlacklist();
    }

    public function getPageTitle()
    {
        $model = Page::model()->findByAttributes(array('url' => $this->our_link));
        if ($model !== null)
            return $model->getArticleTitle();
        return '';
    }

    public function getLinkTypeText()
    {
        if ($this->link_type == self::TYPE_LINK)
            return '<span class="icon-links link active">С</span>';
        if ($this->link_type == self::TYPE_POST)
            return '<span class="icon-links active post">П</span>';
        if ($this->link_type == self::TYPE_COMMENT)
            return '<span class="icon-links comment active">К</span>';

        return '';
    }

    public function getLinkPrice()
    {
        if (!empty($this->link_cost) && !empty($this->system_id))
            return $this->link_cost . ' (' . round($this->link_cost * (1 + $this->system->fee / 100)) . ')';
        else
            return '';
    }

    public function getUrlWithEmphasizedHost()
    {
        $parse = parse_url($this->url);

        if (isset($parse['scheme']) && isset($parse['host']) && isset($parse['path']))
            return '<span class="hl">' . $parse['scheme'] . '://' . $parse['host'] . '</span>' . $parse['path'];
        else
            return $this->url;
    }
}