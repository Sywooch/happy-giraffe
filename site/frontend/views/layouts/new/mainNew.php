<?php $this->bodyClass = 'body__bg2'; ?>
<?php $this->beginContent('//layouts/new/common'); ?>
        <div class="layout-loose">
            <?php $this->renderPartial('//_header'); ?>
            <div class="layout-loose_hold clearfix">
                <!-- user-menu-->
                <div class="user-menu">
                    <div class="user-menu_ava">
                        <!-- ava--><a href="" class="ava ava__middle ava__female"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.cdnvideo.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    </div>
                    <ul class="user-menu_ul">
                        <li class="user-menu_li"><a class="user-menu_i">
                                <div class="user-menu_ico user-menu_ico__profile"></div>
                                <div class="user-menu_tx">Анкета
                                </div></a></li>
                        <li class="user-menu_li active"><a class="user-menu_i">
                                <div class="user-menu_ico user-menu_ico__family"></div>
                                <div class="user-menu_tx">Семья
                                </div></a></li>
                        <li class="user-menu_li"><a class="user-menu_i">
                                <div class="user-menu_ico user-menu_ico__blog"></div>
                                <div class="user-menu_tx">Блог
                                </div></a></li>
                        <li class="user-menu_li"><a class="user-menu_i">
                                <div class="user-menu_ico user-menu_ico__photo"></div>
                                <div class="user-menu_tx">Фото
                                </div></a></li>
                        <li class="user-menu_li"><a class="user-menu_i">
                                <div class="user-menu_ico user-menu_ico__interest"></div>
                                <div class="user-menu_tx">Интересы
                                </div></a></li>
                    </ul>
                </div>
                <!-- /user-menu-->
                <div class="page-col page-col__user">
                    <div class="page-col_cont page-col_cont__in">
                        <?=$content?>
                    </div>
                    <?php $this->renderPartial('//_footer'); ?>
                </div>
            </div>
            <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
        </div>
    </div>
    <div class="popup-container display-n">
    </div>
<?php $this->endContent(); ?>