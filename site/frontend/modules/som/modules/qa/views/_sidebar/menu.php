<?php
/**
 * @var array $urlParams
 */
$consultationsMenu = $this->createWidget('site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu');

$sitebarCategoryId = array_key_exists('menu', $this->sidebar) && array_key_exists('categoryId', $this->sidebar['menu']) ? $this->sidebar['menu']['categoryId'] : false;
?>

    <div class="questions-categories">
    	<div class="personal-links">
            <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\categories\MainCategoriesMenu', array(
                'categoryId' => isset($categoryId) ? $categoryId : $sitebarCategoryId,
            )); ?>
    	</div>
    </div>

<?php if (count($consultationsMenu->items) > 0): ?>
    <div class="consult-widget">
        <div class="consult-widget_heading">Онлайн-консультации</div>
        <?php $consultationsMenu->run(); ?>
    </div>
<?php endif; ?>