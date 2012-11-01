<?php

class StatsController extends BController
{
    public function filters()
    {
        return array(
            'ajaxOnly',
        );
    }

    public function beforeAction($action)
    {
        Yii::import('site.frontend.modules.geo.models.*');
        return true;
    }

	public function actionRegisters()
	{
        $this->renderPartial('regs');
	}

    public function actionEntities(){
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.services.modules.names.models.*');

        $this->renderPartial('stat');
    }

    public function actionLikes()
    {
        $this->renderPartial('likes');
    }

    public function actionRegions()
    {
        $this->renderPartial('regions');
    }

    public function actionInterests()
    {
        $this->renderPartial('interests');
    }

    public function actionWorkers()
    {
        $this->renderPartial('workers');
    }

    public function actionUsers()
    {
        $this->renderPartial('users');
    }

    public function actionUniqueness()
    {
        $this->renderPartial('uniqueness');
    }
}