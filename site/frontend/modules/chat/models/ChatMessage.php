<?php

namespace site\frontend\modules\chat\models;
use site\frontend\modules\chat\values\ChatMessageStatuses;

/**
 * @property int $user_id
 * @property int $chat_id
 * @property int $created_at
 * @property string $message
 * @property $status
 */
class ChatMessage extends \EMongoDocument
{
    public $user_id;
    public $chat_id;
    public $created_at;
    public $message;
    public $status;

    /**
     * @param string $className;
     * @return ChatMessage
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'chat_messages';
    }

    public function rules()
    {
        return [

        ];
    }

    public function behaviors()
    {
        return [
//            'HTimestampBehavior' => [
//                'class' => 'HTimestampBehavior',
//                'createAttribute' => 'created_at',
//            ],
        ];
    }

    public function indexes()
    {
        return [

        ];
    }

    /**
     * @param int $chatId
     * @return ChatMessage
     */
    public function byChat($chatId)
    {
        $this->getDbCriteria()->addCond('chat_id', '==', $chatId);

        return $this;
    }

    /**
     * @param int $userId
     * @return ChatMessage
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->addCond('user_id', '==', $userId);

        return $this;
    }

    /**
     * @param int $createdAt
     * @return ChatMessage
     */
    public function byCreatedAt($createdAt)
    {
        $this->getDbCriteria()->addCond('created_at', '==', $createdAt);

        return $this;
    }

    /**
     * @param string $message
     * @param int $chatId
     * @param int $userId
     *
     * @return \site\frontend\modules\chat\models\ChatMessage
     */
    public static function create($message, $chatId, $userId)
    {
        $model = new ChatMessage();

        $model->message = $message;
        $model->chat_id = $chatId;
        $model->status = ChatMessageStatuses::UNREAD;
        $model->user_id = $userId;
        $model->created_at = time();

        $model->save();

        return $model;
    }
}
