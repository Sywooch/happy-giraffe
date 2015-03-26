<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common_menu');
?>
<?php if (!Yii::app()->user->isGuest && !($this instanceof LiteController && $this->hideUserAdd)): ?>
    <div class="b-main_cols clearfix">
        <div class="b-main_col-1">
            <div class="sidebar-search clearfix sidebar-search__big">
                <?php $this->widget('site.frontend.modules.search.widgets.YaSearchWidget'); ?>
            </div>
        </div>
        <div class="b-main_col-23">
            <!-- userAddRecord-->
            <div class="userAddRecord clearfix userAddRecord__s userAddRecord__s">
                <div class="userAddRecord_ava-hold">
                    <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => Avatar::SIZE_SMALL)); ?>
                </div>
                <div class="userAddRecord_hold">
                    <div class="userAddRecord_tx">Я хочу добавить
                    </div>
                    <a href="<?= $this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_POST, 'useAMD' => true)) ?>" data-theme="transparent" title="Статью" class="userAddRecord_ico userAddRecord_ico__article fancy powertip"></a>
                    <a href="/user/blog/photopost/create/" data-theme="transparent" title="Фото" class="userAddRecord_ico userAddRecord_ico__photo powertip"></a>
                    <a href="<?= $this->createUrl('/blog/default/form', array('type' => CommunityContent::TYPE_VIDEO, 'useAMD' => true)) ?>" data-theme="transparent" title="Видео" class="userAddRecord_ico userAddRecord_ico__video fancy powertip"></a>
                    <a href="/user/blog/status/create/" data-theme="transparent" title="Статус" class="userAddRecord_ico userAddRecord_ico__status powertip"></a>
                </div>
            </div>
            <!-- /userAddRecord-->
        </div>
    </div>
<?php endif; ?>
<div class="b-main_cont b-main_cont__broad">
    <?php if ($this->breadcrumbs): ?>
        <div class="b-crumbs b-crumbs__s">
            <div class="b-crumbs_tx">Я здесь:</div>
            <?php
            $this->widget('\site\frontend\components\lite\UserBreadcrumbs', array(
                'user' => $this->owner,
                'tagName' => 'ul',
                'separator' => ' ',
                'htmlOptions' => array('class' => 'b-crumbs_ul'),
                'homeLink' => false,
                'activeLinkTemplate' => '<li class="b-crumbs_li"><a href="{url}" class="b-crumbs_a">{label}</a></li>',
                'inactiveLinkTemplate' => '<li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">{label}</span></li>',
                'links' => $this->breadcrumbs,
                'encodeLabel' => false,
            ));
            ?>
        </div>
    <?php endif; ?>
</div>
<?=$content?>
<?php $this->endContent(); ?>