<?php
/**
 * @var $this UserController
 * @var $data Album
 * @var $full bool
 */
?>

<div class="content-cols clearfix">
    <div class="col-1">
        <div class="b-ava-large">
            <div class="b-ava-large_ava-hold clearfix">
                <a class="ava large" href="">
                    <img alt="" src="/images/example/ava-large.jpg">
                </a>
                <span class="b-ava-large_online">На сайте</span>
                <a href="" class="b-ava-large_bubble b-ava-large_bubble__dialog powertip" title="Начать диалог">
                    <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
                    <span class="b-ava-large_bubble-tx">+5</span>
                </a>
                <a href="" class="b-ava-large_bubble b-ava-large_bubble__photo powertip" title="Фотографии">
                    <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
                    <span class="b-ava-large_bubble-tx">+50</span>
                </a>
                <a href="" class="b-ava-large_bubble b-ava-large_bubble__blog powertip" title="Записи в блоге">
                    <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
                    <span class="b-ava-large_bubble-tx">+999</span>
                </a>
                <a href="" class="b-ava-large_bubble b-ava-large_bubble__friend-add-onhover powertip" title="Добавить в друзья">
                    <span class="b-ava-large_ico b-ava-large_ico__friend-add"></span>
                </a>
            </div>
            <div class="textalign-c">
                    <a href="" class="b-ava-large_a">Александр Богоявленский</a>
                    <span class="font-smallest color-gray"> 39 лет</span>
                </div>
            <div class="b-ava-large_location">
                <div title="Украина" class="flag flag-ua"></div>
                    Украина, Астраханская область
            </div>
        </div>

    </div>
    <div class="col-23-middle">
        <ul class="breadcrumbs-big clearfix">
            <li class="breadcrumbs-big_i">
                <a href="" class="breadcrumbs-big_a">Ангелина Богоявленская</a>
            </li>
            <li class="breadcrumbs-big_i">Фотоальбомы </li>
        </ul>
        <div class="col-gray">

            <div class="photo-preview-row clearfix margin-t30">
                <div class="photo-preview-row_hold2">
                    <div class="photo-grid clearfix">
                        <div class="photo-grid_row clearfix" >
                            <!-- Ловить клик на photo-grid_i для показа увеличенного фото -->
                            <div class="photo-grid_i">
                                <img class="photo-grid_img" src="/images/example/photo-grid-7.jpg" alt="">
                                <div class="photo-grid_overlay">
                                    <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
                                </div>
                            </div>
                            <div class="photo-grid_i">
                                <img class="photo-grid_img" src="/images/example/photo-grid-8.jpg" alt="">
                                <div class="photo-grid_overlay">
                                    <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
                                </div>
                            </div>
                            <div class="photo-grid_i">
                                <img class="photo-grid_img" src="/images/example/photo-grid-9.jpg" alt="">
                                <div class="photo-grid_overlay">
                                    <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
                                </div>
                            </div>
                            <div class="photo-grid_i">
                                <img class="photo-grid_img" src="/images/example/photo-grid-10.jpg" alt="">
                                <div class="photo-grid_overlay">
                                    <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
                                </div>
                            </div>
                            <div class="photo-grid_i">
                                <img class="photo-grid_img" src="/images/example/photo-grid-11.jpg" alt="">
                                <div class="photo-grid_overlay">
                                    <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
                                </div>
                            </div>
                            <div class="photo-grid_i">
                                <img class="photo-grid_img" src="/images/example/photo-grid-12.jpg" alt="">
                                <div class="photo-grid_overlay">
                                    <span class="photo-grid_zoom powertip" title="Смотреть фото"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="photo-preview-row_last">
                        <div class="font-small color-gray margin-b5">смотреть <br> все фото</div>
                        <a href="" class="photo-preview-row_a">58 054</a>
                    </div>
                </div>
            </div>

            <?php
            $this->widget('zii.widgets.CListView', array(
                'cssFile' => false,
                'ajaxUpdate' => false,
                'dataProvider' => $dataProvider,
                'itemView' => '_album',
                'viewData' => array(
                    'full' => false,
                ),
                'pager' => array(
                    'class' => 'HLinkPager',
                ),
                'template' => '{items}<div class="yiipagination">{pager}</div>',
            ));
            ?>

        </div>
    </div>
</div>