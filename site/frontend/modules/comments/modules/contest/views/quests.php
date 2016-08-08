<?php

use site\frontend\modules\comments\modules\contest\components\ContestHelper;
/**
 * @var string $type
 * @var site\frontend\modules\posts\models\Content[] $posts
 * @var int $clubsCount
 * @var \CommunityClub[] $clubs
 * @var site\frontend\modules\quests\models\Quest[] $social
 */
$this->pageTitle = $this->contest->name . ' - Задания';
$cs = \Yii::app()->clientScript;
?>
<script src="/lite/javascript/jquery.magnific-popup.js"></script>

<script src="/lite/javascript/jquery.bxslider.min.js"></script>
<script src="/lite/javascript/baron.js"></script>
<script src="/lite/javascript/select2.js"></script>
<script src="/lite/javascript/select2_locale_ru.js"></script>
<script src="/lite//redactor/redactor.js"></script>
<script src="/lite//redactor/lang/ru.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        /*-- вывзов попапа комментирования --*/
        $('.js-b-contest-task__choose').magnificPopup({
            type: 'inline',
            preloader: false,
            showCloseBtn: false,
            closeOnContentClick: false,
            mainClass: 'b-modal-theme',
        });

        $('.js-popup-comment').magnificPopup({
            type: 'inline',
            preloader: false,
            showCloseBtn: false,
            closeOnContentClick: false,
            mainClass: 'b-modal-comment',
        });

        $('.add-post__close').on('click', function (e) {
            e.preventDefault();
            $.magnificPopup.instance.close();
        });

        $(':checkbox.homepage-check__input').on('click', function() {
            var filter = [];

            $(':checkbox.homepage-check__input').each(function() {
                if ($(this).is(':checked')) {
                    filter.push($(this).data('value'));
                }
            });

            $('.popup_clubs_count').text(filter.length);

            $.post('/v2_1/api/contest/', {
                action: 'settings',
                community_filter: filter.join(',')
            }, function(response) {
                //alert(JSON.stringify(response));
            });
        });
    });

    /*-- инициализация редактора в попапе --*/
    if (!RedactorPlugins) var RedactorPlugins = {};

    (function ($) {
        RedactorPlugins.panel = function () {
            return {
                init: function () {
                    var picture = this.button.add('picture', 'добавить изображение');
                    var videos = this.button.add('videos', 'добавить видео');
                    var smile = this.button.add('smile', 'смайл');

                    this.button.addCallback(smile, function () {
                        alert('смайл')
                    });
                    this.button.addCallback(videos, function () {
                        alert('видео')
                    });
                    this.button.addCallback(picture, function () {
                        alert('изображение')
                    });

                }
            }
        }
    })(jQuery);

    $(function () {
        $('#js-answer-form_textarea').redactor({
            plugins: ['panel'],
            lang: 'ru',
            minHeight: 130,
            autoresize: true,
            placeholder: 'Введите ваш комментарии',
            focus: true,
            toolbarExternal: '#add-post-toolbar',
            buttons: ['']
        });
    });

</script>

<div class="b-contest-task b-contest__block textalign-c">
    <div class="b-contest__title">Получи море баллов. Расскажи друзьям</div>
    <p class="b-contest__p margin-t10 margin-b55">Нажми на значок социальной сети и заработай баллы.
    <ul class="b-contest-task__list">
        <li class="b-contest-task__li b-contest-task__li_onnoklasniki"><a href="#" class="b-contest-task__link ico-odnoklasniki"><?php if ($this->checkSocialService('ok', $social)): ?><span class="b-contest-task__mark"></span><? endif; ?></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы</a></li>
        <li class="b-contest-task__li b-contest-task__li_fb"><a href="#" class="b-contest-task__link ico-fb"><?php if ($this->checkSocialService('fb', $social)): ?><span class="b-contest-task__mark"></span><? endif; ?></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы</a></li>
        <li class="b-contest-task__li b-contest-task__li_vk"><a href="#" class="b-contest-task__link ico-vk"><?php if ($this->checkSocialService('vk', $social)): ?><span class="b-contest-task__mark"></span><? endif; ?></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы</a></li>
    </ul>
    <div class="b-contest-winner__container">
        <div class="b-contest__title">Комментируй и получай баллы</div>
        <p class="b-contest__p margin-t10 margin-b20">Выбрано <span class="popup_clubs_count"><?= $clubsCount ?></span> <?= ContestHelper::getWord($clubsCount, ContestHelper::$themeWords) ?> &nbsp;<span class="hidden-xss">для комментирования &nbsp;</span><a href="#js-b-popup-theme" class="js-b-contest-task__choose b-contest-task__choose">Выбрать</a></p>
        <ul class="textalign-c margin-b30">
            <li class="contest-header__li"><a href="<?= \Yii::app()->createUrl('/comments/contest/default/quests', array('type' => 'blog')) ?>" class="b-contest-winner__link <?= $type == 'blog' ? 'b-contest-winner__link-active' : ''?>">Блоги</a></li>
            <li class="contest-header__li"><a href="<?= \Yii::app()->createUrl('/comments/contest/default/quests', array('type' => 'community')) ?>" class="b-contest-winner__link <?= $type == 'community' ? 'b-contest-winner__link-active' : ''?>">Форумы</a></li>
        </ul>
        <div class="textalign-l">
            <?php foreach ($posts as $post): ?>
            <div class="default-theme">
                <div class="b-froum-theme"><a class="b-froum-theme-img ava__middle ava__female"><img src="<?= $post->author->getAvatarUrl() ?>" alt=""></a>
                    <div class="b-froum-theme-info"><a href="<?= $post->author->getUrl() ?>" class="name"><?= $post->author->getFullName() ?></a>
                        <time class="time"><?= HHtml::timeTag($post, array('class' => 'tx-date'), null); ?></time><a href="<?= ContestHelper::getValidPostUrl($post->url) ?>" class="b-froum-theme-info-title"><?= $post->title ?></a>
                        <p><?= $post->preview ?></p>
                        <div class="b-froum-theme-info-more clearfix">
                            <div class="float-l lh-34">
                                <div class="c-list_item_btn"><span class="c-list_item_btn__view"><?= $post->views ?></span><span class="c-list_item_btn__users"><?= $post->getDistinctComments()?></span><a href="#" class="c-list_item_btn__comment"><?=$post->comments_count ?></a></div>
                            </div>
                            <div class="float-r"><a href="#js-b-popup-modal" class="js-popup-comment btn btn-ms green-btn"><span class="hidden-smm">Комментировать</span><span class="b-comment-furt visible-smm">></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    </p>
