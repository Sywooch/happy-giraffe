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
                <li><a onclick="Messages.setList(1);" href="javascript:void(0)">Новые</a><span class="count" id="user-dialogs-newCount"><?=$newCount?></span></li>
                <li><a onclick="Messages.setList(2);" href="javascript:void(0)">Кто в онлайне</a><span class="count" id="user-dialogs-onlineCount"><?=$onlineCount?></span></li>
                <li><a onclick="Messages.setList(3);" href="javascript:void(0)">Друзья на сайте</a><span class="count" id="user-dialogs-friendsCount"><?=$friendsCount?></span></li>
            </ul>
        </div>

        <div class="search">
            <input type="search" placeholder="Найти по имени" />
        </div>

        <a href="javascript:void(0)" class="close" onclick="closeMessages();">Закрыть диалоги</a>

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

        <div id="user-dialogs-dialog">

        </div>

        <div class="dialog-input clearfix">

            <div class="input"><textarea placeholder="Введите ваше сообщение"></textarea></div>

            <div class="btn"><button>Отправить сообщение</button></div>

        </div>

    </div>

</div>