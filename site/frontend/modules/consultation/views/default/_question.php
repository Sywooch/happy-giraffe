<?php
/**
 * @var \site\frontend\modules\consultation\models\ConsultationQuestion $data
 */
?>

<div class="b-consult-qa-ms">
    <div class="b-consult-qa-ms__question comments_li__lilac">
        <div class="b-consult-qa-ms__img">
          <a href="<?=$data->user->profileUrl?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="<?=$data->user->fullName?>" src="<?=$data->user->avatarUrl?>" class="ava_img"></a>
        </div>
        <div class="b-consult-qa-mst"><a href="<?=$data->user->profileUrl?>" class="b-consult-qa-ms__name"><?=$data->user->fullName?></a>
            <?=HHtml::timeTag($data, array('class' => 'tx-date'), null) ?>
            <div class="b-consult-qa-ms__message comments_cont">
                <a href="<?=$data->getUrl()?>" class="b-consult-qa-ms__message__title"><?=$data->title?></a>
                <div class="b-consult-qa-ms__message__text"><?=$data->text?></div>
            </div>
          <?php if ($data->answer === null && Yii::app()->user->checkAccess('manageOwnContent', array('entity' => $data))): ?>
              <a class="margin-t3 display-b" href="<?=$this->createUrl('create', array('slug' => $this->consultation->slug, 'questionId' => $data->id))?>">Редактировать</a>
          <?php endif; ?>
        </div>
    </div>
    <?php if ($data->answer): ?>
    <div class="b-consult-qa-ms__answer comments_li__red">
        <div class="b-consult-qa-ms__img"><img src="<?=$data->answer->user->avatarUrl?>" alt="<?=$data->user->fullName ?>" class="ava_img"></div>
        <div class="b-consult-qa-mst"><a href="<?=$data->answer->user->profileUrl?>" class="b-consult-qa-ms__name"><?=$data->answer->user->fullName?></a>
            <?=HHtml::timeTag($data->answer, array('class' => 'tx-date'), null) ?>
            <div class="b-consult-qa-ms__message comments_cont">
                <div class="b-consult-qa-ms__message__text"><?=\site\common\helpers\HStr::truncate(strip_tags($data->answer->text), 500)?></div>
                <?php if (! $this->isConsultant()): ?>
                    <?php if (mb_strlen(strip_tags($data->answer->text)) > 500): ?>
                        <a href="<?=$data->answer->getUrl()?>">Читать весь ответ</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if ($this->isConsultant()): ?>
              <a class="margin-t3 display-b" href="<?=$this->createUrl('answer', array('slug' => $this->consultation->slug, 'questionId' => $data->id))?>"><?=($data->answer === null) ? 'Ответить' : 'Редактировать ответ' ?></a>
            <?php endif; ?>
        </div>

    </div>
    <?php endif; ?>

</div>
