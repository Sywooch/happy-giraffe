<?php
Yii::app()->clientScript->registerAMD('bootstrap', array('bootstrap'));
?>

<div class="rating-widget">
    <div class="rating-widget_heading">Рейтинг</div><a class="rating-widget_heading_link">Весь рейтинг</a>
    <div class="clearfix"></div>
    <ul class="rating-widget_filter filter-menu nav nav-tabs">
        <li class="filter-menu_item"><a data-toggle="tab" class="filter-menu_item_link_selected" href="#day">За сегодня</a></li>
        <li class="filter-menu_item"><a data-toggle="tab" class="filter-menu_item_link" href="#week">За неделю</a></li>
        <li class="filter-menu_item"><a data-toggle="tab" class="filter-menu_item_link" href="#all">За все время</a></li>
        <div class="clearfix"></div>
    </ul>
    <div class="tab-content">
        <?php foreach (\site\frontend\modules\som\modules\qa\components\QaUsersRatingManager::$periods as $type => $period): ?>
            <div class="tab-pane<?=($type == 'day') ? ' active' : ''?>" id="<?=$type?>">
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
                        <div class="clearfix"></div>
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
                        <div class="clearfix"></div>
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
                        <div class="clearfix"></div>
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
                        <div class="clearfix"></div>
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
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>