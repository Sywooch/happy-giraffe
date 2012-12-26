<?php
    $messages = ($contact->userDialog) ? $contact->userDialog->dialog->messages : array();
?>

<div class="dialog-header clearfix" data-userid="<?=$contact->id?>">

    <?php if ($contact->id == User::HAPPY_GIRAFFE):?>
    <div class="user-info ava-happy-giraffe medium">

        <span class="ava"><img src="/images/ava_happy_giraffe.png" alt=""></span>

        <div class="details"><span class="username">Веселый Жираф</span></div>

    </div>
    <?php else: ?>
        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $contact,
            'nav' => true,
            'sendButton' => false,
        ));?>
    <?php endif ?>

</div>

<div class="dialog-messages">
    <?php if ($contact->id == User::HAPPY_GIRAFFE): ?>

        <div class="letter-happy-giraffe">
            <span class="ava small male"><img src="/images/ava_happy_giraffe_small.png" alt=""></span>
            <div class="in ava-happy-giraffe">
                <div class="meta">
                    <span class="username">Веселый Жираф</span>
                    <span class="date"> <?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", Yii::app()->user->model->register_date)?></span>
                </div>
            </div>
            <div class="letter-title">Привет, <?=Yii::app()->user->first_name?>! <img src="/images/widget/smiles/smile3.gif" class="smile"></div>
            <div class="letter-text">
                <p> Вы знаете, что у жирафа самое большое сердце из всех наземных животных? А это значит, что жираф - самое радушное, самое доброе и отзывчивое животное на планете Земля! Присоединившись к нашему интернет-сообществу вы сами убедитесь в этом! Тысячи мам и пап каждый день общаются на &laquo;Веселом Жирафе&raquo;, делятся советами, знакомятся с новыми друзьями.</p>
                <p>Несколько десятков клубов, блоги пользователей, полезные сервисы, и масса экспертных статей - все это делает &laquo;Веселого Жирафа&raquo; уникальным порталом, полюбившимся тысячам пользователей со всего мира.</p>
                <p>Проводите время интересно и полезно!</p>
            </div>
        </div>

    <?php else: ?>

        <?php if ($contact->userDialog === null || empty($messages)): ?>

        <ul>
            <li class="empty">

                <p>В этом диалоге нет сообщений.<br/>Ваше может быть первым!</p>

            </li>
        </ul>
        <?php else: ?>

            <ul>

                <?php foreach ($messages as $message): ?>
                <?php $this->renderPartial('_message', compact('message', 'lastRead')); ?>
                <?php endforeach; ?>

            </ul>

        <?php endif; ?>

    <?php endif; ?>

</div>