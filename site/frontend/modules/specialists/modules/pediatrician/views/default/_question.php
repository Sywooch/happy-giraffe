<?php
/**
 * @var \site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController $this
 * @var \site\frontend\modules\som\modules\qa\models\QaQuestion $data
 */
?>

<li class="questions_item clearfix">
    <div class="questions-modification__box questions-modification__box-w480 box-wrapper">
        <div class="box-wrapper__user box-wrapper__user-mod">
            <a href="<?=$data->user->profileUrl?>" class="box-wrapper__link"><?=$data->user->getFullName()?></a>
            <?=HHtml::timeTag($data, ['class' => 'box-wrapper__date'])?>
        </div>
        <div class="box-wrapper__header box-header">
            <a href="<?=$this->createUrl('/specialists/pediatrician/default/answer', ['questionId' => $data->id])?>" class="box-header__link"><?=$data->title?></a>
            <p class="box-header__text"><?=\site\common\helpers\HStr::truncate(strip_tags($data->text), 150)?></p>
        </div>
        <div class="box-wrapper__footer box-footer">
            <?php if ($data->tag): ?>
                <a href="<?=$this->createUrl('/som/qa/default/index/', ['categoryId' => $data->tag->id])?>" class="box-footer__cat"><?=$data->tag->name?></a>
            <?php endif; ?>
            <a href="<?=$this->createUrl('/specialists/pediatrician/default/answer', ['questionId' => $data->id])?>" class="box-footer__answer box-footer__answer_green"><span class="box-footer__descr">Ответить</span></a>
        </div>
    </div>
    <div class="box-wrapper__answer answer-wrapper">
        <a href="<?=$this->createUrl('/specialists/pediatrician/default/answer', ['questionId' => $data->id])?>" class="answer-wrapper__box answer-wrapper__box_green">
            <span class="answer-wrapper__descr answer-wrapper__descr-inline">ответить</span>
        </a>
    </div>
</li>