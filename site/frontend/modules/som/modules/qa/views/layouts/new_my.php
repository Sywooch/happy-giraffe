<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 */
$this->beginContent('//layouts/lite/new_common');
$this->renderSidebarClip();
?>
<header class="header header-question header--question">
    <div class="header-question__item">
        <div class="header-question__title header-question__title--answer">Вопросы</div>
    </div>
    <div class="header-question__item header-question__item--close">
        <a type="button" href="<?=$this->createUrl('/som/qa/default/pediatrician')?>" class="header-question__close"></a>
    </div>
</header>
<main class="b-main">
    <div class="b-main__inner">
        <div class="b-col__container">
            <div class="b-col b-col--6 b-hidden-md">
                <div class="b-nav-panel">
                    <div class="b-nav-panel__left">
                        <div class="b-filter-menu b-filter-menu--theme-default">
                            <ul class="b-filter-menu__list">
                                <li class="b-filter-menu__item <?=$this->action->id == 'questions' ? 'b-filter-menu__item--active' : ''?>">
                                	<a href="<?=$this->createUrl('/som/qa/my/questions')?>" class="b-filter-menu__link">Мои вопросы</a>
                                </li>
                                <li class="b-filter-menu__item <?=$this->action->id == 'answers' ? 'b-filter-menu__item--active' : ''?>">
                                	<a href="<?=$this->createUrl('/som/qa/my/answers')?>" class="b-filter-menu__link">Мои ответы</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?=$content?>
        </div>
    </div>
</main>
<?php $this->renderPartial('//_new_footer'); ?>
<?php $this->endContent(); ?>