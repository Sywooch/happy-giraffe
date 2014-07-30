<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/07/14
 * Time: 11:12
 */


class DiseasesListWidget extends \AdaptiveWidget
{
    public function run()
    {
        $categories = RecipeBookDiseaseCategory::model()->findAll(array(
            'order' => 'title ASC',
        ));

        $this->render('main', compact('categories'));
    }
} 