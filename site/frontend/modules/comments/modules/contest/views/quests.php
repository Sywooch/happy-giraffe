<?php

use site\frontend\modules\comments\modules\contest\components\ContestHelper;
/**
 * @var string $type
 * @var site\frontend\modules\posts\models\Content[] $posts
 * @var int $clubsCount
 * @var \CommunityClub[] $clubs
 * @var site\frontend\modules\quests\models\Quest[] $social
 * @var site\frontend\modules\referals\models\UserRefLink $link
 * @var \User $user
 * @var array $eauth
 * @var int $socialQuestsCount
 */
$this->pageTitle = $this->contest->name . ' - Задания';
$cs = \Yii::app()->clientScript;
Yii::app()->clientScript->registerAMD('kow', array('kow'))
?>
<script src="/lite/javascript/jquery.magnific-popup.js"></script>

<script src="/lite/javascript/jquery.bxslider.min.js"></script>
<script src="/lite/javascript/baron.js"></script>
<script src="/lite/javascript/select2.js"></script>
<script src="/lite/javascript/select2_locale_ru.js"></script>
<script src="/lite//redactor/redactor.js"></script>
<script src="/lite//redactor/lang/ru.js"></script>
<script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
<script type="text/javascript" src="//api.ok.ru/js/fapi5.js" defer="defer"></script>
<script src="https://odnoklassniki.github.io/ok-js-sdk/oksdk.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        //Social Api Init
        VK.init({
            apiId: $('#vk_app').val(),
            status: true
        });

        window.fbAsyncInit = function() {
            FB.init({
                appId      : $('#fb_app').val(),
                xfbml      : true,
                version    : 'v2.7'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/ru_RU/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        var socialVkText = 'СТАНЬ КОММЕНТАТОРОМ МЕСЯЦА!\nhttp://www.happy-giraffe.ru/commentatorsContest/\nЕсли вам нравится общаться с интересными людьми на самые\nактуальные темы, и за это получать  подарки – тогда этот конкурс для вас!\n10 победителей получат приз в размере 1000 рублей!\nУсловия конкурса? Все очень просто - пишите комментарии к\nпостам, которые вам нравятся, и отвечайте на комментарии других пользователей.\nЖдем вас на сайте «Веселый Жираф»!';
        var socialFbText = 'СТАНЬ КОММЕНТАТОРОМ МЕСЯЦА! Если вам нравится общаться с интересными людьми на самые актуальные темы, и за это получать  подарки – тогда этот конкурс для вас! 10 победителей получат приз в размере 1000 рублей! Условия конкурса? Все очень просто - пишите комментарии к постам, которые вам нравятся, и отвечайте на комментарии других пользователей. Ждем вас на сайте «Веселый Жираф»!';

        var socialQuestsCount = $('#social_count').val();

        //post to wall functions
        var postToWall = {
            link: function() {
                return $('#referal_link').val();
            },
            vk: function(link) {
                var post = function() {
                    VK.Api.call('wall.post', {
                        attachments: link + ',' + '<?= ContestHelper::getVkPostImage() ?>',
                        message: socialVkText
                    }, function (r) {
                        if (r.response) {
                            $.post('/v2_1/api/quests/', {
                                action: 'complete',
                                social_service: 'vk'
                            }, function (response) {
                                socialQuestsCount--;
                                showAlert('Вам начислено 25 баллов за приглашение в ВКонтакте', function() {
                                    location.reload();
                                });
                            });
                        }
                    });
                };

                console.log(VK._session);

                if (VK._session == null) {
                    VK.Auth.login(function(response) {
                        if (response.session) {
                            showAlert('Спасибо, теперь для получения баллов необходимо еще раз нажать на кнопку', null, 5000);
                        }
                    });
                } else {
                    post();
                }
            },
            ok: function(link) {
                var listener = function(event) {
                    if (JSON.parse(event.data).id) {
                        $.post('/v2_1/api/quests/', {
                            action: 'complete',
                            social_service: 'ok'
                        }, function (response) {
                            socialQuestsCount--;
                            showAlert('Вам начислено 25 баллов за приглашение в Одноклассники', function() {
                                location.reload();
                            });
                        });
                    }
                };

                if (window.addEventListener) {
                    window.addEventListener("message", listener);
                } else {
                    window.attachEvent("onmessage", listener);
                }

                var okWindow = window.open('http://connect.ok.ru/dk?st.cmd=WidgetMediatopicPost&st.app=' + $('#ok_app').val() + '&st.attachment=' + $('#ok_attach').val() + '&st.signature=' + $('#ok_sig').val() + '&st.popup=on&st.silent=off',
                    "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500");
            },
            fb: function(link) {
                FB.ui({
                    method: 'feed',
                    description: socialFbText,
                    name: 'Конкурс',
                    caption: 'Конкурс',
                    link: link,
                    actions: [{
                        name: 'Присоединиться',
                        link: link
                    }],
                    picture: '<?= ContestHelper::getFbPostImage() ?>'
                }, function(response){
                    if (response && response.post_id) {
                        $.post('/v2_1/api/quests/', {
                            action: 'complete',
                            social_service: 'fb'
                        }, function (response) {
                            socialQuestsCount--;
                            showAlert('Вам начислено 25 баллов за приглашение в Facebook', function() {
                                location.reload();
                            });
                        });
                    }
                });
            }
        };

        var currentTimeoutId;

        var showAlert = function(text, callback, time) {
            var el = $('div.alert.alert-pos.alert-green');

            var notificationText = $('div.alert__text.alert__text-green');

            notificationText.html(text);

            el.addClass('alert-in');

            if (!time) {
                time = 3000;
            }

            $('span.alert__close').on('click', function() {
                hideAlert(callback);
            });

            if (currentTimeoutId) {
                clearTimeout(currentTimeoutId);
            }

            currentTimeoutId = setTimeout(function() {
                hideAlert(callback);
            }, time);
        };

        var hideAlert = function(callback) {
            var el = $('div.alert.alert-pos.alert-green');

            el.removeClass('alert-in');

            if (socialQuestsCount == 0) {
                socialQuestsCount = -1;
                showAlert('Поздравляем! Вы успешно выполнили первое задание', callback);
            } else if (callback) {
                callback();
            }
        };

        $('.b-contest-task__li').on('click', function() {
            if ($(this).hasClass('completed')) {
                return;
            }

            var service;
            if ($(this).hasClass('b-contest-task__li_vk')) {
                service = 'vk';
            } else if ($(this).hasClass('b-contest-task__li_fb')) {
                service = 'fb';
            } else if ($(this).hasClass('b-contest-task__li_onnoklasniki')) {
                service = 'ok';
            } else {
                return;
            }

            if ($(this).children('span .b-contest-task__mark')) {
                postToWall[service](postToWall.link());
            }
        });

        var magnific = $.magnificPopup.instance;

        /*-- вывзов попапа комментирования --*/
        $('.js-b-contest-task__choose').magnificPopup({
            type: 'inline',
            preloader: false,
            showCloseBtn: false,
            closeOnContentClick: false,
            mainClass: 'b-modal-theme',
        });

        var currentPost = 0;
        var haveChanges = false;

        var loadPost = function(sender) {
            if (!sender.jquery) {
                magnific.close();
                location.reload();
                return;
            }

            currentPost = sender.data('id');
            console.log(currentPost);

            $.get('/v2_1/api/posts/', {
                id: currentPost,
                expand: 'author,comments_count,club',
                origin_html: true,
                cache: 'false'
            }, function (response) {
                var popup = $('#js-b-popup-modal');

                if (response.author.avatarInfo) {
                    $(popup.find('.ava_img').get(0)).attr('src', response.author.avatarInfo.big);
                }
                $(popup.find('.ava_img').get(0)).prev('span').removeClass('ico-status__online');

                if (response.author.online) {
                    $(popup.find('.ava_img').get(0)).prev('span').addClass('ico-status__online');
                }

                $(popup.find('.ava_img').get(0)).parent('a').attr('href', '/user/' + response.author.id);

                $(popup.find('.username a').get(0)).html(response.author.first_name + ' ' + response.author.last_name);
                $(popup.find('.username a').get(0)).attr('href', '/user/' + response.author.id);
                popup.find('.c-list_item_btn__view').html(response.views);
                popup.find('.c-list_item_btn__comment').html(response.comments_count);
                popup.find('.questions_item_heading').html(response.title);
                popup.find('.questions_item_heading').attr('href', response.url);
                popup.find('.question_text').html(response.html);
                popup.find('.answer-form').hide(0);
                popup.find('.queastion__page-nav').show(0);
                popup.find('.tx-date').html($('#time' + currentPost).html());

//                if (response.originService == 'oldBlog') {
//                    $.get('/v2_1/api/subscribe/', {
//                        user_id: response.authorId
//                    }, function(r) {
//                        if (r[0].message) {
//                            popup.find('.b-subscribe').html('<span class="b-subscribe__done"></span><span class="b-subscribe_tx"></span>');
//                            popup.find('.b-subscribe_tx').html(response.subscribers);
//                        }
//                    });
//                } else if (response.originService == 'oldCommunity') {
//                    $.get('/v2_1/api/subscribe/', {
//                        club_id: response.club.id
//                    }, function(r) {
//                        if (r[0].message) {
//                            popup.find('.b-subscribe').html('<span class="b-subscribe__done"></span><span class="b-subscribe_tx"></span>');
//                            popup.find('.b-subscribe_tx').html(response.subscribers);
//                        }
//                    });
//                }
//
//                popup.find('div.btn.btn-tiny.green').on('click', function() {
//                    if (response.originService == 'oldBlog') {
//                        $.post('/v2_1/api/subscribe/', {
//                            user_id: response.author.id
//                        }, function (r) {
//                            popup.find('.b-subscribe').html('<span class="b-subscribe__done"></span><span class="b-subscribe_tx"></span>');
//                            popup.find('.b-subscribe_tx').html(response.subscribers + 1);
//                        });
//                    } else if (response.originService == 'oldCommunity') {
//                        $.post('/v2_1/api/subscribe/', {
//                            club_id: response.club.id
//                        }, function (r) {
//                            popup.find('.b-subscribe').html('<span class="b-subscribe__done"></span><span class="b-subscribe_tx"></span>');
//                            popup.find('.b-subscribe_tx').html(response.subscribers + 1);
//                        });
//                    }
//                });
//
//                popup.find('.b-subscribe_tx').html(response.subscribers);

                $('.redactor-editor').html('');
            });
        };

        var goNext = function() {
            var next = false;

            $('.js-popup-comment').each(function() {
                if (next === true) {
                    next = $(this);
                }

                if ($(this).data('id') == currentPost) {
                    next = true;
                }
            });

            haveChanges = true;

            loadPost(next);
        };

        $('#js-b-popup-modal .green-btn').on('click', function() {
            $('#js-b-popup-modal .answer-form').show(0);
            $('.queastion__page-nav').hide(0);
        });

        $('#js-b-popup-modal .btn-secondary').on('click', function() {
            $.post('/v2_1/api/quests/', {
                action: 'drop',
                type: 0,
                model: 'Content',
                model_id: currentPost
            }, function (response) {
                goNext();
            });
        });

        $('.answer-form_button').on('click', function() {
            var text = $('.redactor-editor').html();

            if ($(this).hasClass('locked')) {
                return;
            }

            $(this).addClass('locked');

            var button = $(this);

            $.post('/v2_1/api/comments/', {
                entity_id: currentPost,
                text: text
            }, function(response) {
                button.removeClass('locked');
                goNext();
            });
        });

        $('.js-popup-comment').magnificPopup({
            type: 'inline',
            preloader: false,
            showCloseBtn: false,
            closeOnContentClick: false,
            mainClass: 'b-modal-comment',
            callbacks: {
                open: function() {
                    loadPost($(this.st.el));
                }
            }
        });

        $('article.b-article').magnificPopup({
            type: 'inline',
            preloader: false,
            showCloseBtn: false,
            closeOnContentClick: false,
            mainClass: 'b-modal-comment',
            callbacks: {
                open: function() {
                    loadPost($(this.st.el));
                }
            }
        });

        $('div.default-theme').magnificPopup({
            type: 'inline',
            preloader: false,
            showCloseBtn: false,
            closeOnContentClick: false,
            mainClass: 'b-modal-comment',
            callbacks: {
                open: function() {
                    loadPost($(this.st.el));
                }
            }
        });

        $('.add-post__close').on('click', function (e) {
            e.preventDefault();
            magnific.close();
            if (haveChanges) {
                location.reload();
            }
        });

        $(':checkbox.homepage-check__input').on('click', function() {
            var filter = [];

            $(':checkbox.homepage-check__input').each(function() {
                if ($(this).is(':checked')) {
                    filter.push($(this).data('value'));
                }
            });

            if (filter.length == 0) {
                alert('Нельзя произвести выборку без клубов');
                $(this).prop('checked', true);
                return;
            }

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
//                    var picture = this.button.add('picture', 'добавить изображение');
//                    var videos = this.button.add('videos', 'добавить видео');
//                    var smile = this.button.add('smile', 'смайл');

//                    this.button.addCallback(smile, function () {
//                        //alert('смайл')
//                    });
//                    this.button.addCallback(videos, function () {
//                        //alert('видео')
//                    });
//                    this.button.addCallback(picture, function () {
//                        //alert('изображение')
//                    });

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
            placeholder: 'Введите ваш комментарий',
            focus: true,
            toolbarExternal: '#add-post-toolbar',
            buttons: ['']
        });
    });

</script>
<input type="hidden" id="vk_app" value="<?= $eauth['vkontakte']['client_id'] ?>"/>
<input type="hidden" id="ok_app" value="<?= $eauth['odnoklassniki']['client_id'] ?>"/>
<input type="hidden" id="ok_attach" value='<?= $eauth['odnoklassniki']['attachment'] ?>'/>
<input type="hidden" id="ok_sig" value="<?= $eauth['odnoklassniki']['signature'] ?>"/>
<input type="hidden" id="fb_app" value="<?= $eauth['facebook']['client_id'] ?>"/>
<input type="hidden" id="social_count" value="<?= $socialQuestsCount ?>" />
<div class="alert alert-pos alert-green">
    <div class="position-rel">
        <div class="alert__container">
            <div class="alert__ico alert__ico-green"></div>
            <div class="alert__text alert__text-green">Спасибо, теперь для получения баллов необходимо еще раз нажать на кнопку</div>
        </div><span class="alert__close alert__close-green"></span>
    </div>
</div>
<div class="b-contest-task b-contest__block textalign-c">
    <?php if(/*false &&*/ $socialQuestsCount > 0): ?>
    <div class="b-contest__title">Получи море баллов. Расскажи друзьям</div>
    <p class="b-contest__p margin-t10 margin-b55">Нажми на значок социальной сети и заработай баллы.
    <input type="hidden" id="referal_link" value="<?= $link->getLink() ?>"/>
        <ul class="b-contest-task__list">
        <li class="b-contest-task__li b-contest-task__li_onnoklasniki <?php if (!$this->checkSocialService('ok', $social)): ?>completed<?php endif; ?>"><a href="#" class="b-contest-task__link ico-odnoklasniki" <?php if (!$this->checkSocialService('ok', $social)): ?>style="margin-bottom: 36px; opacity: 0.3;"<?php endif; ?>><?php if ($this->checkSocialService('ok', $social)): ?><span class="b-contest-task__mark"></span></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы<? endif; ?></a></li>
        <li class="b-contest-task__li b-contest-task__li_fb <?php if (!$this->checkSocialService('fb', $social)): ?>completed<?php endif; ?>"><a href="#" class="b-contest-task__link ico-fb" <?php if (!$this->checkSocialService('fb', $social)): ?>style="margin-bottom: 36px; opacity: 0.3;"<?php endif; ?>><?php if ($this->checkSocialService('fb', $social)): ?><span class="b-contest-task__mark"></span></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы<? endif; ?></a></li>
        <li class="b-contest-task__li b-contest-task__li_vk <?php if (!$this->checkSocialService('vk', $social)): ?>completed<?php endif; ?>"><a href="#" class="b-contest-task__link ico-vk" <?php if (!$this->checkSocialService('vk', $social)): ?>style="margin-bottom: 36px; opacity: 0.3;"<?php endif; ?>><?php if ($this->checkSocialService('vk', $social)): ?><span class="b-contest-task__mark"></span></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы<? endif; ?></a></li>
    </ul>
    <?php endif; ?>
    <div class="b-contest-winner__container">
        <div class="b-contest__title">Комментируй и получай баллы</div>
        <p class="b-contest__p margin-t10 margin-b20">Выбрано <span class="popup_clubs_count"><?= $clubsCount ?></span> <?= ContestHelper::getWord($clubsCount, ContestHelper::$themeWords) ?> &nbsp;<span class="hidden-xss">для комментирования &nbsp;</span><a href="#js-b-popup-theme" class="js-b-contest-task__choose b-contest-task__choose">Выбрать</a></p>
        <div class="b-contest-winner__menu">
        <ul class="textalign-c margin-b30">
            <li class="contest-header__li"><a href="<?= \Yii::app()->createUrl('/comments/contest/default/quests', array('type' => 'blog')) ?>" class="b-contest-winner__link <?= $type == 'blog' ? 'b-contest-winner__link-active' : ''?>">Блоги</a></li>
            <li class="contest-header__li"><a href="<?= \Yii::app()->createUrl('/comments/contest/default/quests', array('type' => 'community')) ?>" class="b-contest-winner__link <?= $type == 'community' ? 'b-contest-winner__link-active' : ''?>">Форумы</a></li>
        </ul>
        </div>
        <div class="textalign-l">
            <?php foreach ($posts as $post): ?>
                <?php if ($type == 'community'): ?>
                    <div href="#js-b-popup-modal" class="default-theme" data-id="<?= $post->id?>">
                        <div class="b-froum-theme"><a class="b-froum-theme-img ava__middle ava__female"><img src="<?= $post->author->getAvatarUrl() ?>" alt=""></a>
                            <div class="b-froum-theme-info"><a href="<?= /*$post->author->getUrl()*/'#' ?>" class="name"><?= $post->author->getFullName() ?></a>
                                <time class="time" id="time<?= $post->id ?>"><?= HHtml::timeTag($post, array('class' => 'tx-date'), null); ?></time><a href="<?= /*ContestHelper::getValidPostUrl($post->url)*/'#' ?>" class="b-froum-theme-info-title"><?= $post->title ?></a>
                                <p><?= $post->text ?></p>
                                <div class="b-froum-theme-info-more clearfix">
                                    <div class="float-l lh-34">
                                        <div class="c-list_item_btn"><span class="c-list_item_btn__view"><?= $post->views ?></span><span class="c-list_item_btn__users"><?= $post->getDistinctComments()?></span><a href="#" class="c-list_item_btn__comment"><?=$post->comments_count ?></a></div>
                                    </div>
                                    <div class="float-r"><a href="#js-b-popup-modal" class="js-popup-comment btn btn-ms green-btn" data-id="<?= $post->id ?>"><span class="hidden-smm">Комментировать</span><span class="b-comment-furt visible-smm">></span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($type == 'blog'): ?>
                    <article href="#js-b-popup-modal" class="b-article clearfix b-article__list" data-id="<?= $post->id?>">
                        <div class="b-article_cont clearfix">
                            <div class="b-article_cont-tale"></div>
                            <div class="b-article_header clearfix">
                                <div class="icons-meta">
                                    <div class="c-list_item_btn"><span class="c-list_item_btn__view"><?= $post->views ?></span><span class="c-list_item_btn__comment margin-r0"> <?= $post->getDistinctComments() ?></span></div>
                                </div>
                                <div class="float-l position-rel w-300"><a href="<?= /*$post->author->getUrl()*/ '#' ?>" class="ava ava__female ava__middle-xs ava__middle-sm-mid"><span class="ico-status <?php if($post->author->online): ?>ico-status__online <?php endif; ?>"></span><img src="<?= $post->author->getAvatarUrl() ?>" class="ava_img"></a><a href="<?= /*$post->author->getUrl()*/'#' ?>" class="b-article_author"><?= $post->author->getFullName() ?></a>
                                    <time pubdate="1957-10-04" class="tx-date" id="time<?= $post->id ?>"><?= HHtml::timeTag($post, array('class' => 'tx-date'), null); ?></time>
<!--                                    <div style="display: none" class="b-subscribe">-->
<!--                                        <div class="btn btn-tiny green">Подписаться</div>-->
<!--                                        <div class="b-subscribe_tx">23</div>-->
<!--                                    </div>-->
<!--                                    <div class="b-subscribe"><span class="b-subscribe__done"></span><span class="b-subscribe_tx">23</span></div>-->
                                </div>
                            </div>
                            <div class="b-article_t-list article_t-feed"><a href="<?= /*ContestHelper::getValidPostUrl($post->url)*/'#' ?>" class="b-article_t-a"><?= $post->title ?></a></div>
                            <p><?= $post->preview ?></p>
                            <div class="float-r"><a href="#js-b-popup-modal" class="js-popup-comment btn btn-ms green-btn" data-id="<?= $post->id ?>"><span class="hidden-smm">Комментировать</span><span class="b-comment-furt visible-smm">></span></a></div>
                        </div>
                    </article>
                <?php endif?>
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
                    <div class="add-post__comment">Запись <?= $type == 'blog' ? 'блога' : 'форума' ?></div><span class="js-add-post__close add-post__close"></span>
                </div>
            </div>
        </div>
        <div class="b-contest-winner__container">
            <div class="question">
                <div class="live-user position-rel"><a href="#" class="ava ava__female ava__middle-xs ava__middle-sm-mid"><span class="ico-status ico-status__online"></span><img src="" class="ava_img"></a>
                    <div class="username"><a></a>
                        <time class="tx-date"></time>
                    </div>
<!--                    <div class="b-subscribe">-->
<!--                        <div class="btn btn-tiny green">Подписаться</div>-->
<!--                        <div class="b-subscribe_tx"></div>-->
<!--                    </div>-->
                </div>
                <div class="icons-meta">
                    <div class="c-list_item_btn"><span class="c-list_item_btn__view"></span><a href="#" class="c-list_item_btn__comment margin-r0"></a></div>
                </div><a class="questions_item_heading"></a>
                <div class="question_text">
                </div>
                <div class="queastion__page-nav clearfix">
                    <div class="float-l"><span class="btn btn-xl btn-secondary">Пропустить</span></div>
                    <div class="float-r"><span class="btn btn-xl green-btn">Комментировать</span></div>
                </div>
            </div>
            <form class="answer-form">
                <div class="answer-form__header clearfix">
                    <!-- ava--><span href="<?= $user->getUrl() ?>" class="ava ava__middle ava__female"><img alt="" src="<?= $user->getAvatarUrl() ?>" class="ava_img"></span>
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
