<?php

/**
 * This is the model class for table "contest__contests".
 *
 * The followings are the available columns in table 'contest__contests':
 * @property string $id
 * @property string $title
 * @property string $text
 * @property string $rules
 * @property string $from_time
 * @property string $till_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property ContestPrizes[] $contestPrizes
 * @property ContestWorks[] $contestWorks
 */
class Contest extends HActiveRecord
{
    const STATUS_DEVELOPMENT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_FINISHED = 2;
    const STATUS_RESULTS = 3;

    const STATEMENT_GUEST = 10;
    const STATEMENT_STEPS = 11;
    const STATEMENT_FINISHED = 12;
    const STATEMENT_ALREADY = 13;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Contest the static model class
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
        return 'contest__contests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, text, rules, from_time, till_time, status', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, text, rules, from_time, till_time, status', 'safe', 'on'=>'search'),
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
            'prizes' => array(self::HAS_MANY, 'ContestPrize', 'contest_id'),
            'works' => array(self::HAS_MANY, 'ContestWork', 'contest_id'),
            'worksCount' => array(self::STAT, 'ContestWork', 'contest_id'),
            'winners' => array(self::HAS_MANY, 'ContestWinner', array('id' => 'work_id'), 'through' => 'works', 'with' => 'work'),
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
            'text' => 'Text',
            'rules' => 'Rules',
            'from_time' => 'From Time',
            'till_time' => 'Till Time',
            'status' => 'Status',
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
        $criteria->compare('rules',$this->rules,true);
        $criteria->compare('from_time',$this->from_time,true);
        $criteria->compare('till_time',$this->till_time,true);
        $criteria->compare('status',$this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getActiveList()
    {
        return new CActiveDataProvider($this, array(
            'criteria' => array(
                'condition' => 'status != :status_development',
                'params' => array(':status_development' => self::STATUS_DEVELOPMENT),
                'order' => 'id DESC',
            ),
        ));
    }

    public function getCanParticipate()
    {
        if (ContestWork::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'contest_id' => $this->id)))
            return self::STATEMENT_ALREADY;
        if ($this->status > self::STATUS_ACTIVE)
            return self::STATEMENT_FINISHED;
        if (Yii::app()->user->isGuest)
            return self::STATEMENT_GUEST;
        if (Yii::app()->user->model->score->full == 0)
            return self::STATEMENT_STEPS;
        return true;
    }

    public function getPhotoCollection($preload_id = null)
    {
        $criteria = new CDbCriteria(array(
            'with' => array(
                'photoAttach' => array(
                    'with' => array(
                        'photo' => array(
                            'alias' => 'albumphoto',
                            'with' => array(
                                'author' => array(
                                    'with' => 'avatar',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'condition' => 'contest_id = :contest_id',
            'params' => array(':contest_id' => $this->id),
        ));

        $criteria->order = 't.' . Yii::app()->request->getQuery('sort', 'created') . ' DESC';

        $currentIndex = null;
        $count = null;
        if ($preload_id === null || Yii::app()->controller->action->id == 'postLoad') {
            $works = ContestWork::model()->findAll($criteria);
        } else {
            $idsCriteria = clone $criteria;
            $idsCriteria->select = 'id';
            $idsCriteria->with = false;
            $_ids = ContestWork::model()->findAll($idsCriteria);
            $count = count($_ids);

            foreach ($_ids as $i => $p) {
                if ($p->id == $preload_id) {
                    $currentIndex = $i;
                    break;
                }
            }

            $preload = array();
            $preload[] = $_ids[$currentIndex]->id;
            $currentNext = $currentIndex;
            $currentPrev = $currentIndex;
            for ($i = 0; $i < 3; $i++) {
                $currentNext = ($currentNext == ($count - 1)) ? 0 : ($currentNext + 1);
                $currentPrev = ($currentPrev == 0) ? ($count - 1) : ($currentPrev - 1);
                $preload[] = $_ids[$currentNext]->id;
                $preload[] = $_ids[$currentPrev]->id;
            }

            $criteria->addInCondition('t.id', $preload);
            $works = ContestWork::model()->findAll($criteria);
        }

        $photos = array();
        foreach ($works as $w) {
            $p = $w->photoAttach->photo;
            $p->w_title = $w->title;
            $photos[] = $p;
        }

        return array(
            'title' => 'Фотоконкурс ' . CHtml::link($this->title, $this->url),
            'photos' => $photos,
            'currentIndex' => $currentIndex,
            'count' => $count,
        );
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/contest/default/view', array('id' => $this->id));
    }

    public function getFrom()
    {
        return date('d.m', strtotime($this->from_time));
    }

    public function getTo()
    {
        return date('d.m', strtotime($this->till_time));
    }

    public function getYear()
    {
        return date('Y', strtotime($this->from_time));
    }

    public function getEvent()
    {
        $row = array(
            'id' => $this->id,
            'last_updated' => time(),
            'type' => Event::EVENT_CONTEST,
        );

        $event = Event::factory(Event::EVENT_CONTEST);
        $event->attributes = $row;
        return $event;
    }

    public function sendEvent()
    {
        $event = $this->event;
        $params = array(
            'blockId' => $event->blockId,
            'code' => $event->code,
        );

        $comet = new CometModel;
        $comet->send('whatsNewIndex', $params, CometModel::WHATS_NEW_UPDATE);
    }
}