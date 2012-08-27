<li>

    <a href="<?=$message->user->url?>" class="ava small"><?=$message->user->getAva('small') ? CHtml::image($message->user->getAva('small')):''?></a>

    <div class="in">

        <div class="meta">

            <?=CHtml::link($message->user->first_name, $message->user->url, array('class' => 'username'))?>
            <span class="date"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $message->created); ?></span>
            <?php if ($message->user_id == Yii::app()->user->id): ?>
                <?php if ($message->read_status == 0): ?>
                    <span class="message-label label-unread">Сообщение не прочитано</span>
                <?php elseif ($message->id == $lastRead): ?>
                    <span class="message-label label-read">Сообщение прочитано</span>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <div class="content">

            <div class="wysiwyg-content"><?=$message->text?></div>

        </div>

    </div>

</li>