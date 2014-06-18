<?php

namespace site\frontend\modules\notifications\models;

/**
 * Description of Notification
 *
 * @author Кирилл
 */
class Notification extends \EMongoDocument
{

    const USER_CONTENT_COMMENT = 0;
    const REPLY_COMMENT = 1;
    const DISCUSS_CONTINUE = 2;
    const NEW_LIKE = 5;
    const NEW_FAVOURITE = 6;
    const NEW_REPOST = 7;

    public $type;
    public $userId;
    public $dtimeUpdate;
    public $unreadCount = 0;
    public $readCount = 0;
    public $unreadEntities;
    public $readEntities;

    public function embeddedDocuments()
    {
        return array(
            'entity' => 'Entity',
        );
    }

    public function behaviors()
    {
        return array(
            'embededUnreadEntities' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'unreadEntities',
                'arrayDocClassName' => 'Entity'
            ),
            'embededReadEntities' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'readEntities',
                'arrayDocClassName' => 'Entity'
            ),
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'signals';
    }

    public static function getUnreadCount()
    {
        return 0;
    }

}

?>
