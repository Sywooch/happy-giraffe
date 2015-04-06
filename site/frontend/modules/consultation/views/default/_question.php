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
            <?php if ($data->answer === null && Yii::app()->user->checkAccess('removeQuestions')): ?>
                <a class="margin-t3 display-b" onclick="var self = this; $.post('/api/consultation/remove/', JSON.stringify({ questionId: '<?=$data->id?>' }), function() {$(self).text('Удалено')})">Удалить</a>
            <?php endif; ?>
            <?php if ($data->answer === null): ?>
                <?php $this->renderPartial('_buttons', array('data' => $data)); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($data->answer): ?>
    <div class="b-consult-qa-ms__answer comments_li__red">
        <div class="b-consult-qa-ms__img">
            <span class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="<?=$data->answer->user->fullName?>" src="<?=$data->answer->user->avatarUrl?>" class="ava_img"></span>
        </div>
        <div class="b-consult-qa-mst"><span class="b-consult-qa-ms__name"><?=$data->answer->user->fullName?></span>
            <?=HHtml::timeTag($data->answer, array('class' => 'tx-date'), null) ?>
            <div class="b-consult-qa-ms__message comments_cont">
                <div class="b-consult-qa-ms__message__text"><?=\site\common\helpers\HStr::truncate(strip_tags($data->answer->text), 500)?></div>
                <?php if (! $this->isConsultant()): ?>
                    <?php if (mb_strlen(strip_tags($data->answer->text)) > 500): ?>
                        <a href="<?=$data->answer->getUrl()?>">Читать весь ответ</a>
                    <?php endif; ?>
                <?php endif; ?>
                <?php $this->renderPartial('_buttons', array('data' => $data)); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
