<?php if ($communityContents): ?>

    <div class="box activity-popular club">

        <div class="title">Популярное <span>в клубах</span></div>

        <ul>
            <?php foreach ($communityContents as $i => $c): ?>
            <li>
                <div class="place place-<?=$i+1?>"><i class="icon"></i><?=$i+1?> место</div>
                <div class="clearfix">
                    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $c->author, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
                </div>
                <div class="item-title"><?=CHtml::link(CHtml::encode($c->title), $c->url)?></div>
                <div class="content"><?=$c->getShort(178)?></div>
                <div class="meta">
                    <span class="rating"><?=$c->rate?></span>
                    <span class="views">Просмотров: <?=PageView::model()->viewsByPath($c->url)?></span>
                    <span class="comments"><a href="<?=$c->getUrl(true)?>">Комментариев: <?=$c->commentsCount?></a></span>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

    </div>

<?php endif; ?>