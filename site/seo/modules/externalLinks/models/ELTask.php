<?php

/**
 * This is the model class for table "externallinks__tasks".
 *
 * The followings are the available columns in table 'externallinks__tasks':
 * @property string $id
 * @property string $site_id
 * @property integer $type
 * @property string $user_id
 * @property string $created
 * @property string $start_date
 * @property string $closed
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property ELSite $site
 */
class ELTask extends HActiveRecord
{
    const TYPE_REGISTER = 1;
    const TYPE_COMMENT = 2;
    const TYPE_POST_LINK = 3;

    const FORUM_MANAGER_REG_LIMIT = 7;
    const FORUM_MANAGER_LINK_LIMIT = 7;
    const FORUM_MANAGER_COMMENT_LIMIT = 14;

    const FORUM_WORKER_REG_LIMIT = 3;
    const FORUM_WORKER_LINK_LIMIT = 3;
    const FORUM_WORKER_COMMENT_LIMIT = 6;

    const FORUM_ANGRY_WORKER_REG_LIMIT = 17;
    const FORUM_ANGRY_WORKER_LINK_LIMIT = 17;
    const FORUM_ANGRY_WORKER_COMMENT_LIMIT = 34;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ELTask the static model class
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
        return 'externallinks__tasks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, type, start_date', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('site_id, user_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, site_id, type, user_id, created, closed', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'SeoUser', 'user_id'),
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
            'type' => 'Type',
            'user_id' => 'User',
            'created' => 'Created',
            'closed' => 'Closed',
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
        $criteria->compare('type', $this->type);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('closed', $this->closed, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
        );
    }

    /**
     * Create task for register forum
     *
     * @param $site_id int
     */
    public static function createRegisterTask($site_id)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_REGISTER;
        $task->site_id = $site_id;
        $task->start_date = date("Y-m-d");
        if (!$task->save())
            var_dump($task->getErrors());
    }

    public static function taskForExecuted($site_id)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_COMMENT;
        $task->start_date = date("Y-m-d", strtotime('+2 weeks'));
        $task->site_id = $site_id;
        $task->save();
    }

    /**
     * Create comment task
     *
     * @param string $date
     * @param int $user_id
     * @return void
     */
    public function createCommentTask($date, $user_id = null)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_COMMENT;
        $task->start_date = $date;
        if (!empty($user_id))
            $task->user_id = $user_id;

        $task->site_id = $this->site_id;
        $task->save();
    }

    /**
     * Create link task
     *
     * @param string $date
     * @param int $user_id
     * @return void
     */
    public function createLinkTask($date, $user_id = null)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_POST_LINK;
        $task->start_date = $date;
        $task->site_id = $this->site_id;
        $task->user_id = $user_id;
        $task->save();
    }

    public function closeTask()
    {
        if ($this->type == self::TYPE_REGISTER) {
            //create comment task instantly
            $this->createCommentTask(date("Y-m-d"), $this->user_id);
        } elseif ($this->type == self::TYPE_COMMENT) {
            if (!isset($this->site->account->login)){
                $this->addError('type', 'Вы не ввели данные регистрации!');
                return false;
            }

            $prev_comments_count = $this->getPreviousCommentsCount();
            if ($prev_comments_count >= 2)
                $this->createLinkTask(date("Y-m-d", strtotime('+' . rand(1, 2) . ' days')));
            else
                $this->createCommentTask(date("Y-m-d", strtotime('+' . rand(1, 2) . ' days')));

        } elseif ($this->type == self::TYPE_POST_LINK) {
            $this->createCommentTask(date("Y-m-d", strtotime('+' . rand(30, 40) . ' days')));
        }

        $this->closed = date("Y-m-d H:i:s");
        $this->user_id = Yii::app()->user->id;
        return $this->save();
    }

    public function getPreviousCommentsCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('type', self::TYPE_POST_LINK);
        $criteria->order = 'created desc';

        $latest_link_comment = self::model()->find($criteria);
        if ($latest_link_comment === null) {
            $criteria = new CDbCriteria;
            $criteria->compare('site_id', $this->site_id);
            $criteria->compare('type', self::TYPE_COMMENT);
            return self::model()->count($criteria);
        }

        $criteria = new CDbCriteria;
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('type', self::TYPE_COMMENT);
        $criteria->condition = 'created >= :last_link_time';
        $criteria->params = array(':last_link_time' => $latest_link_comment->created);

        $criteria->order = 'created desc';

        return self::model()->count($criteria);
    }

    public static function getCommentsCount($site_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NOT NULL';
        $criteria->compare('site_id', $site_id);
        $criteria->compare('type', self::TYPE_COMMENT);

        return ELTask::model()->count($criteria);
    }

    /**
     * @return ELTask
     */
    public function getNextTask()
    {
        if ($this->todayTaskCount() <= 0)
            return null;

        //first get register tasks
        $tasks = $this->getRegisterTasks();
        if (!empty($tasks))
            return $tasks;

        return $this->getSimpleTask();
    }

    public function getRegisterTasks()
    {
        //get user specified task
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date <= :today AND user_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d"),
            ':user_id' => Yii::app()->user->id
        );

        $task = ELTask::model()->find($criteria);
        if ($task !== null)
            return $task;

        if ($this->todayRegisterTaskCount() >= $this->getRegTaskLimit())
            return null;

        //check free register tasks
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date <= :start_date AND user_id IS NULL';
        $criteria->params = array(':start_date' => date("Y-m-d"));
        $criteria->compare('type', self::TYPE_REGISTER);

        $reg_tasks = ELTask::model()->findAll($criteria);
        return $reg_tasks;
    }

    public function getSimpleTask()
    {
        if ($this->todayPostTaskCount() - $this->todayRegisterTaskCount() >= $this->getTaskLimit())
            return null;

        //get links first
        if ($this->todayLinkTaskCount() < $this->getLinkTaskLimit()) {
            $criteria = new CDbCriteria;
            $criteria->params = array(':start_date' => date("Y-m-d"));
            $criteria->condition = 'closed IS NULL AND start_date <= :today AND user_id IS NULL AND type = '.self::TYPE_POST_LINK;
            $criteria->params = array(':today' => date("Y-m-d"));
            $model = ELTask::model()->find($criteria);
            if ($model !== null) {
                $model->user_id = Yii::app()->user->id;
                $model->update(array('user_id'));
            }
            return $model;
        }

        //check other tasks
        $criteria = new CDbCriteria;
        $criteria->params = array(':start_date' => date("Y-m-d"));
        $criteria->condition = 'closed IS NULL AND start_date <= :today AND user_id IS NULL AND type > 1';
        $criteria->params = array(':today' => date("Y-m-d"));

        $model = ELTask::model()->find($criteria);
        if ($model !== null) {
            $model->user_id = Yii::app()->user->id;
            $model->update(array('user_id'));
        }
        return $model;
    }

    public function todayTaskCount()
    {
        $count = $this->getTaskLimit() - $this->todayPostTaskCount();
        return ($count <= 0) ? 0 : $count;
    }

    public function todayRegisterTaskCount()
    {
        //считаем сколько уже выполнено регистраций
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed >= :today AND user_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d") . ' 00:00:00',
            ':user_id' => Yii::app()->user->id,
        );
        $criteria->compare('type', self::TYPE_REGISTER);
        return ELTask::model()->count($criteria);
    }

    public function todayLinkTaskCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed >= :today AND type = 3 AND  user_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d"),
            ':user_id' => Yii::app()->user->id
        );
        return ELTask::model()->count($criteria);
    }

    public function todayPostTaskCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed >= :today AND type > 1 AND  user_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d"),
            ':user_id' => Yii::app()->user->id
        );
        return ELTask::model()->count($criteria);
    }

    public function getRegTaskLimit()
    {
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            return self::FORUM_MANAGER_REG_LIMIT;
        elseif (in_array(Yii::app()->user->id, array(141)))
            return self::FORUM_ANGRY_WORKER_REG_LIMIT;
        else
            return self::FORUM_WORKER_REG_LIMIT;
    }

    public function getLinkTaskLimit()
    {
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            return self::FORUM_MANAGER_LINK_LIMIT;
        elseif (in_array(Yii::app()->user->id, array(141)))
            return self::FORUM_ANGRY_WORKER_LINK_LIMIT;
        else
            return self::FORUM_WORKER_LINK_LIMIT;
    }

    public function getTaskLimit()
    {
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            return self::FORUM_MANAGER_REG_LIMIT + self::FORUM_MANAGER_LINK_LIMIT + self::FORUM_MANAGER_COMMENT_LIMIT;
        elseif (in_array(Yii::app()->user->id, array(141)))
            return self::FORUM_ANGRY_WORKER_REG_LIMIT + self::FORUM_ANGRY_WORKER_LINK_LIMIT + self::FORUM_ANGRY_WORKER_COMMENT_LIMIT;
        else
            return self::FORUM_WORKER_REG_LIMIT + self::FORUM_WORKER_LINK_LIMIT + self::FORUM_WORKER_COMMENT_LIMIT;
    }
}