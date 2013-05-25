<?php

class FavouritesModule extends CWebModule
{
    public $entities = array(
        'post' => array(
            'class' => 'CommunityContent',
            'title' => 'Записи',
            'criteria' => array(
                'join' => 'LEFT OUTER JOIN community__contents c ON c.id = t.entity_id',
                'condition' => 'type_id = 1',
            ),
        ),
        'photo' => array(
            'class' => 'AlbumPhoto',
            'title' => 'Фото',
        ),
        'video' => array(
            'class' => 'CommunityContent',
            'title' => 'Видео',
            'criteria' => array(
                'join' => 'LEFT OUTER JOIN community__contents c ON c.id = t.entity_id',
                'condition' => 'type_id = 2',
            ),
        ),
        'cook' => array(
            'class' => 'CookRecipe',
            'title' => 'Кулинарная книга',
        ),
    );

    public $relatedModelCriteria = array(
        'CommunityContent' => array(
            'scopes' => array('full'),
        ),
        'CookRecipe' => array(
            'with' => array('tags'),
        ),
    );

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'favourites.models.*',
            'favourites.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}