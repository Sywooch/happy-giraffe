<?php
/**
 * Class AjaxSimpleController
 *
 * Собраны различные действия, которые должны быстро отрабатывать через ajax
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class AjaxSimpleController extends CController
{
    /**
     * Учет кликов комментаторов по кнопкам лайков Facebook и Vk
     * @throws CHttpException
     */
    public function actionCommentatorLike()
    {
        if (!Yii::app()->request->isAjaxRequest
            || Yii::app()->user->isGuest
            || Yii::app()->user->model->group == UserGroup::USER
            || !Yii::app()->user->checkAccess('commentator_panel')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $entity = Yii::app()->request->getPost('entity');
        $entity_id = Yii::app()->request->getPost('entity_id');
        $social_id = Yii::app()->request->getPost('social_id');

        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.seo.modules.commentators.models.*');
        Yii::import('site.seo.models.*');
        CommentatorLike::addCurrentUserLike($entity, $entity_id, $social_id);
    }

    public function actionTest()
    {
        $sites = Yii::app()->db_seo->createCommand()
            ->select('url, password')
            ->from('li_sites')
            ->where('type=2 and visits > 1000')
            ->queryAll();

        echo 'Mail.ru - доступ открыт для первой тысячи<br>';
        foreach($sites as $site){
            echo $site['url'].'<br>';
        }
        echo '<br><br>';
    }
}