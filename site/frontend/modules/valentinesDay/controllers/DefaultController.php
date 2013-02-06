<?php

class DefaultController extends HController
{
    public $body_class = ' body-gray';

    protected function beforeAction($action)
    {
        Yii::app()->clientScript->registerCssFile('/stylesheets/valentine-day.css');
        return true;
    }

	public function actionIndex()
	{
        $recipe_tag = CookRecipeTag::model()->findByPk(CookRecipeTag::TAG_VALENTINE);
        $post = $this->getPhotoPost();

		$this->render('index', compact('post', 'recipe_tag'));
	}

    public function actionVimeo()
    {
        Yii::import('application.vendor.*');
        require_once('Vimeo.php');
        $vimeo = new phpVimeo('813ec2b13845c8c85b152af462c30b1ec2437c8b', '3213eb9bb337e6ad984c65f41fe3f8565c796725');
        $vimeo->setToken('80c0a65f39e0bdaf8da9009315940d48', '5ca4f96234e977b241ba22b8ce12ebd37e15d441');
        $videos = $vimeo->call('vimeo.videos.getAll', array('user_id' => 'user16279797', 'full_response' => true));

        var_dump($videos);
    }

    public function actionSms(){
        $this->meta_title = '100 Смс о любви. Смс ко дню святого Валентина';

        $criteria = new CDbCriteria;
        $pages = new CPagination(ValentineSms::model()->count());
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $models = ValentineSms::model()->findAll($criteria);

        $this->render('sms', compact('models', 'pages'));
    }

    public function actionHowToSpend(){
        $this->meta_title = 'Как провести День святого Валентина';

        $post = $this->getPhotoPost();
        $this->render('photo_post', compact('post'));
    }

    /**
     * @return CommunityContent
     */
    public function getPhotoPost()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('rubric.community_id', Community::COMMUNITY_VALENTINE);
        return CommunityContent::model()->full()->find($criteria);
    }
}