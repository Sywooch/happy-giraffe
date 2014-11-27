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

    public function getListDataProvider($userId, $type)
    {
        return \NewSubscribeDataProvider::getDataProvider($userId, $type);
    }

    public function actionIndex($type)
    {
        $this->userId = Yii::app()->user->id;
        $this->listDataProvider = $this->getListDataProvider($this->userId, $type);
        $this->render('list');
    }

}

?>
