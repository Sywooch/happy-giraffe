<?php

class FavouritesModule extends CWebModule
{
    public $entities = array(
        'post' => array(
            'class' => 'CommunityContent',
            'criteria' => array(
                'join' => 'INNER JOIN community__contents c ON c.id = t.entity_id',
                'condition' => 'type_id = 1',
            ),
            'relatedModelCriteria' => array(
                'scopes' => array('full'),
            ),
        ),
        'video' => array(
            'class' => 'CommunityContent',
            'criteria' => array(
                'join' => 'INNER JOIN community__contents c ON c.id = t.entity_id',
                'condition' => 'type_id = 2',
            ),
            'relatedModelCriteria' => array(
                'scopes' => array('full'),
            ),
        ),
        'recipe' => array(
            'class' => 'CookRecipe',
        ),
        'photo' => array(
            'class' => 'AlbumPhoto',
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