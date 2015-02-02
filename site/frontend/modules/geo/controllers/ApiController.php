<?php
/**
 * @author Никита
 * @date 27/12/14
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionCountriesList()
    {
        $countries = GeoCountry::model()->findAll();
        $this->data = $countries;
        $this->success = true;
    }

    public function actionSearchCities($term, $pageLimit = 10, $page = 1, $countryId = null, $regionId = null)
    {
        $filter_parts = FilterParts::model()->findAll();
        foreach ($filter_parts as $filter_part)
            $term = str_replace($filter_part->part . ' ', '', $term);
        $term = trim($term);

        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.name', $term);
        if ($countryId !== null)
            $criteria->compare('t.country_id', $countryId);

        if ($regionId !== null)
            $criteria->compare('t.region_id', $regionId);

        $countCriteria = clone $criteria;

        $criteria->limit = $pageLimit;
        $criteria->offset = $pageLimit * ($page - 1);
        $criteria->with = array(
            'district',
            'region',
        );
        $criteria->order = "pos, t.type = 'г' DESC, CASE WHEN t.name like CONCAT(:name, ' %') THEN 0
                WHEN t.name LIKE CONCAT(:name, '%') THEN 1
                WHEN t.name LIKE CONCAT('% ', :name, '%') THEN 2
                ELSE 3
            END, t.name";
        $criteria->params[':name'] = $term;

        $cities = GeoCity::model()->findAll($criteria);

        $more = ($pageLimit * $page) < GeoCity::model()->count($countCriteria);

        $this->data = compact('cities', 'more');
        $this->success = true;
    }
} 