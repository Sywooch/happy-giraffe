<?php

namespace site\frontend\modules\posts\modules\blogs\controllers;

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

/**
 * @author Sergey Gubarev
 */
class AjaxController extends \HController
{
    
    /**
     * {@inheritDoc}
     * @see CController::filters()
     */
    public function filters()
    {
        return [
            'ajaxOnly'
        ]; 
    }
    
    /**
     * Данные для виджета "Блогоэфир"
     * 
     * @return string
     */
    /*
    public function actionBlogoefirItems()
    {
        $offset = \Yii::app()->request->getPost('offset');
        $limit  = $this->module->getConfig('itemsCountBlogoefir');
        
        $models = Content::model()
            ->byLabels([
                Label::LABEL_BLOG
            ])
            ->orderDesc()
            ->findAll(compact('offset', 'limit'))
        ;
        
        $itemsList = [];
        
        if (! empty($models))
        {
            foreach ($models as $model)
            {
                $itemsList[] = [
                    'avatarUrl'  => $model->user->avatarUrl,
                    'profileUrl' => $model->user->profileUrl,
                    'fullName'   => $model->user->fullName,
                    'timeTag'    => \HHtml::timeTag($model, ['class' => '']),
                    'title'      => $model->title,
                    'parsedUrl'  => $model->parsedUrl
                ];
            }
        }
        
        echo \CJSON::encode($itemsList);
    }
    */
    
    /**
     * Добавить подписку на блог юзера
     * 
     *  @return string
     */
    public function actionAddSubscribe()
    {
        $userId = (int) \Yii::app()->request->getPost('userId');
        
        $addResult = \UserBlogSubscription::add($userId);
        
        echo \CJSON::encode([
            'status' => $addResult
        ]);            
    }

    /**
     * Отписка
     */
    public function actionRemoveSubscribe()
    {
        $userId = (int)\Yii::app()->request->getPost('userId');

        $removeResult = \UserBlogSubscription::unSubscribe(\Yii::app()->user->id, $userId);

        echo \CJSON::encode([
            'status' => $removeResult
        ]);
    }
    
}