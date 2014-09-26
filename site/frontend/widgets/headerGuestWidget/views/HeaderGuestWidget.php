<?php
/**
 * @var HeaderGuestWidget $this
 * @var CommunityClub[] $clubs
 * @var ClientScript $cs
 */

$cs = Yii::app()->clientScript;
$js = '$(document).ready(function () {
            $(\'a.header-menu_a\').on(\'click\', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var $this = $(this),
                    activeClass = \'active\';

                var $currentPopup =  $this.siblings(\'div.header-popup\');

                $this
                    .parent()
                    .toggleClass(activeClass)
                    .siblings()
                    .removeClass(activeClass);

                $this
                    .children(\'span.header-menu_count:visible\')
                    .hide();

                $(document).on(\'click\', function() {
                    $(\'li.header-menu_li\').removeClass(activeClass);
                    $(this).unbind();
                    $currentPopup.unbind();
                });

                $currentPopup.on(\'click\', function (e) {
                    e.stopPropagation();
                });
            });
        });
';
if ($cs->useAMD) {
    $cs->registerAMD('headerGuestWidget', array('common'), $js);
} else {
    $cs->registerScript('headerGuestWidget', $js);
}
?>

<div class="header-menu">
    <ul class="header-menu_ul clearfix">
        <li class="header-menu_li"><a href="#" class="header-menu_a"><span class="header-menu_ico header-menu_ico__giraffe"></span><span class="header-menu_tx">Мой Жираф</span><span class="header-menu_count">1</span></a>
            <!-- Конверсионный попап-->
            <div class="header-popup header-popup__club">
                <div class="header-popup_hold">
                    <div class="header-popup_t">Вступайте в разные клубы на Веселом жирафе!</div>
                    <div class="header-popup_club">
                        <div class="b-clubs">
                            <!-- 18 клубов-->
                            <ul class="b-clubs_ul">
                                <?php foreach ($clubs as $c): ?>
                                <li class="b-clubs_li"><a href="<?=$c->getUrl()?>" class="b-clubs_a">
                                        <div class="ico-club ico-club__<?=$c->id?>"></div>
                                        <div class="b-clubs_tx"><?=$c->title?></div></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="header-popup_b clearfix">
                        <a href="#registerWidget" class="header-popup_btn btn btn-success btn-xl popup-a">Присоединяйтесь!</a>
                        <div class="header-popup_b-l"><span class="header-popup_b-tx">Начните прямо сейчас с помощью</span>
                            <?php $this->widget('site.frontend.modules.signup.widgets.AuthWidget', array('view' => 'site.frontend.widgets.headerGuestWidget.views.auth')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Конверсионный попап-->
        </li>
        <!-- Класс active отвечает за видимость попапапа-->
        <li class="header-menu_li"><a href="#" class="header-menu_a"><span class="header-menu_ico header-menu_ico__im"></span><span class="header-menu_tx">вам письмо</span><span class="header-menu_count">1</span></a>
            <!-- Конверсионный попап-->
            <div class="header-popup header-popup__msg">
                <div class="header-popup_hold">
                    <div class="header-popup_t">Общайтесь с миллионами мам и пап на любые темы на Веселом жирафе!</div>
                    <div class="header-popup_msg"></div>
                    <div class="header-popup_b clearfix">
                        <a href="#registerWidget" class="header-popup_btn btn btn-success btn-xl popup-a">Присоединяйтесь!</a>
                        <div class="header-popup_b-l"><span class="header-popup_b-tx">Начните прямо сейчас с помощью</span>
                            <?php $this->widget('site.frontend.modules.signup.widgets.AuthWidget', array('view' => 'site.frontend.widgets.headerGuestWidget.views.auth')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Конверсионный попап-->
        </li>
    </ul>
</div>