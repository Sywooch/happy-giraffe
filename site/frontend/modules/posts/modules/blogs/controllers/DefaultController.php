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
     * @param string $tab
     */
    public function actionIndex($tab = NULL)
    {
        $feedWidget = $this->createWidget('site\frontend\modules\posts\modules\blogs\widgets\feed\FeedWidget', [
            'tab' => $tab,
        ]);
        
        $this->render('index', compact('feedWidget'));
    }
    
}