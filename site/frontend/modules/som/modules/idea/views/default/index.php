<?php
$this->pageTitle = 'Идеи';
$cs = Yii::app()->clientScript;
$cs->registerAMD('kow', array('kow'));
?>
<div class="b-main_cont ideas-cont">
    <h1 class="heading-link-xxl"><?= $this->pageTitle ?></h1>

    <div class="b-crumbs">
        <div class="b-crumbs_tx">Я здесь:</div>
        <ul class="b-crumbs_ul">
            <li class="b-crumbs_li"><a href="#" class="b-crumbs_a">Ответы</a></li>
            <li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">Обсуждаем проблемы ГВ</span></li>
        </ul>
    </div>
    <div class="b-main_col-article">
        <ideas-line params=""></ideas-line>
    </div>
    <aside class="b-main_col-sidebar visible-md">
        <div class="sidebar-widget">
            <a class="btn btn-success btn-xl btn-question" href="/idea/create">Добавить идею</a>
            <div class="personal-links">
                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
                <ul class="personal-links_ul">
                    <li class="personal-links_li"><a class="personal-links_link">Мои вопросы<span class="personal-links_count">56</span></a></li>
                    <li class="sidebar-personal_li"><a class="personal-links_link">Мои ответы<span class="personal-links_count">625</span></a></li>
                </ul>
            </div>
            <div class="questions-categories">
                <ul class="questions-categories_ul">
                    <li class="questions-categories_li active"><a class="questions-categories_link">Все вопросы<span class="questions-categories_count">8985</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Отношения в семье<span class="questions-categories_count">657</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Свадьба<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Планирование<span class="questions-categories_count">657</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Беременность и роды<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Дети до года<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Свадьба<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Планирование<span class="questions-categories_count">657</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Беременность и роды<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Дети до года<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Свадьба<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Планирование<span class="questions-categories_count">657</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Беременность и роды<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Дети до года<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Свадьба<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Планирование<span class="questions-categories_count">657</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Беременность и роды<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Дети до года<span class="questions-categories_count">56</span></a></li>
                </ul>
            </div>
            <div class="consult-widget">
                <div class="consult-widget_heading">Онлайн-консультации</div>
                <ul class="questions-categories_ul">
                    <li class="questions-categories_li"><a class="questions-categories_link">Грудное вскармливание<span class="questions-categories_count">657</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Семейная гармония<span class="questions-categories_count">56</span></a></li>
                    <li class="questions-categories_li"><a class="questions-categories_link">Планирование<span class="questions-categories_count">657</span></a></li>
                </ul>
            </div>
        </div>
        <div class="rating-widget">
            <div class="rating-widget_heading">Рейтинг</div><a href="/lite/html/page/services/faq/faq-rating.html" class="rating-widget_heading_link">Весь рейтинг</a>
            <ul class="rating-widget_filter filter-menu nav-tabs nav">
                <li class="filter-menu_item active"><a href="#rating-now" data-toggle="pill" class="filter-menu_item_link">За сегодня</a></li>
                <li class="filter-menu_item"><a href="#rating-weak" data-toggle="pill" class="filter-menu_item_link">За неделю</a></li>
                <li class="filter-menu_item"><a href="#rating-alltime" data-toggle="pill" class="filter-menu_item_link">За все время</a></li>
            </ul>
            <div class="rating-widget_cont tab-content">
                <div id="rating-now" class="tab-pane active">
                    <ul class="rating-widget_users-list">
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Клара Демина</a>
                                <div class="questions-counters"><span>Вопросов 658</span><span>Ответов 56</span></div>
                            </div>
                            <div class="users-rating yellow-crown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">389</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Вера Брежнева</a>
                                <div class="questions-counters"><span>Вопросов 344</span><span>Ответов 23</span></div>
                            </div>
                            <div class="users-rating blue-crown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">370</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Алиса Загорская</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating orange-crown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">300</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Катя Дружинина</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating nocrown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">10</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Дарья Бойцова</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating nocrown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">2</div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="rating-weak" class="tab-pane">
                    <ul class="rating-widget_users-list">
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Алиса Загорская</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating orange-crown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">300</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Катя Дружинина</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating nocrown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">10</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Дарья Бойцова</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating nocrown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">2</div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div id="rating-alltime" class="tab-pane">
                    <ul class="rating-widget_users-list">
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Вера Брежнева</a>
                                <div class="questions-counters"><span>Вопросов 344</span><span>Ответов 23</span></div>
                            </div>
                            <div class="users-rating blue-crown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">370</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Алиса Загорская</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating orange-crown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">300</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Катя Дружинина</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating nocrown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">10</div>
                            </div>
                        </li>
                        <li class="rating-widget_users-list_item">
                            <div class="rating-widget_users-list_item_cont">
                                <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span><a>Дарья Бойцова</a>
                                <div class="questions-counters"><span>Вопросов 300</span><span>Ответов 10</span></div>
                            </div>
                            <div class="users-rating nocrown">
                                <div class="users-rating_crown"></div>
                                <div class="users-rating_counter">2</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>
</div>
