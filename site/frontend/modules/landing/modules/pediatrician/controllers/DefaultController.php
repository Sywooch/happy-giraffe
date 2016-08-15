<?php

namespace site\frontend\modules\landing\modules\pediatrician\controllers;

use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaCategory;
/**
 * @author Sergey Gubarev
 */
class DefaultController extends \LiteController
{

   /**
    * @var string
    */
   public $litePackage = 'contest_commentator';

   //-----------------------------------------------------------------------------------------------------------

   public function actionIndex()
   {
       $question = clone QaQuestion::model();

       $objCategoty = QaCategory::model();
       $question
        ->category($objCategoty::PEDIATRICIAN_ID)
        ->orderDesc()
       ;

       $dp = new \CActiveDataProvider($question, array(
           'pagination' => array(
               'pageVar' => 'page',
           ),
       ));

       $this->render('index', ['dp' => $dp, 'categories' => QaCategory::model()->findAll()]);

   }

}