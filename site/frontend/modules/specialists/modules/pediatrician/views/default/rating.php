<?php
/**
 * @var \site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController
 * @var integer $page
 */
?>
<?php $this->widget(\site\frontend\modules\specialists\modules\pediatrician\widgets\rating\RatingWidget::class, [
    'perPage' => 12,
    'page' => $page,
]); ?>
