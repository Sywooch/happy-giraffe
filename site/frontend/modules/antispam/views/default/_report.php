<?php
/**
 * @var HController $this
 * @var AntispamReport $data
 */
?>

<li class="antispam-user_li">
    <div class="antispam-user_hold">
        <div class="b-user b-user__w300 b-user__va-m">
            <div class="b-user_ava">
                <?php $this->widget('site.frontend.widgets.userAvatarWidget.Avatar', array('user' => $data->user, 'size' => 40)); ?>
            </div>
            <div class="b-user_hold">
                <div class="b-user_row"><a class="b-user_name" href="<?=$data->user->getUrl()?>"><?=$data->user->getFullName()?></a></div>
            </div>
        </div>
        <div class="antispam-user_date"><?=HDate::GetFormattedTime($data->created)?></div>
        <div class="antispam-user_post-ico antispam-user_post-ico__<?=$data->data->getIconClass()?>"></div>
        <div class="antispam-user_count">
            <div class="antispam-user_count-big"><?=$data->data->maxCount?> за <?=sprintf('%02d:%02d:%02d', ($data->data->actualInterval/3600),($data->data->actualInterval/60%60), $data->data->actualInterval%60)?></div>
            <div class="antispam-user_count-s"><?=$data->data->maxCount?> за <?=sprintf('%02d:%02d:%02d', ($data->data->interval/3600),($data->data->interval/60%60), $data->data->interval%60)?></div>
        </div>
        <div class="verticalalign-el">
            <div class="margin-b5"><a class="btn-green btn-m" onclick="markReport(<?=$data->id?>, $(this).parents('.antispam-user_li'))">
                    <div class="ico-btn-check"></div>Хорошо</a></div><a class="btn-red btn-m" href="<?=$data->data->getAnalysisUrl()?>">Анализ</a>
        </div>
    </div>
</li>