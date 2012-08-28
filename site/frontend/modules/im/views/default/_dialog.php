<?php
    $messages = ($contact->userDialog) ? $contact->userDialog->dialog->messages : array();
?>

<div class="dialog-header clearfix">

    <?php
        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $contact,
            'nav' => true,
            'sendButton' => false,
        ));

    ?>

    <?php if (false): ?>

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

    <?php endif; ?>

</div>

<div class="dialog-messages">

    <?php if ($contact->userDialog !== null && ! empty($messages)): ?>

        <ul>

            <?php foreach ($messages as $message): ?>
                <?php $this->renderPartial('_message', compact('message', 'lastRead')); ?>
            <?php endforeach; ?>

        </ul>

    <?php else: ?>

        <div class="empty">

            <p>В этом диалоге нет сообщений.<br/>Ваше может быть первым!</p>

        </div>

    <?php endif; ?>

</div>