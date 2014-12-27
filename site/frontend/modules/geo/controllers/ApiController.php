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
} 