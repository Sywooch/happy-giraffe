<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/12/13
 * Time: 11:47 AM
 * To change this template use File | Settings | File Templates.
 */
class RecipeController extends MController
{
    public $section;
    public $modelName;

    public function init()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        parent::init();
    }

    protected function beforeAction($action)
    {
        if (isset($this->actionParams['section']) && isset(CookRecipe::model()->sectionsMap[$this->actionParams['section']])) {
            $this->modelName = CookRecipe::model()->sectionsMap[$this->actionParams['section']];
            $this->section = $this->actionParams['section'];
        } else {
            $this->modelName = CookRecipe::model()->sectionsMap[CookRecipe::COOK_DEFAULT_SECTION];
            $this->section = null;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex($type = 0, $section = null)
    {
        $dp = CActiveRecord::model($this->modelName)->getByType($type, 3);

        $this->render('index', compact('dp'));
    }

    public function actionView($id, $section)
    {
        $recipe = CActiveRecord::model($this->modelName)->active()->with(array(
            'photo',
            'attachPhotos',
            'cuisine',
            'ingredients' => array(
                'order' => 'ingredients.id',
                'with' => array(
                    'ingredient',
                    'unit',
                )
            ),
            'author',
            'commentsCount'
        ))->findByPk($id);

        $next = CActiveRecord::model($this->modelName)->findAll(array(
                'condition' => 't.id < :current_id AND type = :type AND section = :section',
                'params' => array(':current_id' => $recipe->id, ':type' => $recipe->type, ':section' => $recipe->section),
                'limit' => 2,
                'order' => 't.id DESC',
                'scopes' => array('active'),
            )
        );

        $this->render('view', compact('recipe', 'next'));
    }
}
