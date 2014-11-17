<?php

use site\frontend\modules\posts\models\Content;

/**
 * Description of PostController
 *
 * @author Кирилл
 */
class PostController extends \site\frontend\modules\posts\controllers\ListController
{

    public $layout = '//layouts/lite/main';
    public $hideUserAdd = true;

    public function getListDataProvider($authorId)
    {
        return new \CActiveDataProvider(Content::model()->orderDesc(), array(
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'BlogContent_page',
            )
        ));
    }

    public function actionIndex()
    {
        $this->userId = Yii::app()->user->id;
        $this->listDataProvider = $this->getListDataProvider($this->userId);
        $this->render('list');
    }

}

?>
