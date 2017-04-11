<?php
/**
 * @var \site\frontend\modules\som\modules\qa\models\QaAnswer $answer
 */
?>
<li class="pediator-answer__item clearfix margin-b15">
  <div class="pediator-answer__right_550">
    <div class="box-wrapper__user"><span class="box-wrapper__link"><?=$answer->user->getFullName()?></span>
      <?=HHtml::timeTag($answer, ['class' => 'box-wrapper__date margin-r15'])?><span class="statistik__text--green font__upper font-sx font__semi"><?= $answer->user->gender == 1 ? 'Задала' : 'Задал' ?> вопрос</span>
    </div>
<<<<<<< HEAD
    <div class="answers-list_item_text-block_text-mod margin-b5">
      <?=$answer->text?>
=======
    <div class="answers-list_item_text-block_text-mod margin-b5" data-bind="html: additionalAnswerText()">
      <?=\site\common\helpers\HStr::truncate($answer->text, 150)?>
>>>>>>> develop
    </div>
  </div>
</li>