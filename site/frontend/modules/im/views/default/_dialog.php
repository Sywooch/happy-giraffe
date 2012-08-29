<?php
    $messages = ($contact->userDialog) ? $contact->userDialog->dialog->messages : array();
?>

<div class="dialog-header clearfix" data-userid="<?=$contact->id?>">

    <?php
        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $contact,
            'nav' => true,
            'sendButton' => false,
        ));

    ?>

</div>

<div class="dialog-messages">

       <ul>

            <?php foreach ($messages as $message): ?>
                <?php $this->renderPartial('_message', compact('message', 'lastRead')); ?>
            <?php endforeach; ?>

        </ul>

    <?php if ($contact->userDialog === null || empty($messages)): ?>

        <div class="empty">

            <p>В этом диалоге нет сообщений.<br/>Ваше может быть первым!</p>

        </div>

    <?php endif; ?>

</div>