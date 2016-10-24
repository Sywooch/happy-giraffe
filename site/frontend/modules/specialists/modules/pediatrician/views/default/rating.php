<?php
/**
 * @var \site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController
 * @var integer $page
 */
?>
<div class="pediator-container pediator-rating pediator-rating--bg pediator-rating--style">
    <div class="landing-question pediator textalign-c">
        <div class="font__title-xxm font__semi margin-b20">Лидеры по набранным баллам</div>
        <div class="pediator-rating__header bg-antiquewhite margin-b45">
            <p class="font-m">1 Ответ = 1 балл &nbsp;&nbsp;&nbsp;&nbsp; 1<span class="pediator-ico--roze pediator-ico--size-s pediator-ico--margin"></span>Спасибо = 1 балл</p>
        </div>
    </div>

    <?php $this->widget('site\frontend\modules\specialists\modules\pediatrician\widgets\rating\RatingWidget', [
        'perPage' => 12,
        'page' => $page,
    ]); ?>
</div>
