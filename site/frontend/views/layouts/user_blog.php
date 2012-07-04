<?php $this->beginContent('//layouts/main'); ?>

<?php
$cs = Yii::app()->clientScript;
$cs
    ->registerCssFile('/stylesheets/user.css')
;
?>

<div id="user">

    <div class="user-cols clearfix">

        <div class="col-1">

            <div class="clearfix">
                <?php
                $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $this->user,
                    'location' => false,
                    'friendButton' => true,
                    'nav' => true,
                    'status' => true,
                ));
                ?>
            </div>


            <div class="club-topics-list-new">

                <div class="block-title">О чем мой блог</div>

                <ul>
                    <?php foreach($this->user->blog_rubrics as $r): ?>
                    <?=CHtml::openTag('li', $this->rubric_id == $r->id ? array('class' => 'active') : array())?><span><?=CHtml::link($r->title, $this->getUrl(array('rubric_id' => $r->id)))?></span><div class="count"><?=$r->contentsCount?></div></li>
                    <?php endforeach; ?>
                </ul>

            </div>


            <div class="fast-articles">

                <div class="block-title">
                    <i class="icon-popular"></i> Самое популярное
                </div>

                <ul>
                    <?php foreach ($this->user->blogPopular as $b): ?>
                    <li>
                        <div class="item-title"><?=CHtml::link($b->title, $b->url)?></div>
                        <div class="meta">
                            <div class="rating"><?=$b->rate?></div>
                            <span class="views">Просмотров:&nbsp;&nbsp;<?=PageView::model()->viewsByPath($b->url)?></span><br/>
                            <span class="comments"><?=CHtml::link('Комментариев:&nbsp;&nbsp;' . $b->commentsCount, $b->getUrl(true))?></span>
                        </div>
                    </li>
                    <?php endforeach; ?>

                </ul>

            </div>


            <div class="readers">

                <div class="block-title"><i class="icon-readers"></i>Постоянные читатели <span>(185)</span></div>

                <ul class="clearfix">
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>
                    <li>
                        <a href="" class="ava small"></a>
                    </li>

                </ul>

                <div class="add-author-btn"><a href=""><img src="/images/btn_add_author.png" /></a></div>

            </div>


            <div class="fast-photos">

                <div class="block-title"><span>МОИ</span>свежие<br/>фото</div>

                <div class="preview">
                    <img src="/images/album_photo_04.jpg" class="img-1">
                    <img src="/images/album_photo_05.jpg" class="img-2">
                    <img src="/images/album_photo_06.jpg" class="img-3">
                </div>

                <a href="" class="more"><i class="icon"></i>Смотреть</a>

            </div>


            <div class="banner-box">
                <a href="<?=$this->createUrl('/cook/spices')?>"><img src="/images/banner_05.png" /></a>
            </div>

        </div>

        <div class="col-23 clearfix">

            <div class="new-blog-btn"><a href="" class="btn btn-orange-smallest"><span><span>Создать блог</span></span></a></div>

            <div class="blog-title">Блог Александра Богоявленского</div>

            <?=$content?>

        </div>

    </div>



</div>

<?php $this->endContent(); ?>