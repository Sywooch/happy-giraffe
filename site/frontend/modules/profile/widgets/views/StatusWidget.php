<?php
/**
 * @var $this StatusWidget
 * @var $data BlogContent
 * @var $full bool
 */
$data = $this->last_status;
$status = $data->getStatus();
$text = strip_tags($status->text);
?>
<div class="b-user-status">
    <div class=" clearfix">
        <div class="meta-gray">
            <a href="<?= $data->getUrl(true) ?>" class="meta-gray_comment">
                <span class="ico-comment ico-comment__gray"></span>
                <span class="meta-gray_tx"><?=$data->getUnknownClassCommentsCount() ?></span>
            </a>
            <div class="meta-gray_view">
                <span class="ico-view ico-view__gray"></span>
                <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($data->getUrl())?></span>
            </div>
        </div>
        <div class="float-l">
            <span class="font-smallest color-gray"><?=HDate::GetFormattedTime($data->created)?></span>
        </div>
    </div>

    <div class="b-user-status_hold clearfix">
        <a href="<?=$data->getUrl() ?>" class="b-user-status_hold-a"><?=$text ?></a>

        <?php if ($status->mood): ?>
            <div class="textalign-r clearfix">
                <div class="b-user-mood">
                    <div class="b-user-mood_hold">
                        <div class="b-user-mood_tx">Мое настроение -</div>
                    </div>
                    <div class="b-user-mood_img">
                        <img src="/images/widget/mood/<?=$status->mood_id?>.png">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->isMyProfile):?>
            <div class="article-settings">
                <div class="article-settings_i">
                    <a href="javascript:;" class="article-settings_a article-settings_a__settings powertip" onclick="$(this).parent().next().slideToggle(300);"></a>
                </div>
                <div class="article-settings_hold" style="display: none;">
                    <div class="article-settings_i">
                        <a href="<?=Yii::app()->createUrl('/blog/default/form', array('type' => 5))?>" class="article-settings_a article-settings_a__add powertip fancy-top" title="Новый статус"></a>
                    </div>
                    <div class="article-settings_i">
                        <a href="<?=Yii::app()->createUrl('/blog/default/form', array('id' => $data->id))?>" class="article-settings_a article-settings_a__edit powertip fancy-top" title="Редактировать"></a>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
