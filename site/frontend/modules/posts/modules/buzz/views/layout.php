<?php
/**
 * @var site\frontend\modules\posts\modules\buzz\controllers\DefaultController $this
 * @var string $content
 */
$this->beginContent('//layouts/lite/main');
?>
    <div class="b-main_cont">
        <div class="b-main_col-hold clearfix">
            <?php
            echo $content;
            ?>
            <aside class="b-main_col-sidebar visible-md">
                <?php if (true): ?>
                <?php $this->widget('site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget', array(
                    'club' => $this->getClub(),
                )); ?>
                <?php endif; ?>
            </aside>
        </div>
    </div>
<?php $this->endContent(); ?>