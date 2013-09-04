<?php

/**
 * This is the model class for table "calendar__periods".
 *
 * The followings are the available columns in table 'calendar__periods':
 * @property string $id
 * @property string $title
 * @property string $heading
 * @property string $text
 * @property string $features
 * @property string $features_heading
 * @property string $slug
 * @property integer $calendar
 *
 * The followings are the available model relations:
 * @property Community[] $communities
 * @property CommunityContent[] $contents
 * @property CommunityContent[] $randomContents
 * @property Service[] $services
 */
class CalendarPeriod extends HActiveRecord
{
    public $servicesIds = array();
    public $communitiesIds = array();
    public $contentsText;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CalendarPeriod the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calendar__periods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, text, calendar, slug, features_heading, features', 'required'),
            array('title, heading, features_heading, slug', 'length', 'max' => 255),
			array('calendar', 'in', 'range' => array(0, 1)),

            array('servicesIds, communitiesIds, contentsText', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, heading, text, features, features_heading, slug, calendar', 'safe', 'on'=>'search'),
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
			'communities' => array(self::MANY_MANY, 'Community', 'calendar__periods_communities(period_id, community_id)'),
			'contents' => array(self::MANY_MANY, 'CommunityContent', 'calendar__periods_contents(period_id, content_id)'),
			'services' => array(self::MANY_MANY, 'Service', 'calendar__periods_services(period_id, service_id)'),
            'randomContents' => array(self::MANY_MANY, 'CommunityContent', 'calendar__periods_contents(period_id, content_id)', 'order' => 'RAND()', 'limit' => 5, 'scopes' => array('full')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
            'heading' => 'Заголовок',
			'text' => 'Текст',
			'features' => 'Особенности возраста (по одному пункту в строке)',
            'features_heading' => 'Заголовок особенностей возраста',
            'slug' => 'URL',
			'calendar' => 'Календарь',

            'services' => 'Сервисы',
            'communities' => 'Сообщества',
            'contents' => 'Статьи (по 1 ссылке в строке)',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('heading',$this->heading,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('features',$this->features,true);
        $criteria->compare('features_heading',$this->features_heading,true);
        $criteria->compare('slug',$this->slug,true);
		$criteria->compare('calendar',$this->calendar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors()
    {
        return array(
            'CAdvancedArBehavior' => array(
                'class' => 'site.frontend.extensions.CAdvancedArBehavior',
            ),
        );
    }

    protected function afterFind()
    {
        if (! empty($this->services))
        {
            foreach ($this->services as $service)
                $this->servicesIds[] = $service->id;
        }

        if (! empty($this->communities))
        {
            foreach ($this->communities as $community)
                $this->communitiesIds[] = $community->id;
        }

        $contentsText = '';
        foreach ($this->contents as $content)
            $contentsText .= $content->getUrl(false, true) . "\n";
        $this->contentsText = $contentsText;
    }

    protected function beforeSave()
    {
        $this->services = $this->servicesIds;
        $this->communities = $this->communitiesIds;
        if (! empty($this->contentsText)) {
            $urls = explode("\n", $this->contentsText);
            $ids = array();
            foreach ($urls as $url) {
                if (preg_match('#\/community\/(?:\d+)\/forum\/(?:video|post)\/(\d+)#', $url, $matches))
                    $ids[] = $matches[1];
            }
            $this->contents = $ids;
        }

        return parent::beforeSave();
    }

    public function getUrlParams()
    {
        return array(
            '/calendar/default/index',
            array(
                'calendar' => $this->calendar,
                'slug' => $this->slug,
            ),
        );
    }

    public function getUrl($absolute = false)
    {
        list($route, $params) = $this->urlParams;

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }

    public function getNext()
    {
        return $this->find(
            array(
                'condition' => 'calendar = :calendar AND id > :id',
                'params' => array(':calendar' => $this->calendar, ':id' => $this->id),
                'order' => 't.id',
            )
        );
    }

    public function getPrev()
    {
        return $this->find(
            array(
                'condition' => 'calendar = :calendar AND id < :id',
                'params' => array(':calendar' => $this->calendar, ':id' => $this->id),
                'order' => 't.id DESC',
            )
        );
    }
}