<?php
    $cs = Yii::app()->clientScript;

    $cs->registerScriptFile('/javascripts/messages.js');
?>

<div id="user-dialogs" class="clearfix has-wannachat">

    <div class="header">

        <div class="title">
            <span>Мои диалоги</span>
        </div>

        <div class="nav">
            <ul id="user-dialogs-nav">
                <li><a onclick="Messages.setList(0);" href="javascript:void(0)">Все</a></li>
                <li><a onclick="Messages.setList(1);" href="javascript:void(0)">Новые</a><span class="count">5</span></li>
                <li><a onclick="Messages.setList(2);" href="javascript:void(0)">Кто в онлайне</a><span class="count">10</span></li>
                <li><a onclick="Messages.setList(3);" href="javascript:void(0)">Друзья на сайте</a><span class="count">6</span></li>
            </ul>
        </div>

        <div class="search">
            <input type="search" placeholder="Найти по имени" />
        </div>

        <a href="" class="close">Закрыть диалоги</a>

    </div>

    <div class="contacts">

        <div class="list">

            <ul id="user-dialogs-contacts">



            </ul>

        </div>

        <div class="wannachat clearfix">

            <div class="block-title">
                <span>Хотят общаться</span>
            </div>

            <ul>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>
                <li><a href="" class="ava small"></a></li>

            </ul>

        </div>

    </div>

    <div class="dialog">

        <div class="dialog-header clearfix">

            <div class="user-info medium">

                <a href="" class="ava female"></a>

                <div class="details">

                    <span class="icon-status status-online"></span>

                    <a href="" class="username">Александр Богоявленский</a>

                    <div class="location">
                        <div class="flag-big flag-big-ru"></div> Магадан
                    </div>

                    <div class="user-fast-nav">
                        <ul>
                            <a href="">Анкета</a>&nbsp;|&nbsp;<a href="">Блог</a>&nbsp;|&nbsp;<a href="">Фото</a>&nbsp;|&nbsp;<a href="">Что нового</a>&nbsp;|&nbsp;<span class="drp-list"><a href="" class="more">Еще</a><ul><li><a href="">Семья</a></li><li><a href="">Друзья</a></li></ul>
                            </span>

                        </ul>
                    </div>

                </div>

            </div>

        </div>

        <div class="dialog-messages">

            <ul>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>
                            <span class="message-label label-unread">Сообщение не прочитано</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>
                            <span class="message-label label-read">Сообщение прочитано</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная. Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>
                            <span class="message-label label-unread">Сообщение не прочитано</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>
                            <span class="message-label label-read">Сообщение прочитано</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная. Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>
                            <span class="message-label label-unread">Сообщение не прочитано</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>
                            <span class="message-label label-read">Сообщение прочитано</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

                <li>

                    <a href="" class="ava small male"></a>

                    <div class="in">

                        <div class="meta">

                            <a href="" class="username">Анастасия</a>
                            <span class="date"> 28 янв 2012, 13:45</span>

                        </div>

                        <div class="content">

                            <div class="wysiwyg-content"><p>Привет! Очень рада за вас, вот для твоего сына новая колыбельная. Привет! Очень рада за вас, вот для твоего сына новая колыбельная</p></div>

                        </div>

                    </div>

                </li>

            </ul>

        </div>

        <div class="dialog-input clearfix">

            <div class="input"><textarea placeholder="Введите ваше сообщение"></textarea></div>

            <div class="btn"><button>Отправить сообщение</button></div>

        </div>

    </div>

</div>