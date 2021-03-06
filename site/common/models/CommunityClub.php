<?php

/**
 * This is the model class for table "community__clubs".
 *
 * The followings are the available columns in table 'community__clubs':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $services_description
 * @property string $services_title
 * @property string $section_id
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property CommunitySection $section
 * @property Community[] $communities
 * @property Service[] $services
 */
class CommunityClub extends HActiveRecord implements IHToJSON
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommunityClub the static model class
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
        return 'community__clubs';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, section_id', 'required'),
            array('title', 'length', 'max' => 255),
            array('description', 'length', 'max' => 1000),
            array('section_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, section_id', 'safe', 'on' => 'search'),
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
            'section' => array(self::BELONGS_TO, 'CommunitySection', 'section_id'),
            'communities' => array(self::HAS_MANY, 'Community', 'club_id'),
            'services' => array(self::MANY_MANY, 'Service', 'services__communities(service_id, community_id)', 'condition' => '`show`=1'),
            'contest' => array(self::HAS_ONE, 'CommunityContest', array('id' => 'forum_id'), 'through' => 'communities'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'services_description' => 'Service Description',
            'section_id' => 'Section',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('section_id', $this->section_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/posts/forums/club/index', array(
            'club' => $this->slug,
        ));
    }

    public function getCommunities()
    {
        $result = array();
        foreach ($this->communities as $community)
            if ($community->id != 21 && $community->id != 22 && $community->id != 19)
                $result[] = $community;
        return $result;
    }

    /**
     * Возвращает модераторов клуба
     * @return User[]
     */
    public function getModerators()
    {
        $ids = Yii::app()->db->createCommand()
            ->select('userid')
            ->from('auth__assignments')
            ->where('itemname="moderator"')
            ->queryColumn();

        $club_moders = array();
        foreach ($ids as $id)
            if (Yii::app()->authManager->checkAccess('moderator', $id, array('community_id' => $this->id)))
                $club_moders [] = $id;

        return User::model()->findAllByPk($club_moders);
    }

    public function getFavourites($type = null, $dataProvider = true)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.created DESC';
        $criteria->compare('club_id', $this->id);
        $criteria->scopes = array('active');
        $criteria->with = array('rubric', 'rubric.community', 'type', 'commentsCount', 'sourceCount');
        $criteria->addInCondition('t.id', Favourites::getIdListByBlock(Favourites::CLUB_MORE));
        if ($type !== null)
            $criteria->compare('t.type_id', $type);

        return ($dataProvider) ? new CActiveDataProvider('CommunityContent', array(
            'criteria' => $criteria,
        )) : CommunityContent::model()->findAll($criteria);
    }
    
    public function toLabel()
    {
        return 'Клуб: ' . $this->title;
    }

    public function toJSON()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->getUrl(),
        );
    }

}