<?php

namespace site\frontend\modules\chat\models;

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
            'HTimestampBehavior' => [
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'created_at',
            ],
        ];
    }

    public function indexes()
    {
        return [

        ];
    }

//    public function create($message, $level, $tag, $userId)
//    {
//        $model = new self;
//
//        $model->message = $message;
//        $model->level = $level;
//        $model->time = new \MongoDate(time());
//        $model->tag = $tag;
//        $model->userId = (int)$userId;
//
//        if ($model->save()) {
//            return $model;
//        } else {
//            throw new ApiException($model->getErrors(), 500);
//        }
//    }
}
