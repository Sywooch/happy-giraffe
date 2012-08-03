<div class="box homepage-blogs">

    <div class="title">Блоги <span>мам и пап</span></div>

    <ul>
        <?php foreach ($contents as $c): ?>
            <li>
                <div class="clearfix">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                        'user' => $c->contentAuthor,
                        'size' => 'small',
                        'sendButton' => false,
                        'location' => false,
                    )); ?>
                </div>
                <b><?=CHtml::link($c->title, $c->url)?></b>
                <a href="<?=$c->url ?>"><div class="img"><?=$c->getShort()?></div></a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>