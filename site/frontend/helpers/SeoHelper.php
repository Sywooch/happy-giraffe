<?php
/**
 * Author: alexk984
 * Date: 15.05.12
 */
class SeoHelper
{
    public static function getLinkBock($model)
    {
        Yii::import('site.seo.models.*');
        $criteria = new CDbCriteria;
        $criteria->compare('entity', get_class($model));
        $criteria->compare('entity_id', $model->primaryKey);
        $page = LinkingPages::model()->find($criteria);
        if (!empty($page) && !empty($page->linkingTo)){
            foreach($page->linkingTo as $link_page){
                echo CHtml::link($link_page->keyword->name, $link_page->linktoPage->url);
            }
        }
    }
}