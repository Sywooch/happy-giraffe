<?php
/**
 * Author: alexk984
 * Date: 15.01.13
 */
class LiSitePasswords extends EMongoDocument
{
    public $site_id;
    public $passwords = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'li_sites_passwords';
    }

    public static function addPassword($site, $password)
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('site_id', '==', (int)$site->id);

        $model = LiSitePasswords::model()->find($criteria);
        if ($model === null) {
            $model = new LiSitePasswords;
            $model->site_id = (int)$site->id;
        }
        $model->passwords [] = $password;
        $model->save();
    }

    public static function getPassword($site, $passwords)
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('site_id', '==', (int)$site->id);

        $model = LiSitePasswords::model()->find($criteria);
        if ($model === null)
            return $passwords[0];

        foreach ($passwords as $password)
            if (!in_array($password, $model->passwords))
                return $password;

        return true;
    }
}
