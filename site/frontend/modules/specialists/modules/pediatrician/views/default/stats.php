<?php
/**
 * @var site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController $this
 */
?>
<div class="pediator-container">
<?php $this->widget('site\frontend\modules\specialists\modules\pediatrician\widgets\stats\StatsWidget', [
    'userId' => Yii::app()->user->id,
]); ?>
</div>