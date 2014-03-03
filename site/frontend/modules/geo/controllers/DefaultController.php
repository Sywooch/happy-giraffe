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
                'region',
            ),
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
                'label' => $city->name . ', ' . $city->region->name,
                'name' => $city->name,
                'id' => (int)$city->id,
            );
        }
        echo CJSON::encode($_cities);
    }
}
