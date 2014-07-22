<?php
/**
 * Author: choo
 * Date: 28.03.2012
 */
class BlogContent extends CommunityContent
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => ($alias) ? $alias . '.removed = 0' : 'removed = 0',
        );
    }

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    public function getEntityName()
    {
        return get_parent_class();
    }
}
