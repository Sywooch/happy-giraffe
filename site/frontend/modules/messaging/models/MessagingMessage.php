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
 *
 * The followings are the available model relations:
 * @property Users $author
 * @property MessagingThreads $thread
 * @property Users[] $users
 */
class MessagingMessage extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MessagingMessage the static model class
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
            array('author_id, text', 'required'),
            array('updated, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, author_id, thread_id, text, updated, created', 'safe', 'on'=>'search'),
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

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('author_id',$this->author_id,true);
        $criteria->compare('thread_id',$this->thread_id,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('updated',$this->updated,true);
        $criteria->compare('created',$this->created,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function create($text, $threadId, $authorId, $images)
    {
        $thread = MessagingThread::model()->with('threadUsers')->findByPk($threadId);

        $message = new MessagingMessage();
        $message->author_id = $authorId;
        $message->thread_id = $threadId;
        $message->text = $text;
        $messageUsers = array();
        foreach ($thread->threadUsers as $threadUser) {
            $messageUser = new MessagingMessageUser();
            $messageUser->user_id = $threadUser->user_id;
            if ($authorId != $threadUser->user_id)
                $messageUser->read = 0;
            $messageUsers[] = $messageUser;
        }
        $message->messageUsers = $messageUsers;
        $attaches = array();
        foreach ($images as $imageId) {
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
        foreach ($this->images as $image) {
            $images[] = array(
                'id' => $image->photo->id,
                'preview' => $image->photo->getPreviewUrl(70, 70),
                'full' => $image->photo->getPreviewUrl(960, 627),
            );
        }

        return array(
            'id' => $this->id,
            'author_id' => $this->author_id,
            'text' => $this->text,
            'created' => Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $this->created),
            'read' => $this->isReadByInterlocutor,
            'images' => $images,
        );
    }

    public function getIsReadByInterlocutor()
    {
        foreach ($this->messageUsers as $messageUser) {
            if ($messageUser->user_id != $this->author_id)
                return $messageUser->read;
        }
    }
}