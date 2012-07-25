<?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/user.css')
    ;
?>

<div id="user">

    <div class="main">
        <div class="main-in">

            <div class="content-title-new">
                Что нового
            </div>

            <div id="user-activity">

                <div class="clearfix">

                    <div class="calendar-date">
                        <div class="y">2011</div>
                        <div class="d">24</div>
                        <div class="m">янв</div>
                    </div>

                    <div class="activity-list">

                        <?php foreach ($actions as $action): ?>
                            <?php $this->renderPartial('activity/' . $action->type, compact('action')); ?>
                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="side-left">

        <div class="clearfix user-info-big">
            <div class="user-info">
                <div class="ava female"></div>
                <div class="details">
                    <span class="icon-status status-online"></span>
                    <a href="" class="username">Але</a>
                    <div class="user-fast-buttons">
                        <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                        <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                    </div>
                    <div class="user-fast-nav">
                        <ul>
                            <a href="">Анкета</a> &nbsp;|&nbsp; <a href="">Блог</a> &nbsp;|&nbsp; <span class="drp-list"><a href="" class="more">Еще</a><ul><li><a href="">Семья</a></li><li><a href="">Друзья</a></li></ul>
                                            </span>
                        </ul>
                    </div>
                </div>
                <div class="text-status">
                    <p>Привет всем! У меня все ok! Единственное, что имеет значение.</p>
                    <span class="tale"></span>
                </div>
            </div>
        </div>

        <div class="user-joined">
            <div class="calendar-date">
                <div class="y">2011</div>
                <div class="d">24</div>
                <div class="m">янв</div>
            </div>
            <span>Присоединился к «Весёлому Жирафу»</span>
        </div>

    </div>

</div>