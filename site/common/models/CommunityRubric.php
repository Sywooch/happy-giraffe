<?php

/**
 * This is the model class for table "{{community__rubrics}}".
 *
 * The followings are the available columns in table '{{community__rubrics}}':
 * @property string $id
 * @property string $title
 * @property string $user_id
 * @property string $community_id
 *
 * @property Community $community
 * @property User $user
 * @property CommunityContent[] $contents
 */
class CommunityRubric extends HActiveRecord
{
    private $_typeCounts = null;

    public function getCount($type_id = null)
    {
        if ($this->_typeCounts === null) {
            $raw = Yii::app()->db->createCommand()
                ->select('type_id, count(*)')
                ->from('community__contents c')
                ->where('c.rubric_id = :rubric_id', array(':rubric_id' => $this->id))
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
     * @return CommunityRubric the static model class
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
        return 'community__rubrics';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 255),
            array('community_id', 'exist', 'attributeName' => 'id', 'className' => 'Community'),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
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
            'community' => array(self::BELONGS_TO, 'Community', 'community_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'contents' => array(self::HAS_MANY, 'CommunityContent', 'rubric_id'),
            'contentsCount' => array(self::STAT, 'CommunityContent', 'rubric_id'),
            'childs' => array(self::HAS_MANY, 'CommunityRubric', 'parent_id'),
            'parent' => array(self::BELONGS_TO, 'CommunityRubric', 'parent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Name',
            'community_id' => 'Community',
        );
    }

    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('community_id', $this->community_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getUrl()
    {
        if (empty($this->user_id))
            return Yii::app()->createUrl('community/default/forum/', array(
                'community_id' => $this->community_id,
                'rubric_id' => $this->id,
            ));
        else
            return Yii::app()->createUrl('/blog/default/index', array(
                'user_id' => $this->user_id,
                'rubric_id' => $this->id
            ));
    }

    /**
     * Возвращает рубрики блога пользователя в которых есть записи
     *
     * @param int $user_id
     * @return int[]
     */
    public static function notEmptyUserRubricIds($user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('rubric_id')
            ->from('community__contents')
            ->where('author_id = :user_id AND removed = 0', array(':user_id' => $user_id))
            ->queryColumn();
    }
}