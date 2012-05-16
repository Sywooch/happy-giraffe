<div class="box activity-popular">

    <div class="title">Популярное <span>в блогах</span></div>

    <ul>
        <?php foreach ($communityContents as $i => $c): ?>
        <li>
            <div class="place place-<?=$i+1?>"><i class="icon"></i><?=$i+1?> место</div>
            <div class="clearfix">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $c->author, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
            </div>
            <div class="item-title"><?=CHtml::link($c->title, $c->url)?></div>
            <div class="content"><?=$c->short?></div>
            <div class="meta">
                <span class="rating"><?=$c->rate?></span>
                <span class="views">Просмотров: <?=PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $c->url), true)?></span>
                <span class="comments"><a href="">Комментариев: <?=$c->commentsCount?></a></span>
            </div>
        </li>
        <?php endforeach; ?>

    </ul>

</div>

<div class="box activity-popular club">

    <div class="title">Популярное <span>в клубах</span></div>

    <ul>
        <li>
            <div class="place place-1"><i class="icon"></i>1 место</div>
            <div class="clearfix">
                <div class="user-info clearfix">
                    <a class="ava small female"></a>
                    <div class="details">
                        <span class="icon-status status-online"></span>
                        <a href="" class="username">Александр Богоявленский</a>
                    </div>
                </div>
            </div>
            <div class="item-title"><a href="">Проблемы с неврологией</a></div>
            <div class="content"><a href=""><img src="/images/activity_blog_popular_img.jpg" /></a></div>
            <div class="meta">
                <span class="rating">286</span>
                <span class="views">Просмотров: 985</span>
                <span class="comments"><a href="">Комментариев: 28</a></span>
            </div>
        </li>
        <li>
            <div class="place place-2"><i class="icon"></i>2 место</div>
            <div class="clearfix">
                <div class="user-info clearfix">
                    <a class="ava small female"></a>
                    <div class="details">
                        <span class="icon-status status-online"></span>
                        <a href="" class="username">Богоявленский</a>
                    </div>
                </div>
            </div>
            <div class="item-title"><a href="">Проблемы с неврологией и психиатрией в раннем возрасте</a></div>
            <div class="meta">
                <span class="rating">286</span>
                <span class="views">Просмотров: 985</span>
                <span class="comments"><a href="">Комментариев: 28</a></span>
            </div>
        </li>
        <li>
            <div class="place place-3"><i class="icon"></i>3 место</div>
            <div class="clearfix">
                <div class="user-info clearfix">
                    <a class="ava small female"></a>
                    <div class="details">
                        <span class="icon-status status-online"></span>
                        <a href="" class="username">Богоявленский</a>
                    </div>
                </div>
            </div>
            <div class="item-title"><a href="">Проблемы с неврологией и психиатрией в раннем возрасте</a></div>
            <div class="meta">
                <span class="rating">286</span>
                <span class="views">Просмотров: 985</span>
                <span class="comments"><a href="">Комментариев: 28</a></span>
            </div>
        </li>

    </ul>

</div>

<?php if (false): ?>
    <h1>Популярное</h1>

    <h3>В клубах</h3>
    <ul>
        <?php foreach ($communityContents as $i => $c): ?>
            <li><?=++$i?>. <?=$c->title?> - <?=$c->rate?></li>
        <?php endforeach; ?>
    </ul>

    <h3>В блогах</h3>
    <ul>
        <?php foreach ($blogContents as $i => $c): ?>
        <li><?=++$i?>. <?=$c->title?> - <?=$c->rate?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>