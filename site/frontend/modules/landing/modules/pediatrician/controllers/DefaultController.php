<?php

namespace site\frontend\modules\landing\modules\pediatrician\controllers;

/**
 * @author Sergey Gubarev
 */
class DefaultController extends \LiteController
{
   
   /**
    * @var string
    */
   public $litePackage = 'landing_pediatrician';
   
   //-----------------------------------------------------------------------------------------------------------
   
   public function actionIndex()
   {
       $this->render('index');
   }
    
}