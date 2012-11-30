<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerScriptFile('/javascripts/live.js')
    ;

    Yii::app()->eauth->renderWidget(array(
        'mode' => 'assets',
    ));
?>

<div id="broadcast">

    <?php $this->renderPartial('menu'); ?>

    <div class="content-cols clearfix">

        <div class="col-12">
            <?php
                $this->widget('zii.widgets.CListView', array(
                    'id' => 'liveList',
                    'dataProvider' => $dp,
                    'itemView' => '_brick',
                    'template' => "{items}\n{pager}",
                    'itemsTagName' => 'ul',
                    'htmlOptions' => array(
                        'class' => 'masonry-news-list',
                    ),
                    'pager' => array(
                        'header' => '',
                        'class' => 'ext.infiniteScroll.IasPager',
                        'rowSelector' => 'li',
                        'listViewId' => 'liveList',
                        'options' => array(
                            'scrollContainer' => new CJavaScriptExpression("$('.layout-container')"),
                            'onLoadItems' => new CJavaScriptExpression("function(items) {
                                $(items).hide();
                                $('#liveList .items').append(items).imagesLoaded(function() {
                                     $('#liveList .items').masonry('appended', $(items));
                                     $(items).fadeIn();
                                });
                                return false;
                            }"),
                        ),
                    ),
                ));
            ?>
        </div>

        <div class="col-3 clearfix">
            <div class="best-users tabs">
                <div class="best-users_title">Лучшие клабберы</div>
                <div class="best-users_nav">
                    <ul>
                        <li class="best-users_nav_item active"><a  onclick="setTab(this, 1);" href="javascript:void(0);"><span>Сегодня</span></a></li>
                        <li class="best-users_nav_item"><a  onclick="setTab(this, 2);" href="javascript:void(0);"><span>Неделя</span></a></li>
                        <li class="best-users_nav_item"><a onclick="setTab(this, 1);" href="javascript:void(0);"><span>Месяц</span></a></li>
                    </ul>
                </div>
                <div class="tabs-container">
                    <div class="tab-box tab-box-1" style="display:block">
                        <table class="best-users_list" cellspacing="0" cellpadding="0">
                            <tr>
                                <th class="best-users_list-rank"></th>
                                <th class="best-users_list-ava"></th>
                                <th class="best-users_list-post">Тем</th>
                                <th class="best-users_list-comment"><i class="icon-comment"></i></th>
                                <th class="best-users_list-point">Баллов</th>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank1"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank2"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">33</td>
                                <td class="best-users_list-point">65</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank3"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">12833</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank4"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank5"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">1238</td>
                                <td class="best-users_list-comment">33</td>
                                <td class="best-users_list-point">355</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank6"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank7"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank8"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank9"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank10"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-box tab-box-2">
                        <table class="best-users_list" cellspacing="0" cellpadding="0">
                            <tr>
                                <th class="best-users_list-rank"></th>
                                <th class="best-users_list-ava"></th>
                                <th class="best-users_list-post">Тем</th>
                                <th class="best-users_list-comment"><i class="icon-comment"></i></th>
                                <th class="best-users_list-point">Баллов</th>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank1"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3</td>
                                <td class="best-users_list-point">3</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank2"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">1</td>
                                <td class="best-users_list-comment">33</td>
                                <td class="best-users_list-point">6555</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank3"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">12833</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank4"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank5"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">1238</td>
                                <td class="best-users_list-comment">33</td>
                                <td class="best-users_list-point">355</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank6"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank7"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank8"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""><img alt="" src="http://img.happy-giraffe.ru/avatars/19372/small/21fd8c8f29c5a289df17938cb2f20e5b.jpg"></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank9"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                            <tr>
                                <td class="best-users_list-rank"><i class="rank rank10"></i></td>
                                <td class="best-users_list-ava">
                                    <a class="ava female small" href=""></a>
                                </td>
                                <td class="best-users_list-post">128</td>
                                <td class="best-users_list-comment">3333</td>
                                <td class="best-users_list-point">3 565</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

