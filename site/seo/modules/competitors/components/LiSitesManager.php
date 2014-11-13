<?php
/**
 * @author Никита
 * @date 13/11/14
 */

class LiSitesManager
{
    public static function getData()
    {
        $sites = Site::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($sites as $site) {
            echo self::getKeywordsCount($site);
            die;
        }
    }

    protected static function getKeywordsCount(Site $site)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(DISTINCT keyword_id)';
        $criteria->compare('site_id', $site->id);
        return SiteKeywordVisit::model()->count($criteria);
    }
} 