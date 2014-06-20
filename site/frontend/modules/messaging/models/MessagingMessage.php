<?php

/**
 * This is the model class for table "messaging__messages".
 *
 * The followings are the available columns in table 'messaging__messages':
 * @property string $id
 * @property string $author_id
 * @property string $thread_id
 * @property string $text
 * @property string $updated
 * @property string $created
 * @property array $json Массив данных данного объекта, для формирования JSON
 * @property bool $isReadByInterlocutor
 * @property array $photoCollection Массив формата array( 'title' => sting, 'photos' => AttachPhoto[] )
 *
 * The followings are the available model relations:
 * @property User $author
 * @property MessagingThread $thread
 * @property User[] $users
 * @property MessagingMessageUser $messageUsers
 */
class MessagingMessage extends HActiveRecord
{

    // ??? не используется
    public $processed_photos = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MessagingMessage the static model class
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
        return 'messaging__messages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('author_id', 'required'),
            array('text', 'requiredIfNoImages'),
            array('updated, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, author_id, thread_id, text, updated, created', 'safe', 'on' => 'search'),
        );
    }

    // Магия. Не используется в других моделях???
    // TODO: Перенести валидатор в поведение ProcessingImagesBehavior
    public function requiredIfNoImages($attribute, $params)
    {
        if (empty($this->images))
        {
            $validator = CValidator::createValidator('required', $this, $attribute, $params);
            $validator->validate($this);
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'thread' => array(self::BELONGS_TO, 'MessagingThread', 'thread_id'),
            'messageUsers' => array(self::HAS_MANY, 'MessagingMessageUser', 'message_id'),
            'images' => array(
                self::HAS_MANY,
                'AttachPhoto',
                'entity_id',
                'on' => 'entity = :entity',
                'params' => array(':entity' => 'MessagingMessage'),
                'with' => array(
                    'photo',
                ),
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text'),
                'options' => array(
                    'AutoFormat.Linkify' => true,
                ),
            ),
            'processingImages' => array(
                'class' => 'site.common.behaviors.ProcessingImagesBehavior',
                'attributes' => array('text'),
            ),
            'antispam' => array(
                'class' => 'site.frontend.modules.antispam.behaviors.AntispamBehavior',
                'interval' => 5,
                'maxCount' => 10,
                'safe' => true,
            ),
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'author_id' => 'Author',
            'thread_id' => 'Thread',
            'text' => 'Text',
            'updated' => 'Updated',
            'created' => 'Created',
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
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('thread_id', $this->thread_id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function create($text, $threadId, $authorId, $images, $raw = false)
    {
        /** @todo перенести бизнес-логику в модель формы */
        /** @todo вместо threadId может уже передаваться модель */
        $thread = MessagingThread::model()->with('threadUsers')->findByPk($threadId);

        $message = new MessagingMessage();
        if ($raw)
            $message->detachBehavior('processingImages');
        $message->author_id = $authorId;
        $message->thread_id = $threadId;
        $message->text = $text;
        $messageUsers = array();
        foreach ($thread->threadUsers as $threadUser)
        {
            $messageUser = new MessagingMessageUser();
            $messageUser->user_id = $threadUser->user_id;
            $messageUser->dtime_read = null;
            if ($authorId == $threadUser->user_id)
                $messageUser->dtime_read = new CDbExpression('NOW()');
            $messageUsers[] = $messageUser;
        }
        $message->messageUsers = $messageUsers;
        $attaches = array();
        foreach ($images as $imageId)
        {
            $attach = new AttachPhoto();
            $attach->photo_id = $imageId;
            $attach->entity = 'MessagingMessage';
            $attaches[] = $attach;
        }
        $message->images = $attaches;
        $success = $message->withRelated->save(true, array('messageUsers', 'images'));
        if ($success)
            MessagingThread::model()->updateByPk($threadId, array('updated' => new CDbExpression('NOW()')));

        return ($success) ? $message : false;
    }

    public function getJson()
    {
        $images = array();
        foreach ($this->images as $image)
        {
            $images[] = array(
                'id' => (int) $image->photo->id,
                'preview' => $image->photo->getPreviewUrl(70, 70),
                'full' => $image->photo->getPreviewUrl(960, 627),
            );
        }

        return array(
            'id' => (int) $this->id,
            'author_id' => (int) $this->author_id,
            'text' => $this->purified->text,
            'created' => Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", ($this->created instanceof CDbExpression) ? time() : $this->created),
            'read' => (bool) $this->isReadByInterlocutor,
            'images' => $images,
        );
    }

    public function getIsReadByInterlocutor()
    {
        foreach ($this->messageUsers as $messageUser)
        {
            if ($messageUser->user_id != $this->author_id)
                return !is_null($messageUser->dtime_read);
        }
    }

    public function getPhotoCollection()
    {
        $photos = array();
        foreach ($this->images as $p)
            $photos[] = $p->photo;

        return array(
            'title' => 'Изображения к сообщению',
            'photos' => $photos,
        );
    }

    public function scopes()
    {
        $scopes = parent::scopes();

        $scopes['orderDesc'] = array(
            'order' => $this->getTableAlias(true) . '.`created` DESC',
        );

        return $scopes;
    }

    /**
     * Именованное условие с параметрами.
     * Выбирает сообщения между двумя пользователями.
     *
     * @param int $user1
     * @param int $user2
     *
     * @return MessagingMessage Для цепочки вызовов
     */
    public function between($user1, $user2)
    {
        $criteria = $this->dbCriteria;
        $alias = $this->tableAlias;

        $criteria->addCondition('`' . $alias . '`.`id` IN (SELECT mmu1.message_id FROM `messaging__messages_users` mmu1 JOIN `messaging__messages_users` mmu2 ON mmu1.message_id = mmu2.message_id WHERE mmu1.user_id = :userBetween1 AND mmu2.user_id = :userBetween2)');
        $criteria->params['userBetween1'] = $user1;
        $criteria->params['userBetween2'] = $user2;

        return $this;
    }

    /**
     * Именованное условие с параметрами.
     * Жадно загружает в связь messageUsers одну запись,
     * содержащую отношение указанного пользователя к сообщению.
     * Не мешает использовать limit, т.к. загружает только одну запись
     *
     * @param int $userId
     * @param bool $activeOnly если true, то загружает только активные сообщения (не удалённые/скрытые)
     *
     * @return MessagingMessage Для цепочки вызовов
     */
    public function withMyStats($userId, $activeOnly = true)
    {
        $criteria = $this->dbCriteria;
        $alias = $this->tableAlias;
        $criteria->together = true;

        $criteria->with['messageUsers'] = array(
            'on' => 'messageUsers.user_id = :statsUser',
        );

        $criteria->params['statsUser'] = $userId;
		
		if($activeOnly)
		{
			$criteria->addColumnCondition(array('messageUsers.dtime_delete' => null));
		}

        return $this;
    }

    /**
     * Именованное условие с параметрами.
     * Жадно загружает в связь messageUsers одну запись,
     * содержащую отношение пользователя, кому написано сообщение, к этому сообщению.
     * Не мешает использовать limit, т.к. загружает только одну запись
     *
     * @param bool $activeOnly если true, то загружает только активные сообщения (не удалённые/скрытые)
     * @param int $forUser id пользователя, от которого просматриваем
     *
     * @return MessagingMessage Для цепочки вызовов
     */
    public function withStats($activeOnly = true, $forUser = false)
    {
        $criteria = $this->dbCriteria;
        $alias = $this->getTableAlias(true);
        $criteria->together = true;

        $criteria->with['messageUsers'] = array(
            'on' => '`messageUsers`.`user_id` <> ' . $alias . '.`author_id`',
        );

		if($activeOnly)
		{
			// не надо выбирать дату удаления, т.к. берём только не удалённые
			$criteria->with['messageUsers']['select'] = array(
				'`messageUsers`.`user_id`',
				'`messageUsers`.`message_id`',
				'`messageUsers`.`dtime_read`',
			);
			// id не должно быть в списке удалённыйх сообщений этого пользователя
			$criteria->addCondition($alias . '.`id` NOT IN (SELECT `message_id` FROM `messaging__messages_users` WHERE `dtime_delete` IS NOT NULL AND `user_id` = ' . (int)$forUser . ')');
		}

        return $this;
    }

    /**
     * Именованное условие с параметрами.
     * Жадно загружает по связи все модели messageUsers, и сортирует
     * так, что отношение указанного пользователя к сообщению оказывается первым.
     *
     * @param int $userId
     * @param bool $activeOnly если true, то загружает только активные сообщения (не удалённые/скрытые)
     *
     * @return MessagingMessage Для цепочки вызовов
     */
    public function withMyStatsOnTop($userId, $activeOnly = true)
    {
        $criteria = $this->dbCriteria;
        $alias = $this->tableAlias;
        $criteria->together = true;

        $criteria->with['messageUsers'] = array(
            'order' => '(messageUsers.user_id = :statsUser) DESC',
        );

        $criteria->params['statsUser'] = $userId;

 		if($activeOnly)
		{
			// id не должно быть в списке удалённыйх сообщений этого пользователя
			$criteria->addCondition($alias . '.`id` NOT IN (SELECT `message_id` FROM `messaging__messages_users` WHERE `dtime_delete` IS NOT NULL AND `user_id` = ' . (int)$userId . ')');
		}

       return $this;
    }

    /**
     * Именованное условие с параметрами.
     * Загружает только сообщения старше указанного времени
     *
     * @param int $date
     *
     * @return MessagingMessage Для цепочки вызовов
     */
    public function older($date = null)
    {
        $this->dateCompare($date, '<', 'older');

        return $this;
    }

    /**
     * Именованное условие с параметрами.
     * Загружает только сообщения новее указанного времени
     *
     * @param int $date
     *
     * @return MessagingMessage Для цепочки вызовов
     */
    public function newer($date = null)
    {
        $this->dateCompare($date, '>', 'newer');

        return $this;
    }

    protected function dateCompare($date, $sign, $param)
    {
        if ($date === null)
            return $this;

        $criteria = $this->dbCriteria;
        $alias = $this->tableAlias;

        if (is_int($date)) {
            $criteria->addCondition('`' . $alias . '`.`created` ' . $sign . ' FROM_UNIXTIME(:older)');
        } else {
            $criteria->addCondition('`' . $alias . '`.`created` ' . $sign . ' :' . $param);
        }

        $criteria->params[$param] = $date;

        return $this;
    }
    
    /**
     * Параметризованный scope, выбирает все непрочитанные сообщения,
     * начиная с сообщения с указанным id и раньше
     * @param int $messageId
     * @param int $from id пользователя от кторого сообщение
     * @param int $to id пользователя для которого сообщение (кто читает)
     */
    public function forMarkAsReaded($messageId, $from, $to)
    {
        $this->withMyStats($to);
        $this->dbCriteria->compare($this->tableAlias . '.`id`', '<=' . (int) $messageId);
        $this->dbCriteria->addColumnCondition(array(
            '`messageUsers`.`dtime_read`' => NULL,
            $this->tableAlias . '.`author_id`' => $from,
            '`messageUsers`.`user_id`' => $to,
        ));
        
        return $this;
    }

}