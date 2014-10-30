<?php

namespace site\frontend\modules\posts\controllers;

use site\frontend\modules\posts\models\Content;

/**
 * Description of ListController
 *
 * @author Кирилл
 */
class ListController extends \PersonalAreaController
{

    public $litePackage = 'posts';
    public $listDataProvider = null;

    public function getListDataProvider($authorId)
    {
        return new \CActiveDataProvider(Content::model()->byEntityClass('CommunityContent')->byAuthor($authorId), array(
            'pagination' => array(
                'pageSize' => 10,
                'pageVar' => 'BlogContent_page',
            )
        ));
    }

    public function actionIndex($user_id)
    {
        $this->listDataProvider = $this->getListDataProvider($user_id);
        $this->ownerId = $user_id;
        $this->render('list');
    }

}

?>