</div>
<div id="js-b-popup-modal" class="b-popup-modal mfp-hide">
    <!-- попап коммментирования на странице конкурсов-->
    <div class="b-contest-comment__wrapper blog-homepage">
        <div class="add-post__header add-post__header_grey">
            <div class="b-main_cont">
                <div class="b-main_col-article">
                    <div class="add-post__comment">Запись блога</div><span class="js-add-post__close add-post__close"></span>
                </div>
            </div>
        </div>
        <div class="b-contest-winner__container">
            <div class="question">
                <div class="live-user position-rel"><a href="#" class="ava ava__female ava__middle-xs ava__middle-sm-mid"><span class="ico-status ico-status__online"></span><img src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a>
                    <div class="username"><a>Валерия Остапенко</a>
                        <time class="tx-date">минуту назад</time>
                    </div>
                    <div class="b-subscribe">
                        <div class="btn btn-tiny green">Подписаться</div>
                        <div class="b-subscribe_tx">23</div>
                    </div>
                </div>
                <div class="icons-meta">
                    <div class="c-list_item_btn"><span class="c-list_item_btn__view">589</span><a href="#" class="c-list_item_btn__comment margin-r0">28</a></div>
                </div><a class="questions_item_heading">Как научить ребенка самостоятельно одеваться?</a>
                <div class="question_text">
                    <p>Дочке уже месяц и неделя, а ГВ не могу наладить.</p>Трещины на сосках зажили, но соски всё ровно очень воспалены: болят даже между кормлениями,а после кормления сосок как бы белеет.
                    Очень больно когда сосет. Прикладывание вроде бы правильное. Единственное что смущает, ореол захватывает почти весь,а когда отпустит грудь, сосок как бы прикушен.
                    Очень хочу кормить грудью, но боль настолько измучила меня, что иногда боюсь дать грудь малышке.
                </div>
                <div class="question_images"><img src="/lite/images/sovhoz.jpg"></div>
                <div class="question_text">
                    <p>Дочке уже месяц и неделя, а ГВ не могу наладить.</p>Трещины на сосках зажили, но соски всё ровно очень воспалены: болят даже между кормлениями,а после кормления сосок как бы белеет.
                    Очень больно когда сосет. Прикладывание вроде бы правильное. Единственное что смущает, ореол захватывает почти весь,а когда отпустит грудь, сосок как бы прикушен.
                    Очень хочу кормить грудью, но боль настолько измучила меня, что иногда боюсь дать грудь малышке.
                </div>
                <div class="queastion__page-nav clearfix">
                    <div class="float-l"><span class="btn btn-xl btn-secondary">Пропустить</span></div>
                    <div class="float-r"><span class="btn btn-xl green-btn">Комментировать</span></div>
                </div>
            </div>
            <form class="answer-form">
                <div class="answer-form__header clearfix">
                    <!-- ava--><span href="#" class="ava ava__middle ava__female"><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></span>
                    <textarea id="js-answer-form_textarea" placeholder="Введите ваш ответ" class="answer-form_textarea"></textarea>
                </div>
                <div class="answer-form__footer clearfix">
                    <div class="answer-form__footer-panel">
                        <div id="add-post-toolbar"></div>
                    </div>
                    <div class="answer-form_button btn btn-primary btn-s">Ответить</div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="js-b-popup-theme" class="b-popup-theme mfp-hide">
    <!-- попап выбора темы-->
    <div class="b-contest-comment__wrapper homepage">
        <div class="add-post__header add-post__header_grey">
            <div class="b-main_cont">
                <div class="b-main_col-article">
                    <div class="add-post__comment">Выбрать темы &nbsp;<span class="add-post__title-theme hidden-xss">Выбрано: <span class="popup_clubs_count"><?= $clubsCount ?></span> <?= ContestHelper::getWord($clubsCount, ContestHelper::$themeWords) ?></span></div><span class="js-add-post__close add-post__close"></span>
                </div>
            </div>
        </div>
        <div class="b-contest-popup-theme textalign-c padding-t20">
            <div class="homepage-clubs_hold margin-l0">
                <?php foreach ($clubs as $club): ?>
                <div class="homepage-theme_li"><a href="#" class="homepage-clubs_a">
                        <div class="homepage-clubs_ico-hold homepage__color-<?= $club->section_id ?>">
                            <div class="ico-club ico-club__<?= $club->id ?>"></div>
                        </div>
                        <div class="homepage-check__box">
                            <input type="checkbox" <?= $this->isCheckedClub($club->id) ? 'checked' : '' ?> id="c<?= $club->id ?>" data-value="<?= $club->id ?>" class="homepage-check__input">
                            <label for="c<?= $club->id ?>" class="homepage-check__label"><span class="homepage-check__cap"></span></label>
                        </div>
                        <div class="homepage-clubs_tx"><?= $club->title ?></div></a></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
