<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 */
$this->beginContent('//layouts/lite/new_common');
?>
<header class="header header-question header--question">
    <div class="header-question__item">
        <div class="header-question__title header-question__title--answer">Вопросы</div>
    </div>
    <div class="header-question__item header-question__item--close">
        <a type="button" href="<?=$this->createUrl('/som/qa/default/pediatrician')?>" class="header-question__close"></a>
    </div>
</header>
<main>
    <?=$content?>
</main>

<?php $this->endContent(); ?>
