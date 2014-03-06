<?php

class DefaultController extends HController
{
    public function actionSearchCities($term, $country_id = null, $region_id = null)
    {
        $filter_parts = FilterParts::model()->findAll();
        foreach ($filter_parts as $filter_part)
            $term = str_replace($filter_part->part . ' ', '', $term);
        $term = trim($term);

        $criteria = new CDbCriteria(array(
            'limit' => 10,
            'with' => array(
                'district',
                'region',
            ),
            'order' => "CASE WHEN t.name like CONCAT(:name, ' %') THEN 0
                WHEN t.name LIKE CONCAT(:name, '%') THEN 1
                WHEN t.name LIKE CONCAT('% ', :name, '%') THEN 2
                ELSE 3
            END, t.name",
            'params' => array(':name' => $term),
        ));
        $criteria->addSearchCondition('t.name', $term);
        if ($country_id !== null)
            $criteria->compare('t.country_id', $country_id);

        if ($region_id !== null)
            $criteria->compare('t.region_id', $region_id);

        $cities = GeoCity::model()->findAll($criteria);

        $_cities = array();
        foreach ($cities as $city) {
            $_cities[] = array(
                'id' => (int) $city->id,
                'name' => $city->name,
                'type' => $city->type,
                'region' => array(
                    'name' => $city->region->name,
                ),
                'district' => ($city->district === null) ? null : array(
                    'name' => $city->district->name,
                ),
            );
        }

        echo CJSON::encode($_cities);
    }
}
