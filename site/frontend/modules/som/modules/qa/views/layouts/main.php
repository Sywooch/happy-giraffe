<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 * @var site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu $consultationsMenu
 */
$this->beginContent('//layouts/lite/main');
$consultationsMenu = $this->createWidget('site\frontend\modules\som\modules\qa\widgets\ConsultationsMenu');
?>

<div class="b-main clearfix">
    <div class="b-main_cont">
        <div class="heading-link-xxl"> Вопрос-ответ</div>
        <div class="b-main_col-article">
            <?=$content?>
        </div>
        <aside class="b-main_col-sidebar visible-md">
            <div class="sidebar-widget">
                <div class="btn btn-success btn-xl btn-question">Задать вопрос</div>
                <div class="personal-links">
                    <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
                    <ul class="personal-links_ul">
                        <li class="personal-links_li"><a class="personal-links_link">Мои вопросы<span class="personal-links_count">56</span></a></li>
                        <li class="sidebar-personal_li"><a class="personal-links_link">Мои ответы<span class="personal-links_count">625</span></a></li>
                    </ul>
                </div>
                <div class="questions-categories">
                    <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\CategoriesMenu'); ?>
                </div>
                <?php if (count($consultationsMenu->items) > 0): ?>
                <div class="consult-widget">
                    <div class="consult-widget_heading">Онлайн-консультации</div>
                    <?php $consultationsMenu->run(); ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="rating-widget">
                <div class="rating-widget_heading">Рейтинг</div><a class="rating-widget_heading_link">Весь рейтинг</a>
                <div class="clearfix"></div>
                <ul class="rating-widget_filter filter-menu">
                    <li class="filter-menu_item"><a class="filter-menu_item_link_selected">За сегодня</a></li>
                    <li class="filter-menu_item"><a class="filter-menu_item_link">За неделю</a></li>
                    <li class="filter-menu_item"><a class="filter-menu_item_link">За все время</a></li>
                    <div class="clearfix"></div>
                </ul>
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
        </aside>
    </div>
</div>
<?php $this->endContent(); ?>