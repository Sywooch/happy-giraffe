<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 * @var site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu $consultationsMenu
 */
$this->beginContent('//layouts/lite/main');

$this->beginClip('sidebar');
foreach ($this->sidebar as $view) {
    $this->renderPartial('/_sidebar/' . $view);
}
$this->endClip();
?>

<div class="b-main clearfix">
    <div class="b-main_cont">
        <div class="b-main_col-article">
            <?=$content?>
        </div>
        <aside class="b-main_col-sidebar visible-md">
            <div class="sidebar-widget">
                <?php echo $this->clips['sidebar']; ?>
            </div>
        </aside>
    </div>
</div>
<?php $this->endContent(); ?>