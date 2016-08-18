<?php
/**
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
            <a href="<?=$data->url?>" class="box-header__link"><?=$data->title?></a>
            <p class="box-header__text"><?=\site\common\helpers\HStr::truncate($data->text, 150)?></p>
        </div>
        <div class="box-wrapper__footer box-footer">
            <a href="<?=$this->createUrl('/som/qa/default/index/', ['categoryId' => $data->category->id])?>" class="box-footer__cat"><?=$data->category->title?></a>
            <a href="<?=$data->url?>" class="box-footer__answer box-footer__answer_green"><span class="box-footer__descr">Ответить</span></a>
        </div>
    </div>
    <div class="box-wrapper__answer answer-wrapper">
        <a href="<?=$data->url?>" class="answer-wrapper__box answer-wrapper__box_green">
            <span class="answer-wrapper__descr answer-wrapper__descr-inline">ответить</span>
        </a>
    </div>
</li>