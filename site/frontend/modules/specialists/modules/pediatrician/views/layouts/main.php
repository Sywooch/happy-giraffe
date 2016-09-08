<?php
/**
 * @var LiteController $this
 * @var string $content
 */
$this->beginContent('//layouts/lite/common');

$questionsCount = \site\frontend\modules\specialists\modules\pediatrician\components\QaManager::getQuestionsCount(Yii::app()->user->id);
$questionsCount = ($questionsCount > 99) ? '99+' : $questionsCount;
?>

<div class="layout-header">
    <header class="header header__redesign pediator-header clearfix">
        <div class="float-l">
            <div class="pediator-header__left">
                <div class="pediator-header__ico"></div>
                <div class="pediator-header__text">ЖИРАФ ПЕДИАТР</div>
            </div>
        </div>
        <nav class="pediator-nav__wrapper">
            <ul class="pediator-nav__list">
                <li class="pediator-nav__list<?php if ($this->action->id == 'questions'): ?> pediator-nav__list-active<?php endif; ?>">
                    <a href="<?=$this->createUrl('/specialists/pediatrician/default/questions')?>" class="pediator-nav__link">Вопросы</a>
                    <?php if ($questionsCount > 0): ?>
                        <span class="pediator-nav__mark"><span><?=$questionsCount?></span></span>
                    <?php endif; ?>
                </li>
                <li class="pediator-nav__list<?php if ($this->action->id == 'answers'): ?> pediator-nav__list-active<?php endif; ?>">
                    <a href="<?=$this->createUrl('/specialists/pediatrician/default/answers')?>" class="pediator-nav__link">Мои ответы</a>
                </li>
            </ul>
        </nav>
        <div class="float-r">
            <div class="pediator-header__log margin-t22">
                <div class="user-on">
                    <a href="<?=$this->createUrl('/specialists/pediatrician/default/profile')?>" class="pediator-header__name"><?=Yii::app()->user->model->getFullName()?></a>
                    <div class="ava ava-pediator"><a href="<?=$this->createUrl('/specialists/pediatrician/default/profile')?>" class="js-ava__link ava__link"><img src="<?=Yii::app()->user->model->getAvatarUrl(Avatar::SIZE_SMALL)?>"></a></div>
                </div>
            </div>
        </div>
    </header>
</div>
<div class="layout-loose_hold clearfix">
    <?=$content?>
</div>

<?php $this->endContent(); ?>
