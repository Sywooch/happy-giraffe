<?php

/**
 * This is the model class for table "calendar__periods".
 *
 * The followings are the available columns in table 'calendar__periods':
 * @property string $id
 * @property string $title
 * @property string $text
 * @property string $features
 * @property integer $calendar
 *
 * The followings are the available model relations:
 * @property CalendarPeriodsCommunities[] $calendarPeriodsCommunities
 * @property CalendarPeriodsContents[] $calendarPeriodsContents
 * @property CalendarPeriodsServices[] $calendarPeriodsServices
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
			array('title, text', 'required'),
            array('title', 'length', 'max' => 255),
			array('calendar', 'in', 'range' => array(0, 1)),
            array('servicesIds, communitiesIds, contentsText', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, text, features, calendar', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название периода',
			'text' => 'Текст',
			'features' => 'Особенности (по одному пункту в строке)',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('features',$this->features,true);
		$criteria->compare('calendar',$this->calendar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors()
    {
        return array('CAdvancedArBehavior',
            array('class' => 'ext.CAdvancedArBehavior')
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
        if (! empty($this->servicesIds))
            $this->services = $this->servicesIds;
        if (! empty($this->communitiesIds))
            $this->communities = $this->communitiesIds;
        if (! empty($this->contentsText)) {
            $urls = explode("\n", $this->contentsText);
            $ids = array();
            foreach ($urls as $url) {
                if (preg_match('#\/community\/(?:\d+)\/forum\/(?:video|post|travel)\/(\d+)#', $url, $matches))
                    $ids[] = $matches[1];
            }
            $this->contents = $ids;
        }

        return parent::beforeSave();
    }
}