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
class Contest extends CActiveRecord
{
    const STATUS_DEVELOPMENT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_FINISHED = 2;
    const STATUS_RESULT = 3;

    const STATEMENT_GUEST = 10;
    const STATEMENT_STEPS = 11;

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

    public function getIsStatement()
    {
        if (Yii::app()->user->isGuest)
            return self::STATEMENT_GUEST;
        if (Yii::app()->user->model->getScores()->full != 2)
            return self::STATEMENT_STEPS;
        if (ContestWork::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'contest_id' => $this->id)))
            return false;
        if (time() > strtotime($this->till_time))
            return false;
        return true;
    }

    public function getWorkCount()
    {
        $contestWork = new ContestWork;
        return Yii::app()->db->createCommand()
            ->select('COUNT(id)')
            ->from($contestWork->tableName())
            ->where('contest_id=:contest_id', array(
            ':contest_id'=>$this->id,
        ))
            ->queryScalar();
    }

    protected function beforeSave()
    {
        $this->from_time = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $this->from_time);
        $this->till_time = preg_replace('/(\d{2})\.(\d{2})\.(\d{4})/', '$3-$2-$1', $this->till_time);

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        $this->from_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->from_time);
        $this->till_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->till_time);

        parent::afterSave();
    }

    protected function afterFind()
    {
        $this->from_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->from_time);
        $this->till_time = preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $this->till_time);

        return parent::afterFind();
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
        if ($preload_id === null) {
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
}