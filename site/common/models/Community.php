<?php

/**
 * This is the model class for table "{{community__forums}}".
 *
 * The followings are the available columns in table '{{community__forums}}':
 * @property string $id
 * @property string $title
 * @property string $short_title
 * @property string $description
 * @property string $pic
 * @property string $position
 * @property string $css_class
 * @property string $club_id
 *
 * @property CommunityRubric[] $rubrics
 * @property CommunityClub $club
 */
class Community extends HActiveRecord
{
    const USERS_COMMUNITY = 999999;
    const COMMUNITY_NEWS = 36;
    const COMMUNITY_VALENTINE = 37;

    private $_typeCounts = null;

    public function getCount($type_id = null)
    {
        if ($this->_typeCounts === null) {
            $raw = Yii::app()->db->createCommand()
                ->select('type_id, count(*)')
                ->from('community__contents c')
                ->join('community__rubrics r', 'r.id=c.rubric_id')
                ->where('r.community_id = :community_id AND c.removed = 0', array(':community_id' => $this->id))
                ->group('c.type_id')
                ->queryAll();

            $this->_typeCounts['total'] = 0;
            foreach ($raw as $r) {
                $this->_typeCounts[$r['type_id']] = $r['count(*)'];
                $this->_typeCounts['total'] += $r['count(*)'];
            }
        }

        if ($type_id == null) {
            return $this->_typeCounts['total'];
        } elseif (isset($this->_typeCounts[$type_id])) {
            return $this->_typeCounts[$type_id];
        } else {
            return 0;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Community the static model class
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
        return 'community__forums';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, pic', 'required'),
            array('title, pic', 'length', 'max' => 255),
            array('position', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, pic', 'safe', 'on' => 'search'),
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
            'rubrics' => array(self::HAS_MANY, 'CommunityRubric', 'community_id'),
            'rootRubrics' => array(self::HAS_MANY, 'CommunityRubric', 'community_id', 'condition' => 'rootRubrics.parent_id IS NULL'),
            'users' => array(self::MANY_MANY, 'User', 'user__users_communities(user_id, community_id)'),
            'usersCount' => array(self::STAT, 'User', 'user__users_communities(user_id, community_id)'),
            'mobileCommunity' => array(self::BELONGS_TO, 'MobileCommunity', 'mobile_community_id'),
            'club' => array(self::BELONGS_TO, 'CommunityClub', 'club_id'),
            'contest' => array(self::HAS_ONE, 'CommunityContest', 'forum_id', 'order' => 'id DESC'),
        );
    }

    public function getContentsCount()
    {
        $sql = "
            SELECT COUNT(*)
            FROM community__contents
            JOIN community__rubrics ON community__contents.rubric_id = community__rubrics.id
            AND community__contents.removed = 0
            WHERE community__rubrics.community_id = :community_id
        ";

        $command = Yii::app()->db->createCommand($sql);
        $community_id = $this->id;
        $command->bindParam(":community_id", $community_id, PDO::PARAM_INT);
        return $command->queryScalar();
    }

    public function getCommentsCount()
    {
        $sql = "
            SELECT COUNT(*)
            FROM comments
            JOIN community__contents ON comments.entity = 'CommunityContent'
            AND comments.entity_id = community__contents.id
            AND community__contents.removed = 0
            JOIN community__rubrics ON community__contents.rubric_id = community__rubrics.id
            WHERE community__rubrics.community_id = :community_id
        ";

        $command = Yii::app()->db->createCommand($sql);
        $community_id = $this->id;
        $command->bindParam(":community_id", $community_id, PDO::PARAM_INT);
        return $command->queryScalar();
    }

    public function scopes()
    {
        return array(
            'public' => array(
                'condition' => 'id < :news_community',
                'params' => array(':news_community' => self::COMMUNITY_NEWS),
            ),
            'sorted' => array(
                'order' => 'position asc',
            )
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
            'pic' => 'Pic',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('pic', $this->pic, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getUrl($absolute = false)
    {
        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';

        return Yii::app()->$method('community/default/forum', array(
            'forum_id' => $this->id,
        ));
    }

    public function getBanners($limit = 2)
    {
        return CommunityBanner::model()->findAll(array(
            'with' => array('content'),
            'limit' => $limit,
            'order' => new CDbExpression('RAND()'),
            'condition' => 'rubric_id IN ('.implode(',', self::getRubricIds($this->id)).') AND t.photo_id IS NOT NULL',
        ));
    }

    /**
     * Возвращает рубрики сообщества
     *
     * @param $community_id
     * @return int[]
     */
    public static function getRubricIds($community_id)
    {
        return Yii::app()->db->cache(300)->createCommand()
            ->select('id')
            ->from(CommunityRubric::model()->tableName())
            ->where('community_id=' . $community_id)
            ->queryColumn();
    }
}