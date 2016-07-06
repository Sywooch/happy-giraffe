<?php

namespace site\frontend\modules\posts\modules\blogs\controllers;

/**
 * @author Sergey Gubarev
 */
class DefaultController extends \LiteController
{
    
    /**
     * @var string
     */
    public $litePackage = 'blogs-homepage';
    
    /**
     * @var boolean
     */
    public $hideUserAdd = TRUE;
    
    //-----------------------------------------------------------------------------------------------------------
    
    /**
     * {@inheritDoc}
     * @see LiteController::filters()
     */
    public function filters()
    {
        return [
            [
                'COutputCache',
                'cacheID'     => 'cache',
                'duration'    => 0,
            ]
        ];     
    }
    
    /**
     * @param NULL||string $tab
     */
    public function actionIndex($tab = NULL)
    {
        $feedWidget = $this->createWidget('site\frontend\modules\posts\modules\blogs\widgets\feed\FeedWidget', [
            'tab' => $tab,
        ]);
        
        $this->render('index', compact('feedWidget'));
    }
    
    public function actionTest()
    {
        $comet = new \CometModel;
        var_dump($comet->send(\Yii::app()->user->id, ['foo' => 'bar'], \CometModel::BLOGS_EFIR_NEW_POST));
    } 
    
}