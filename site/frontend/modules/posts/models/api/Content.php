<?php

namespace site\frontend\modules\posts\models\api;

/**
 * Description of Content
 *
 * @author Кирилл
 * 
 * @property string $id
 * @property string $url
 * @property string $authorId
 * @property string $title
 * @property string $text
 * @property string $html
 * @property string $preview
 * @property string $labels
 * @property string $dtimeCreate
 * @property string $dtimeUpdate
 * @property string $dtimePublication
 * @property string $originService
 * @property string $originEntity
 * @property string $originEntityId
 * @property string $originManageInfo
 * @property integer $isDraft
 * @property integer $uniqueIndex
 * @property integer $isNoindex
 * @property integer $isNofollow
 * @property integer $isAutoMeta
 * @property integer $isAutoSocial
 * @property integer $isRemoved
 * @property string $meta
 * @property string $social
 * @property string $template
 */
class Content extends \site\frontend\components\api\models\ApiModel
{

    public $api = 'posts';
    protected $_relatedModels = array();

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
                'dtimeCreate',
                'dtimeUpdate',
                'dtimePublication',
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
                'scenario',
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
