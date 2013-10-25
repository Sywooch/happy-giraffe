<li data-read="<?=$message->read_status?>" data-authorid="<?=$message->user->id?>" data-id="<?=$message->id?>">

    <a href="<?=$message->user->url?>" class="ava small"><?=$message->user->getAvatarUrl(Avatar::SIZE_MICRO) ? CHtml::image($message->user->getAvatarUrl(Avatar::SIZE_MICRO)):''?></a>

    <div class="in">

        <div class="meta">

            <?=CHtml::link($message->user->first_name, $message->user->url, array('class' => 'username'))?>
            <span class="date"><?=HDate::GetFormattedTime($message->created)?></span>
            <span class="read_status"></span>

        </div>

        <div class="content">

            <div class="wysiwyg-content"><?=$message->text?></div>

        </div>

    </div>

</li>

