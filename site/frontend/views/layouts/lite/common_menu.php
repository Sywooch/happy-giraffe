<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');

/* @var $cs ClientScript */
$cs = Yii::app()->clientScript;
if ($cs->useAMD)
{
    Yii::app()->clientScript->registerAMD('menuVM', array('ko' => 'knockout', 'MenuViewModel' => 'ko_menu'), "menuVm = new MenuViewModel(" . CJSON::encode($this->menuData) . "); ko.applyBindings(menuVm, $('.layout-header')[0]); return menuVm;");
}
else
{
    Yii::app()->clientScript->registerPackage('ko_menu');
    ?><script type="text/javascript">
    menuVm = new MenuViewModel(<?=CJSON::encode($this->menuData)?>);
    ko.applyBindings(menuVm, $('.layout-header')[0]);
</script><?php
}
?>

    <?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>

    <div class="layout-header">
        <header class="header header__redesign"><a class="mobile-menu"></a><a href="/" class="logo"></a><a class="header__search"></a>
            <nav class="header__nav">
                <ul class="header__menu">
                    <li class="header__li"><a href="<?=$this->createUrl('/posts/forums/default/index')?>" class="header__link header__link_comment">Форумы</a></li>
                    <li class="header__li"><a href="<?=$this->createUrl('/som/qa/default/index')?>" class="header__link header__link_answers">Ответы</a></li>
                    <!--<li class="header__li"><a href="#" class="header__link header__link_blog">Блоги</a></li>-->
                    <li class="header__li"><a href="<?=$this->createUrl('/posts/buzz/list/index')?>" class="header__link header__link_like">Жизнь</a></li>
                </ul>
                <?php if (Yii::app()->user->isGuest): ?>
                    <div class="user-unloged">
                        <a href="#" class="user-unloged__link login-button" data-bind="follow: {}"><img src="/images/icons/avatar.png" class="user-unloged__img">ВОЙТИ</a>
                    </div>
                <?php else: ?>
                    <div class="user-on"><a href="<?=$this->createUrl('/notifications/default/index')?>" class="signal" data-bind="css: { active: newNotificationsCount() > 0 }"></a>
                        <div class="ava"><a href="<?=Yii::app()->user->model->url?>"><img src="<?=Yii::app()->user->model->getAvatarUrl(40)?>"></a></div>
                    </div>
                <?php endif; ?>
            </nav>
        </header>
    </div>

    <div class="layout-loose_hold clearfix">
        <!-- b-main -->
        <div class="b-main clearfix">
            <?= $content ?>
        </div>
        <!-- b-main -->

        <?php $this->renderPartial('//_footer'); ?>
    </div>
<?php $this->endContent(); ?>