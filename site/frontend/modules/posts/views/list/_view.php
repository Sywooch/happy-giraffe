<?php
Yii::app()->clientScript->registerAMD('kow', array('kow'));
?>
<article class="b-article clearfix b-article__list<?= $data->templateObject->getAttr('type') == 'status' ? ' b-article__user-status' : '' ?>">
    <div class="b-article_cont clearfix">
        <div class="b-article_header clearfix">
            <div class="float-l">
                <!-- ava--><a href="<?= $data->user->profileUrl ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid "><span class="ico-status ico-status__online"></span><img alt="<?= $data->user->fullName ?>" src="<?= $data->user->avatarUrl ?>" class="ava_img"></a><a href="<?= $data->user->profileUrl ?>" class="b-article_author"><?= $data->user->fullName ?></a>
                <?= HHtml::timeTag($data, array('class' => 'tx-date'), null) ?>
            </div>
        </div>
        <?php if (!$data->templateObject->getAttr('hideTitle', false)) { ?>
            <div class="b-article_t-list"><a href="<?= $data->parsedUrl ?>" class="b-article_t-a"><?= $data->title ?></a></div>
        <?php } ?>
        <?php if ($data->templateObject->getAttr('noWysiwyg', false)) { ?>
            <?= $data->preview ?>
        <?php } else { ?>
            <div class="b-article_in clearfix"><div class="wysiwyg-content clearfix"><?= $data->preview ?></div></div>
        <?php } ?>
        <div class="b-article_like clearfix">

            <?php
            if (\Yii::app()->user->checkAccess('managePost', array('entity' => $data))) {
                $articleSettingsParams = array('articleId' => $data->originEntityId, 'edit' => $data->originManageInfoObject->toJSON());
                ?>
                <article-settings params='<?= \HJSON::encode($articleSettingsParams) ?>'></article-settings>
                <?php
            }
            ?>
            <div class="article-also">
                <div class="article-also_row like-control-hold">
                </div>
            </div>
        </div>
    </div>
</article>