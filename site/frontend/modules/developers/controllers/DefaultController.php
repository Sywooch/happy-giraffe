<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

	public function actionChangeIdentity($userId = null)
	{
        if ($userId !== null) {
            $identity = new DevelopesUserIdentity($userId);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity);
                $this->redirect(array('/site/index'));
            } else {
                echo $identity->errorMessage;
            }
        }

		$this->render('index');
	}

    public function actionTestWeekly($date = null)
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.messaging.models.*');
        Yii::import('site.frontend.modules.messaging.components.*');
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.frontend.widgets.userAvatarWidget.Avatar');
        Yii::import('site.common.models.mongo.*');

        $articles = Favourites::model()->getWeekPosts($date);
        if (empty($articles))
            $articles = CommunityContent::model()->findAll(array(
                'limit' => 6,
                'order' => 'id DESC',
            ));
        $contents = $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews') . '.php', array('models' => $articles), true);

        Yii::app()->email->sendCampaign($contents, HEmailSender::LIST_TEST_LIST);
    }
}