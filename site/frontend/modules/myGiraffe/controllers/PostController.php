<?php

/**
 * Description of PostController
 *
 * @author Кирилл
 */
class PostController extends \site\frontend\modules\posts\controllers\ListController
{

    public $layout = 'site.frontend.modules.posts.views.layouts.newBlogPost';
    public $hideUserAdd = true;

    public function getListDataProvider($userId)
    {
        return \NewSubscribeDataProvider::getDataProvider($userId);
    }

    public function actionIndex()
    {
        $this->userId = Yii::app()->user->id;
        $this->listDataProvider = $this->getListDataProvider($this->userId);
        $this->render('list');
    }

}

?>
