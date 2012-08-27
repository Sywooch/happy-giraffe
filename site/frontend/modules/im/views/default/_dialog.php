<?php
    $messages = $contact->userDialog->dialog->messages;
?>

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

    <?php if (! $messages): ?>

        <div class="empty">

            <p>В этом диалоге нет новых сообщений.<br/>Ваше может быть первым!</p>

        </div>

    <?php else: ?>

        <ul>

            <?php foreach ($messages as $message): ?>
                <?php $this->renderPartial('_message', compact('message')); ?>
            <?php endforeach; ?>

        </ul>

    <?php endif; ?>

</div>