<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 06/03/14
 * Time: 17:06
 * To change this template use File | Settings | File Templates.
 */

class CommunityQuestionWidget extends CWidget
{
    public $forumId;

    public function run()
    {
        if ($this->forumId == 2) {
            $model = new CommunityQuestionForm();
            $this->render('CommunityQuestionWidget', compact('model'));
       if (Yii::app()->clientScript->useAMD)
           Yii::app()->clientScript->registerAMD('FormScript#focus', array('ko' => 'knockout', '$' => 'jquery', 'waitUntilExists' => 'waitUntilExistsRe'), "

                $.fn.waitUntilExists = waitUntilExists;

                $('#question-form').waitUntilExists(function () {
                  var CommunityQuestion = function() {
                     var self = this;
                     self.title = ko.observable('');
                  }
                  var model = new CommunityQuestion();
                  ko.applyBindings(model, document.getElementById('question-form'));
                });

           ");
       else
           Yii::app()->clientScript
               ->registerCoreScript('jquery', 'knockout')
               ->registerScript('FormScript#focus', "
                   var CommunityQuestion = function() {
                       var self = this;
                       self.title = ko.observable('');
                   }

                   $(function() {
                       var model = new CommunityQuestion();
                       ko.applyBindings(model, document.getElementById('question-form'));
                   });
           ");
        }
    }
}