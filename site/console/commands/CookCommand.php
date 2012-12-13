<?php
/**
 * Author: alexk984
 * Date: 13.12.12
 */
Yii::import('site.frontend.modules.cook.models.*');
Yii::import('site.frontend.modules.geo.models.*');

class CookCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $countries = GeoCountry::model()->findAll();
        $cuisines = CookCuisine::model()->findAll();

        foreach($countries as $country)
            foreach($cuisines as $cuisine){
                if (substr($country->name, 0, 6) == substr($cuisine->title, 0, 6)){
                    $cuisine->country_id = $country->id;
                    $cuisine->save();
                    echo '1';
                }
            }
    }
}