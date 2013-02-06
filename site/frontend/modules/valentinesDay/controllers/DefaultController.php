<?php

class DefaultController extends HController
{
    protected function beforeAction($action)
    {
        Yii::app()->clientScript->registerCssFile('/stylesheets/valentine-day.css');
        return true;
    }

	public function actionIndex()
	{
        $recipe_tag = CookRecipeTag::model()->findByPk(CookRecipeTag::TAG_VALENTINE);

		$this->render('index', compact('valentinePost', 'recipe_tag'));
	}

    public function actionSms(){
        $criteria = new CDbCriteria;
        $pages = new CPagination(ValentineSms::model()->count());
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);
        $models = ValentineSms::model()->findAll($criteria);

        $this->render('sms', compact('models', 'pages'));
    }

    public function actionHowToSpend(){
        $criteria = new CDbCriteria;
        $criteria->compare('rubric.community_id', Community::COMMUNITY_VALENTINE);
        $post = CommunityContent::model()->full()->find($criteria);

        $this->render('photo_post', compact('post'));
    }
}