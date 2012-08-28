<li>

    <a href="<?=$message->user->url?>" class="ava small"><?=$message->user->getAva('small') ? CHtml::image($message->user->getAva('small')):''?></a>

    <div class="in">

        <div class="meta">

            <?=CHtml::link($message->user->first_name, $message->user->url, array('class' => 'username'))?>
            <span class="date"><?=HDate::GetFormattedTime($message->created)?></span>

        </div>

        <div class="content">

            <div class="wysiwyg-content"><?=$message->text?></div>

        </div>

    </div>

</li>

