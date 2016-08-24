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
                    <a href="<?=Yii::app()->user->model->getUrl()?>" class="pediator-header__name"><?=Yii::app()->user->model->getFullName()?></a>
                    <div class="ava ava-pediator"><a href="#" class="js-ava__link ava__link"><img src="<?=Yii::app()->user->model->getAvatarUrl(Avatar::SIZE_SMALL)?>"></a></div>
                </div>
            </div>
        </div>
        <div class="user-widget-block user-widget-block_mod">
            <ul class="user-widget-block__list">
                <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_profile"><img src="<?=Yii::app()->user->model->getAvatarUrl(24)?>" class="user-widget-block__ava"></span><span class="user-widget-block__text">Анкета</span></a></li>
                <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getFamilyUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_family"></span><span class="user-widget-block__text">Семья</span></a></li>
                <li class="user-widget-block__li"><a href="<?=Yii::app()->user->model->getBlogUrl()?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_blog"></span><span class="user-widget-block__text">Блог</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/messaging/default/index')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_dialog"></span><span class="user-widget-block__text">Диалоги</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/friends/default/index')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_friend"></span><span class="user-widget-block__text">Друзья</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/photo/default/index', array('userId' => Yii::app()->user->id))?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_photo"></span><span class="user-widget-block__text">Фото</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/users/default/settings')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_setting"></span><span class="user-widget-block__text">Настройки</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/som/qa/my/questions')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_answers"></span><span class="user-widget-block__text">Ответы</span></a></li>
                <li class="user-widget-block__li"><a href="<?=$this->createUrl('/site/logout')?>" class="user-widget-block__link"><span class="user-widget-block__bg user-widget-block__bg_exit"></span><span class="user-widget-block__text">Выход</span></a></li>
            </ul>
        </div>
    </header>
</div>
<?=$content?>

<script>
    $("body").on("click", function(){
        $('.user-widget-block_mod').hide();
    });

    $(".js-ava__link").click(function( event ) {
        $('.user-widget-block_mod').toggle();
        event.stopPropagation();
    });
</script>

<?php $this->endContent(); ?>
