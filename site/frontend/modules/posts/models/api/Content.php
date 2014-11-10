<?php

namespace site\frontend\modules\posts\models\api;

/**
 * Description of Content
 *
 * @author Кирилл
 */
class Content extends \site\frontend\components\api\models\ApiModel
{

    public $api = 'posts';

    /**
     * @param string $className
     * @return \site\frontend\modules\posts\models\api\Content
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        return array(
            'id',
            'url',
            'authorId',
            'title',
            'text',
            'html',
            'preview',
            'labels',
            'dtimeCreate',
            'dtimeUpdate',
            'dtimePublication',
            'originService',
            'originEntity',
            'originEntityId',
            'originManageInfo',
            'isDraft',
            'uniqueIndex',
            'isNoindex',
            'isNofollow',
            'isAutoMeta',
            'isAutoSocial',
            'isRemoved',
            'meta',
            'social',
            'template',
        );
    }

    public function actionAttributes()
    {
        return array(
            'insert' => array(
                'url',
                'authorId',
                'title',
                'text',
                'html',
                'preview',
                'labels',
                'originService',
                'originEntity',
                'originEntityId',
                'originManageInfo',
                'isDraft',
                'isNoindex',
                'isNofollow',
                'meta',
                'social',
                'template',
            ),
            'update' => array(
                'id',
                'url',
                'authorId',
                'title',
                'text',
                'html',
                'preview',
                'labels',
                'originService',
                'originEntity',
                'originEntityId',
                'originManageInfo',
                'isDraft',
                'isNoindex',
                'isNofollow',
                'meta',
                'social',
                'template',
            ),
            'remove' => array(
                'id',
            ),
            'restore' => array(
                'id',
            ),
        );
    }

}

?>
