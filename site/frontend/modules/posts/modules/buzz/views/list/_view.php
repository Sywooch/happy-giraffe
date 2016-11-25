<?php
Yii::app()->clientScript->registerAMD('kow', array('kow'));
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
    /** @todo Исправить класс при конвертации */
    'entity' => $data->originService == 'oldBlog' ? 'BlogContent' : $data->originEntity,
    'entity_id' => $data->originEntityId,
)));
?>
<article class="b-article clearfix b-article__list margin-t0<?= $data->templateObject->getAttr('type') == 'status' ? ' b-article__user-status' : '' ?>">
    <div class="b-article_cont clearfix">
        <div class="b-article_header clearfix">
            <div class="float-l">
                <?php $this->widget('site\frontend\modules\posts\widgets\author\AuthorWidget', array('post' => $data)); ?>
            </div>
            <div class="icons-meta">
                <div class="c-list_item_btn">
                    <span class="c-list_item_btn__view"><?=Yii::app()->getModule('analytics')->visitsManager->getVisits($data->url)?></span>
                    <a href="<?=$data->commentsUrl?>" class="c-list_item_btn__comment"><?=$comments->count?></a>
                </div>
            </div>
        </div>
        <?php if (!$data->templateObject->getAttr('hideTitle', false)) { ?>
            <div class="b-article_t-list"><a href="<?= $data->parsedUrl ?>" class="b-article_t-a"><?= $data->title ?></a></div>
        <?php } ?>
        <?php if ($geo = $data->templateObject->getAttr('geo', false)) { ?>
            <geo-morning params='<?= CJSON::encode($geo) ?>'><span>Где:</span><img src="<?= $geo['locationImage'] ?>" alt="<?= $geo['location'] ?>"></geo-morning>
        <?php } ?>
        <?php if ($data->templateObject->getAttr('noWysiwyg', false)) { ?>
            <?= $data->preview ?>
        <?php } else { ?>
            <div class="b-article_in clearfix"><div class="wysiwyg-content clearfix"><?= $data->preview ?></div></div>
        <?php } ?>
        <div class="b-article_like clearfix">

            <?php
            if (\Yii::app()->user->checkAccess('managePost', array('entity' => $data))) {
                $this->widget('site\frontend\modules\posts\widgets\PostSettingsWidget', array('model' => $data, 'manageInfo' => $data->originManageInfoObject->toJSON()));
            }
            ?>
            <div class="article-also">
                <div class="article-also_row like-control-hold">
                </div>
            </div>
        </div>

        <div class="b-article_share">
            <share-buttons params="url: '<?=$data->url?>'"></share-buttons>
        </div>
    </div>
</article>