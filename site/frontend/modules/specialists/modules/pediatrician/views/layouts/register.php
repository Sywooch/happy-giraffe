<?php
/**
 * @var \site\frontend\modules\specialists\modules\pediatrician\controllers\DefaultController $this
 */

$this->beginContent('//layouts/lite/common');
?>

<div class="layout-loose_hold clearfix">
    <div class="layout-header">
        <header class="header pediator-step__header pediator-step__header-bg position-rel">
            <div class="pediator-step__header-wrapper">
                <div class="float-l hidden-lg">
                    <div class="pediator-header__left-mod">
                        <div class="pediator-header__ico"></div>
                    </div>
                </div>
                <div class="pediator-step__header-descr">
                    <h1 class="font__title-xxl font__bold">Здесь тысячи мам и пап задают вопросы о здоровье своего ребенка</h1>
                </div>
            </div>
        </header>
    </div>
    <?=$content?>
    <?php $this->renderPartial('//_footer'); ?>
</div>



<?php $this->endContent(); ?>