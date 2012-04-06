<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class CommunitiesWidget extends CWidget
{
    public function run()
    {
        $categories = array(
            'Дети' => array(
                'items' => array(
                    'Беременность и роды' => 3,
                    'Дети до года' => 4,
                    'Дети старше года' => 4,
                    'Дошкольники' => 3,
                    'Школьники' => 4
                ),
                'css' => 'kids',
            ),
            'Мужчина & Женщина' => array('css' => 'manwoman', 'count' => 2),
            'Красота и здоровье' => array('css' => 'beauty', 'count' => 3),
            'Дом' => array('css' => 'home', 'count' => 5),
            'Интересы и увлечения' => array('css' => 'hobbies', 'count' => 4),
            'Отдых' => array('css' => 'rest', 'count' => 4),
        );
        $communities = Community::model()->public()->findAll();

        $this->render('CommunitiesWidget', compact('categories', 'communities'));
    }
}