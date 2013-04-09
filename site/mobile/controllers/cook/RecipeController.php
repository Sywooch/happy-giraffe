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

        $this->pageTitle = empty($type) ? 'Кулинарные рецепты от Веселого Жирафа' : CActiveRecord::model($this->modelName)->types[$type] . ' - ' . $this->pageTitle;
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

        $next = CActiveRecord::model($this->modelName)->active()->findAll(array(
                'order' => 't.id DESC',
                'condition' => 't.id < :current_id AND type = :type AND section = :section',
                'params' => array(':current_id' => $recipe->id, ':type' => $recipe->type, ':section' => $recipe->section),
                'limit' => 3,
            )
        );

        $this->pageTitle = $recipe->title . ' - Кулинарные рецепты от Веселого Жирафа';
        $this->render('view', compact('recipe', 'next'));
    }

    public function actionTag($tag = null, $type = 0)
    {
        $dp = CActiveRecord::model($this->modelName)->getByTag($tag, $type);
        $model = $this->loadTag($tag);

        $this->pageTitle = $model->title . ' - Кулинарные рецепты от Веселого Жирафа';
        $this->render('index', compact('dp', 'model'));
    }

    public function loadTag($id)
    {
        $model = CookRecipeTag::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
