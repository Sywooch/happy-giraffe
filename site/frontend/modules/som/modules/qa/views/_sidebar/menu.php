<?php
/**
 * @var array $urlParams
 */
$consultationsMenu = $this->createWidget('site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu');
?>

    <div class="questions-categories">
        <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\categories\MainCategoriesMenu', array(
            'categoryId' => isset($categoryId) ? $categoryId : $this->sidebar['menu']['categoryId'],
        )); ?>
    </div>

<?php if (count($consultationsMenu->items) > 0): ?>
    <div class="consult-widget">
        <div class="consult-widget_heading">Онлайн-консультации</div>
        <?php $consultationsMenu->run(); ?>
    </div>
<?php endif; ?>