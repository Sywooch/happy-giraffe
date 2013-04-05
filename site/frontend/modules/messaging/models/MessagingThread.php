<?php

/**
 * This is the model class for table "messaging__threads".
 *
 * The followings are the available columns in table 'messaging__threads':
 * @property string $id
 * @property string $updated
 * @property string $created
 *
 * The followings are the available model relations:
 * @property MessagingMessages[] $messagingMessages
 */
class MessagingThread extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MessagingThread the static model class
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
        return 'messaging__threads';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('updated, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, updated,created', 'safe', 'on'=>'search'),
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
            'messages' => array(self::HAS_MANY, 'MessagingMessage', 'thread_id'),
            'threadUsers' => array(self::HAS_MANY, 'MessagingThreadUser', 'thread_id'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
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

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('updated',$this->updated,true);
        $criteria->compare('created',$this->created,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Отмечает все сообщения в диалоге как прочитанные для одного из собеседников
     *
     * @param $user_id
     */
    public function markAsReadFor($user_id)
    {
        $sql = "
            UPDATE messaging__messages_users mu
            INNER JOIN messaging__messages m ON mu.message_id = m.id
            SET mu.read = 1
            WHERE m.thread_id = :thread_id AND m.author_id != :user_id AND mu.user_id = :user_id;
        ";

        Yii::app()->db->createCommand($sql)->execute(array(
            ':thread_id' => $this->id,
            ':user_id' => $user_id,
        ));
    }

    /**
     * Отмечает последнее сообщение в диалоге как непрочитанное для одного из собеседников
     *
     * @param $user_id
     */
    public function markAsUnReadFor($user_id)
    {
        $sql = "
            UPDATE messaging__messages_users mu
            SET mu.read = 0
            WHERE mu.user_id = :user_id AND mu.message_id = (
                SELECT id
                FROM messaging__messages
                WHERE thread_id = :thread_id AND author_id != :user_id
                ORDER BY id DESC
                LIMIT 1
            );
        ";

        Yii::app()->db->createCommand($sql)->execute(array(
            ':thread_id' => $this->id,
            ':user_id' => $user_id,
        ));
    }

    public function getMessages($limit, $offset = 0)
    {
        $sql = "
            SELECT
              m.id,
              m.author_id,
              m.text, UNIX_TIMESTAMP(m.created) AS created, mu.read
            FROM messaging__messages m
            JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.user_id != m.author_id
            LIMIT :limit
            OFFSET :offset
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':limit', $limit, PDO::PARAM_INT);
        $command->bindValue(':offset', $offset, PDO::PARAM_INT);
        $rows = $command->queryAll();

        $messages = array();
        foreach ($rows as $row) {
            $messages[] = array(
                'id' => (int) $row['id'],
                'author_id' => (int) $row['author_id'],
                'text' => $row['text'],
                'created' => Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $row['created']),
                'read' => (bool) $row['read'],
            );
        }

        return $messages;
    }

    /**
     * Возвращает ID собеседника в данном диалоге
     *
     * @param $userId
     * @return mixed
     */
    public function getInterlocutorIdFor($userId)
    {
        $sql = "
            SELECT user_id
            FROM messaging__threads_users
            WHERE thread_id = :thread_id AND user_id != :user_id;
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':thread_id', $this->id, PDO::PARAM_INT);
        $command->bindValue(':user_id', $userId, PDO::PARAM_INT);

        return $command->queryScalar();
    }
}