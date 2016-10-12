<?php
/**
 * @var site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController $this
 */
?>
<div class="pediator-container">
<?php $this->widget('site\frontend\modules\specialists\modules\pediatrician\widgets\summary\SummaryWidget', [
    'userId' => 12936,
]); ?>
<?php $this->widget('site\frontend\modules\specialists\modules\pediatrician\widgets\stats\StatsWidget', [
    'userId' => 12936,
]); ?>
</div>