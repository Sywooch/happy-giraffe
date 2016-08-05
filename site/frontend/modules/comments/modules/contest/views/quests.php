<?php
$this->pageTitle = $this->contest->name . ' - Задания';
?>

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
        <li class="b-contest-task__li b-contest-task__li_onnoklasniki"><a href="#" class="b-contest-task__link ico-odnoklasniki"></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы</a></li>
        <li class="b-contest-task__li b-contest-task__li_fb"><a href="#" class="b-contest-task__link ico-fb"><span class="b-contest-task__mark"></span></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы</a></li>
        <li class="b-contest-task__li b-contest-task__li_vk"><a href="#" class="b-contest-task__link ico-vk"><span class="b-contest-task__mark"></span></a><a href="#" class="btn btn-ms green-btn margin-t18">Получить баллы</a></li>
    </ul>
    <div class="b-contest-winner__container">
        <div class="b-contest__title">Комментируй и получай баллы</div>
        <p class="b-contest__p margin-t10 margin-b20">Выбрано 22 темы &nbsp;<span class="hidden-xss">для комментирования &nbsp;</span><a href="#js-b-popup-theme" class="js-b-contest-task__choose b-contest-task__choose">Выбрать</a></p>
        <ul class="textalign-c margin-b30">
            <li class="contest-header__li"><a class="b-contest-winner__link">Блоги</a></li>
            <li class="contest-header__li"><a class="b-contest-winner__link b-contest-winner__link-active">Форумы</a></li>
        </ul>
        <div class="textalign-l">
            <div class="default-theme">
                <div class="b-froum-theme"><a class="b-froum-theme-img ava__middle ava__female"><img src="/images/icons/ava.jpg" alt=""></a>
                    <div class="b-froum-theme-info"><a href="#" class="name">Виктория Петрова</a>
                        <time class="time">5 минут назад</time><a href="#" class="b-froum-theme-info-title">Книжечка для разговоров</a>
                        <p>Купила я наконец блокнотик, специально для того, что бы записывать перлы моего старшего сыночка. У моей мамы такая</p>
                        <div class="b-froum-theme-info-more clearfix">
                            <div class="float-l lh-34">
                                <div class="c-list_item_btn"><span class="c-list_item_btn__view">589</span><span class="c-list_item_btn__users">6</span><a href="#" class="c-list_item_btn__comment">28</a></div>
                            </div>
                            <div class="float-r"><a href="#js-b-popup-modal" class="js-popup-comment btn btn-ms green-btn"><span class="hidden-smm">Комментировать</span><span class="b-comment-furt visible-smm">></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="default-theme">
                <div class="b-froum-theme"><a class="b-froum-theme-img ava__middle ava__female"><img src="/images/icons/ava.jpg" alt=""></a>
                    <div class="b-froum-theme-info"><a href="#" class="name">Виктория Петрова</a>
                        <time class="time">5 минут назад</time><a href="#" class="b-froum-theme-info-title">Книжечка для разговоров</a>
                        <p>Купила я наконец блокнотик, специально для того, что бы записывать перлы моего старшего сыночка. У моей мамы такая</p>
                        <div class="b-froum-theme-info-more clearfix">
                            <div class="float-l lh-34">
                                <div class="c-list_item_btn"><span class="c-list_item_btn__view">589</span><span class="c-list_item_btn__users">6</span><a href="#" class="c-list_item_btn__comment">28</a></div>
                            </div>
                            <div class="float-r"><a href="#js-b-popup-modal" class="js-popup-comment btn btn-ms green-btn"><span class="hidden-smm">Комментировать</span><span class="b-comment-furt visible-smm">></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="default-theme">
                <div class="b-froum-theme"><a class="b-froum-theme-img ava__middle ava__female"><img src="/images/icons/ava.jpg" alt=""></a>
                    <div class="b-froum-theme-info"><a href="#" class="name">Виктория Петрова</a>
                        <time class="time">5 минут назад</time><a href="#" class="b-froum-theme-info-title">Книжечка для разговоров</a>
                        <p>Купила я наконец блокнотик, специально для того, что бы записывать перлы моего старшего сыночка. У моей мамы такая</p>
                        <div class="b-froum-theme-info-more clearfix">
                            <div class="float-l lh-34">
                                <div class="c-list_item_btn"><span class="c-list_item_btn__view">589</span><span class="c-list_item_btn__users">6</span><a href="#" class="c-list_item_btn__comment">28</a></div>
                            </div>
                            <div class="float-r"><a href="#js-b-popup-modal" class="js-popup-comment btn btn-ms green-btn"><span class="hidden-smm">Комментировать</span><span class="b-comment-furt visible-smm">></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </p>
</div>
