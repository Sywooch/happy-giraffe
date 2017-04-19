<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 */
$this->beginContent('application.modules.iframe.views._parts.common');
?>
<header class="header header-question header--question">
    <div class="header-question__item">
        <div class="header-question__title"><span class="header-question-icon__title"></span>Мои вопросы и ответы</div>
    </div>
    <div class="header-question__item header-question__item--close">
        <a type="button" href="<?=$this->createUrl('/iframe/default/pediatrician')?>" class="header-question__close"></a>
    </div>
</header>
<main class="b-main">
    <?=$content?>
</main>

<?php $this->endContent(); ?>