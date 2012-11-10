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
    const FORUM_MANAGER_COMMENT_LIMIT = 21;

    const FORUM_WORKER_REG_LIMIT = 3;
    const FORUM_WORKER_LINK_LIMIT = 3;
    const FORUM_WORKER_COMMENT_LIMIT = 6;

    const FORUM_ANGRY_WORKER_REG_LIMIT = 17;
    const FORUM_ANGRY_WORKER_LINK_LIMIT = 17;
    const FORUM_ANGRY_WORKER_COMMENT_LIMIT = 51;

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

    /****************************************************************************************************************/
    /*****************************************  Создание и закрытие заданий *****************************************/
    /****************************************************************************************************************/
    public static function taskForExecuted($site_id)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_COMMENT;
        $task->start_date = date("Y-m-d", strtotime('+2 weeks'));
        $task->site_id = $site_id;
        $task->save();
    }

    /**
     * Create task for register forum
     *
     * @param $site_id int
     * @param int $user_id
     * @return void
     */
    public static function createRegisterTask($site_id, $user_id = null)
    {
        $task = new ELTask();
        $task->type = ELTask::TYPE_REGISTER;
        $task->site_id = $site_id;
        $task->start_date = date("Y-m-d");
        if (!empty($user_id))
            $task->user_id = $user_id;
        if (!$task->save())
            var_dump($task->getErrors());
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
        if ($this->type == self::TYPE_REGISTER || $this->type == self::TYPE_COMMENT) {
            if (!isset($this->site->account->login)) {
                $this->addError('type', 'Вы не ввели данные регистрации!');
                return false;
            }

            if ($this->type == self::TYPE_REGISTER) {
                //создаем еще 1 выполненное задание - комментарий, так как этот шаг - это 2 задания
                $task = new ELTask();
                $task->type = ELTask::TYPE_COMMENT;
                $task->start_date = date("Y-m-d H:i:s");
                $task->closed = date("Y-m-d H:i:s");
                $task->site_id = $this->site_id;
                $task->user_id = Yii::app()->user->id;
                $task->save();
            }

            $prev_comments_count = $this->getPreviousCommentsCount();
            $days_span = rand(1, 2);
            if ($this->getLinkExecutedTasksCount() == 0) {
                $limit = $this->site->comments_count;
                if ($limit > 10) {
                    //если нужно поставить больше 10 комментариев, ставим их чаще - 4 раза в день
                    $criteria = new CDbCriteria;
                    $criteria->condition = 'closed > :today';
                    $criteria->params = array(':today'=>date("Y-m-d").' 00:00:00');
                    $criteria->compare('site_id', $this->site_id);
                    $criteria->compare('type', self::TYPE_COMMENT);
                    $count = self::model()->count($criteria);

                    if ($count >= rand(3,5))
                        $days_span = 1;
                    else
                        $days_span = 0;
                }
            } else
                $limit = rand(3, 4);

            if ($prev_comments_count >= $limit)
                $this->createLinkTask(date("Y-m-d", strtotime('+' . $days_span . ' days')));
            else
                $this->createCommentTask(date("Y-m-d", strtotime('+' . $days_span . ' days')));

        } elseif ($this->type == self::TYPE_POST_LINK) {
            $this->createCommentTask(date("Y-m-d", strtotime('+' . rand(30, 40) . ' days')));
        }

        $this->closed = date("Y-m-d H:i:s");
        $this->user_id = Yii::app()->user->id;
        return $this->save();
    }

    /**
     * Колчество комментариев после последней проставленной ссылки
     *
     * @return int
     */
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
        $criteria->condition = 'created >= :last_link_time';
        $criteria->params = array(':last_link_time' => $latest_link_comment->created);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('type', self::TYPE_COMMENT);

        $criteria->order = 'created desc';

        return self::model()->count($criteria);
    }

    /**
     * Получаем количество выполненных заданий со ссылками - чтобы понять нужно ли
     * достигать лимита комментариев для постинга ссылки
     *
     * @return string
     */
    public function getLinkExecutedTasksCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('type', self::TYPE_POST_LINK);
        return self::model()->count($criteria);
    }

    /**
     * Возвращаем количество оставленных на форуме комментариев
     *
     * @param $site_id
     * @return string
     */
    public static function getCommentsCount($site_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NOT NULL';
        $criteria->compare('site_id', $site_id);
        $criteria->compare('type', self::TYPE_COMMENT);

        return ELTask::model()->count($criteria);
    }


    /****************************************************************************************************************/
    /****************************************  Получение очередного задания *****************************************/
    /****************************************************************************************************************/

    /**
     * Получить следующее задание для выполнения
     *
     * @return ELTask
     */
    public function getNextTask()
    {
        if ($this->todayTaskCount() >= $this->getTaskLimit())
            return null;
        //сначала задания строго закрепленные за сотрудником
        $task = $this->userSpecifiedTask();
        if ($task !== null)
            return $task;

        //задания по регистрации
        if ($this->todayRegisterTaskCount() < $this->getRegTaskLimit()) {
            $tasks = $this->getRegisterTasks();
            if (!empty($tasks))
                return $tasks;
        }

        //задания на ссылки
        if ($this->todayLinkTaskCount() < $this->getLinkTaskLimit()) {
            $task = $this->getLinkTask();
            if ($task !== null)
                return $task;
        }

        //задания на комментарии
        if ($this->todayCommentTaskCount() < $this->getCommentTaskLimit()) {
            $task = $this->getCommentTask();
            if ($task !== null)
                return $task;
        }

        //все остальное
        return $this->getAnyTask();
    }

    public function userSpecifiedTask()
    {
        //get user specified task
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date <= :today AND user_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d"),
            ':user_id' => Yii::app()->user->id
        );

        return ELTask::model()->find($criteria);
    }

    public function getRegisterTasks()
    {
        //check free register tasks
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date <= :start_date AND user_id IS NULL';
        $criteria->params = array(':start_date' => date("Y-m-d"));
        $criteria->compare('type', self::TYPE_REGISTER);

        $reg_tasks = ELTask::model()->findAll($criteria);
        return $reg_tasks;
    }

    public function getLinkTask()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date <= :today AND user_id IS NULL';
        $criteria->params = array(':start_date' => date("Y-m-d"), ':today' => date("Y-m-d"));
        $criteria->compare('type', self::TYPE_POST_LINK);

        $model = ELTask::model()->find($criteria);
        if ($model !== null) {
            $model->user_id = Yii::app()->user->id;
            $model->update(array('user_id'));
            return $model;
        }

        return null;
    }

    public function getCommentTask()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date <= :today AND user_id IS NULL';
        $criteria->params = array(':start_date' => date("Y-m-d"), ':today' => date("Y-m-d"));
        $criteria->compare('type', self::TYPE_COMMENT);

        $model = ELTask::model()->find($criteria);
        if ($model !== null) {
            $model->user_id = Yii::app()->user->id;
            $model->update(array('user_id'));
            return $model;
        }

        return null;
    }

    public function getAnyTask()
    {
        //check free register tasks
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed IS NULL AND start_date <= :start_date AND user_id IS NULL';
        $criteria->params = array(':start_date' => date("Y-m-d"));

        $model = ELTask::model()->find($criteria);
        if ($model !== null) {
            $model->user_id = Yii::app()->user->id;
            $model->update(array('user_id'));
            return $model;
        }

        return null;
    }


    /****************************************************************************************************************/
    /*****************************************  Количество выполненных сегодня **************************************/
    /****************************************************************************************************************/

    public function todayTaskCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed >= :today AND user_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d") . ' 00:00:00',
            ':user_id' => Yii::app()->user->id,
        );
        return ELTask::model()->count($criteria);
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

    public function todayCommentTaskCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'closed >= :today AND type > 1 AND  user_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d"),
            ':user_id' => Yii::app()->user->id
        );
        return ELTask::model()->count($criteria);
    }


    /****************************************************************************************************************/
    /************************************************  Лимиты заданий ***********************************************/
    /****************************************************************************************************************/

    public function getRegTaskLimit()
    {
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            return self::FORUM_MANAGER_REG_LIMIT;
        elseif (in_array(Yii::app()->user->id, array(141)))
            return self::FORUM_ANGRY_WORKER_REG_LIMIT; else
            return self::FORUM_WORKER_REG_LIMIT;
    }

    public function getLinkTaskLimit()
    {
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            return self::FORUM_MANAGER_LINK_LIMIT;
        elseif (in_array(Yii::app()->user->id, array(141)))
            return self::FORUM_ANGRY_WORKER_LINK_LIMIT; else
            return self::FORUM_WORKER_LINK_LIMIT;
    }

    public function getCommentTaskLimit()
    {
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            return self::FORUM_MANAGER_COMMENT_LIMIT;
        elseif (in_array(Yii::app()->user->id, array(141)))
            return self::FORUM_ANGRY_WORKER_COMMENT_LIMIT; else
            return self::FORUM_WORKER_COMMENT_LIMIT;
    }

    public function getTaskLimit()
    {
        if (Yii::app()->user->checkAccess('externalLinks-manager-panel'))
            return self::FORUM_MANAGER_REG_LIMIT + self::FORUM_MANAGER_LINK_LIMIT + self::FORUM_MANAGER_COMMENT_LIMIT;
        elseif (in_array(Yii::app()->user->id, array(141)))
            return self::FORUM_ANGRY_WORKER_REG_LIMIT + self::FORUM_ANGRY_WORKER_LINK_LIMIT + self::FORUM_ANGRY_WORKER_COMMENT_LIMIT; else
            return self::FORUM_WORKER_REG_LIMIT + self::FORUM_WORKER_LINK_LIMIT + self::FORUM_WORKER_COMMENT_LIMIT;
    }
}