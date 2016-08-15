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

   /**
    * @var integer
    */
   private $_pediatorCategoryId = 124;

   //-----------------------------------------------------------------------------------------------------------

   public function actionIndex()
   {
       $question = clone QaQuestion::model();
//        $objCategoty = QaCategory::model();
//        $question->category($objCategoty::);
       $question->category($this->_pediatorCategoryId);

       $dp = new \CActiveDataProvider($question, array(
           'pagination' => array(
               'pageVar' => 'page',
           ),
       ));

       $this->render('index', ['dp' => $dp]);

   }

}