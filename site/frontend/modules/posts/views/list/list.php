<?php
/**
 * @var \site\frontend\modules\posts\controllers\ListController $this
 */
$this->pageTitle = 'Блог - ' . $this->user->fullName;
$this->metaNoindex = true;
$this->breadcrumbs = array(
    'Блог',
);
?>

<?php $this->widget('site\frontend\modules\userProfile\widgets\UserSectionWidget', array('user' => $this->owner)); ?>

<div class="b-main_cont">
    <?php if ($this->listDataProvider->totalItemCount == 0 && $this->getUser()->id == Yii::app()->user->id): ?>
        <div class="section-empty section-empty__blog">
            <div class="section-empty_t">Что бы вы хотели добавить в свой блог</div>
            <ul class="section-empty_ul">
                <li class="section-empty_li"><a href="<?=$this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_POST, 'useAMD' => true)) ?>" data-theme="transparent" class="section-empty_i fancy">
                        <div class="section-empty_ico section-empty_ico__blog"></div>
                        <div class="section-empty_ico-tx">Запись</div></a></li>
                <li class="section-empty_li"><a href="<?=$this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_PHOTO_POST, 'useAMD' => true)) ?>" data-theme="transparent" class="section-empty_i fancy">
                        <div class="section-empty_ico section-empty_ico__photo"></div>
                        <div class="section-empty_ico-tx">Фотопост</div></a></li>
                <li class="section-empty_li"><a href="<?=$this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_VIDEO, 'useAMD' => true)) ?>" data-theme="transparent" class="section-empty_i fancy">
                        <div class="section-empty_ico section-empty_ico__video"></div>
                        <div class="section-empty_ico-tx">Видео </div></a></li>
                <li class="section-empty_li"><a href="<?=$this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_STATUS, 'useAMD' => true)) ?>" data-theme="transparent" class="section-empty_i fancy">
                        <div class="section-empty_ico section-empty_ico__status"></div>
                        <div class="section-empty_ico-tx">Статус</div></a></li>
            </ul>
            <div class="section-empty_desc-hold">
                <div class="section-empty_desc">
                    <div class="section-empty_desc-tx">Добавляйте записи в свой блог и получайте баллы в свою личную копилку успехов! Скрасте записи фотографиями, видео, ссылками и делитесь ими с друзьями.</div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="b-main_col-hold clearfix">
            <?php
            $this->widget('LiteListView', array(
                'dataProvider' => $this->listDataProvider,
                'itemView' => '_view',
                'tagName' => 'div',
                'htmlOptions' => array(
                    'class' => 'b-main_col-article'
                ),
                'itemsTagName' => 'div',
                'template' => '{items}<div class="yiipagination yiipagination__center">{pager}</div>',
//                'pager' => array(
//                    'class' => 'LitePager',
//                    'maxButtonCount' => 10,
//                    'prevPageLabel' => '&nbsp;',
//                    'nextPageLabel' => '&nbsp;',
//                    'showPrevNext' => true,
//                ),
            ));
            ?>
            <aside class="b-main_col-sidebar visible-md"></aside>
        </div>
    <?php endif; ?>
</div>