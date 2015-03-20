<?php

namespace site\frontend\modules\som\modules\community\models\api;

/**
 * Description of Label
 *
 * @author Кирилл
 */
class Label extends \site\frontend\components\api\models\ApiModel
{

    public $api = 'community';

    /**
     * @param string $className
     * @return \site\frontend\modules\som\modules\community\models\api\Label
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeNames()
    {
        return array(
            'id',
            'text',
        );
    }

    public static function findByForum($forumId)
    {
        return self::model()->query('getLabels', array('forumId' => $forumId));
    }
    
    public function findForBlog()
    {
        return $this->query('getLabels', array('blog' => true));
    }

}
