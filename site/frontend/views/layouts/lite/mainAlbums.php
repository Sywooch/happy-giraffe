<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');
?>

<?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
    <div class="layout-header">
        <div class="layout-loose_hold clearfix">
            <!-- b-main -->
            <div class="b-main clearfix">
                <div class="notice-header clearfix notice-header--dialog">
                    <div class="notice-header__item notice-header__item--left">
                        <div class="notice-header__title">Фото</div>
                    </div>
                    <div class="notice-header__item notice-header__item--right"><a href="javascript:history.back();" class="notice-header__ico-close i-close i-close--sm"></a></div>
                </div>
                <?= $content ?>
            </div>
            <!-- b-main -->
        </div>
    </div>
<?php $this->endContent(); ?>