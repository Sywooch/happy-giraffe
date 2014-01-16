<?php
/**
 * @var HController $this
 */
?>

<?php $this->beginContent('//layouts/new_main'); ?>
    <div class="layout-container">
        <!-- header-->
        <div class="header header__small">
            <div class="header_hold clearfix">
                <!-- logo__small-->
                <div class="logo logo__small"><a title="Веселый жираф - сайт для всей семьи" href="" class="logo_i">Веселый жираф - сайт для всей семьи</a></div>
                <div class="header_t-big">Модератор</div>
                <div class="header_user"><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"/></a><a class="header_user-name">Александр Богоявленский</a>
                </div>
            </div>
        </div>
        <!-- /header-->
        <div class="layout-wrapper">
            <div class="layout-wrapper_frame clearfix">
                <!-- side-menu-->
                <div class="side-menu side-menu__antispam">
                    <div class="side-menu_hold">
                        <div class="side-menu_t side-menu_t__moderator"></div>
                        <a href="<?=$this->createUrl('live')?>" class="side-menu_i side-menu_i__find">
                            <span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__broadcast"></span><span class="side-menu_tx">Прямой эфир</span></span>
                            <span class="verticalalign-m-help"></span><span class="side-menu_count-sub"><?=$this->counters[0]?></span>
                        </a>
                        <a href="" class="side-menu_i">
                            <span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__expert"></span><span class="side-menu_tx">Эксперт</span><span class="side-menu_count"><?=$this->counters[1]?></span></span><span class="verticalalign-m-help"></span></a>
                        <a href="" class="side-menu_i active">
                            <span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__deleted"></span><span class="side-menu_tx">Удалено</span></span>
                            <span class="verticalalign-m-help"></span><span class="side-menu_count-sub"><?=$this->counters[2]?></span>
                        </a>
                        <a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__ul-white"></span><span class="side-menu_tx">Белый список</span><span class="side-menu_count-sub"><?=$this->counters[3]?></span></span>
                            <span class="verticalalign-m-help"></span>
                        </a>
                        <a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__question"></span><span class="side-menu_tx">Под вопросом</span><span class="side-menu_count-sub"><?=$this->counters[4]?></span></span><span class="verticalalign-m-help"></span></a>
                        <a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__ul-black"></span><span class="side-menu_tx">Черный список</span></span><span class="verticalalign-m-help"></span><span class="side-menu_count-sub"><?=$this->counters[5]?></span></a>
                        <a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__ul-block"></span><span class="side-menu_tx">Блок</span></span><span class="verticalalign-m-help"></span><span class="side-menu_count-sub"><?=$this->counters[6]?></span></a>
                    </div>
                </div>
                <!-- /side-menu-->
                <?=$content?>
            </div>
        </div>
    </div>
    <div class="display-n">
    </div>
<?php $this->endContent(); ?>