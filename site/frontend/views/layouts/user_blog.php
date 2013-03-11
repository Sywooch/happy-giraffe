<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerScriptFile('/javascripts/album.js')
        ->registerCssFile('/stylesheets/user.css')
    ;

    $blogFontColor = UserAttributes::get($this->user->id, 'blogFontColor', 0);
    $blogFontStyle = UserAttributes::get($this->user->id, 'blogFontStyle', 0);
?>

<div id="user">

    <div class="user-cols clearfix">

        <div class="col-1">

            <div class="clearfix user-info-big">
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

            <?php if (Yii::app()->user->id == $this->user->id): ?>
                <div class="add-post-btn">
                    <?=CHtml::link(CHtml::image('/images/btn_add_post.png'), $this->getUrl(array('content_type_slug' => null), 'blog/add'))?>
                </div>
            <?php endif; ?>

            <?php if($this->beginCache('blog-rubrics', array(
                'duration' => 600,
                'dependency' => array(
                    'class' => 'CDbCacheDependency',
                    'sql' => 'SELECT MAX(updated) FROM community__contents c
                        JOIN community__rubrics r ON c.rubric_id = r.id
                        WHERE r.user_id = ' . $this->user->id,
                ),
                'varyByParam' => array('user_id', 'rubric_id'),
            ))): ?>

                <div class="club-topics-list-new">

                    <div class="block-title">О чем мой блог</div>

                    <?php
                        $items = array();

                        foreach ($this->user->blog_rubrics as $rubric) {
                            if ($rubric->contentsCount > 0)
                                $items[] = array(
                                    'label' => $rubric->title,
                                    'url' => $this->getUrl(array('rubric_id' => $rubric->id)),
                                    'template' => '<span>{menu}</span><div class="count">' . $rubric->contentsCount . '</div>',
                                    'active' => $rubric->id == $this->rubric_id,
                                );
                        }

                        $this->widget('zii.widgets.CMenu', array(
                            'items' => $items,
                        ));
                    ?>

                </div>

            <?php $this->endCache(); endif;  ?>

            <?php
                //$this->widget('application.widgets.blog.attendanceWidget.AttendanceWidget', array(
                //    'user_id' => $this->user->id,
                //));
            ?>

            <?php if($this->beginCache('blog-popular', array(
                'duration' => 600,
                'varyByParam' => array('user_id'),
            ))): ?>

                <?php if ($this->user->blogPopular): ?>
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
                <?php endif; ?>

            <?php $this->endCache(); endif;  ?>

            <?php if($this->beginCache('blog-readers', array(
                'duration' => 600,
                'dependency' => array(
                    'class' => 'CDbCacheDependency',
                    'sql' => 'SELECT MAX(created) FROM friends
                        WHERE user1_id = ' . $this->user->id . ' OR user2_id = ' . $this->user->id,
                ),
                'varyByParam' => array('user_id'),
            ))): ?>

                <div class="readers">

                    <div class="block-title"><i class="icon-readers"></i>Постоянные читатели <span>(<?=$this->user->friendsCount?>)</span></div>

                    <ul class="clearfix">
                        <?php
                            $dp = $this->user->getFriends(array('condition'=>'blocked = 0 AND deleted = 0', 'limit' => 30, 'order' => 'RAND()', 'with'=>'avatar'));
                            $dp->pagination = array(
                                'pageSize' => 30,
                            );
                        ?>
                        <?php foreach ($dp->data as $u): ?>
                            <?php
                            $class = 'ava small';
                            if ($u->gender !== null) $class .= ' ' . (($u->gender) ? 'male' : 'female');
                            ?>
                            <li><?=CHtml::link(CHtml::image($u->getAva('small')), $u->url, array('class' => $class))?></li>
                        <?php endforeach; ?>

                    </ul>

                    <!--<div class="add-author-btn"><a href=""><img src="/images/btn_add_author.png" /></a></div>-->

                </div>

            <?php $this->endCache(); endif;  ?>

            <?php if (!$this->user->deleted):?>
                <?php if($this->beginCache('blog-photos', array(
                    'duration' => 600,
                    'dependency' => array(
                        'class' => 'CDbCacheDependency',
                        'sql' => 'SELECT MAX(p.created) FROM album__photos p
                            JOIN album__albums a ON p.album_id = a.id
                            WHERE a.type = 0 AND p.author_id = ' . $this->user->id,
                    ),
                    'varyByParam' => array('user_id'),
                ))): ?>

                    <?php $photos = $this->user->getRelated('photos', false, array('limit' => 3, 'order' => 'photos.created DESC', 'scopes'=>array('active'), 'with'=>array('album'=>array('condition'=>'album.type = 0')))); ?>
                    <?php if (count($photos)>0):?>
                        <div class="fast-photos">

                            <div class="block-title"><span>МОИ</span>свежие<br/>фото</div>

                            <div class="preview">
                                <?php $i = 0; foreach($photos as $p): ?>
                                    <?=CHtml::image($p->getPreviewUrl(150, 150), $p->title, array('class' => 'img-' . ++$i))?>
                                <?php endforeach; ?>
                            </div>

                            <?=CHtml::link('<i class="icon"></i>Смотреть', array('albums/user', 'id' => $this->user->id), array('class' => 'more'))?>

                        </div>
                    <?php endif ?>

                <?php $this->endCache(); endif;  ?>
            <?php endif ?>


            <div class="banner-box">
                <a href="<?=$this->createUrl('/contest/default/view', array('id' => 9)) ?>"><img
                    src="/images/contest/banner-w240-9.jpg"></a>
                <?//=$this->renderPartial('//_banner')?>
            </div>

        </div>

        <div class="col-23 clearfix">

            <?php if (Yii::app()->user->isGuest): ?>
                <div class="new-blog-btn"><a href="#login" class="btn btn-orange-smallest fancy"><span><span>Создать блог</span></span></a></div>
            <?php endif; ?>

            <div class="blog-title font-color-<?=$blogFontColor?> font-<?=$blogFontStyle?>"><?=($this->user->blog_title === null) ? 'Блог - ' . $this->user->fullName : $this->user->blog_title?><?php if ($this->user->id == Yii::app()->user->id):?> <a href="#blogSettings" class="settings fancy tooltip" title="Настройка блога"></a><?php endif; ?></div>

            <?=$content?>

        </div>

    </div>



</div>

<div style="display: none;">

    <div id="blogSettings" class="popup">

        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>

        <div class="popup-title">Настройки блога</div>

        <div class="tabs">

            <div class="default-nav">
                <ul>
                    <li class="active"><a href="javascript:void(0)" onclick="setTab(this, 1);">Название блога</a></li>
                    <?php if (Yii::app()->user->id == $this->user->id && $this->user->hasFeature(3)): ?>
                        <li><a href="javascript:void(0)" onclick="setTab(this, 2);">Оформление блога</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="tab-box tab-box-1" style="display: block;">

                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => array('/ajax/setValues/'),
                        'enableAjaxValidation' => true,
                        'clientOptions' => array(
                            'validateOnType' => true,
                        ),
                        'htmlOptions' => array(
                            'onsubmit' => 'ajaxSetValues(this, function(response) {if (response) {$.fancybox.close(); window.location.reload();}}); return false;',
                        ),
                    ));
                    $model = $this->user;
                ?>
                <?=CHtml::hiddenField('entity', get_class($model))?>
                <?=CHtml::hiddenField('entity_id', $model->id)?>

                <div class="settings-form">
                    <div class="row">
                        <div class="row-title">Название <span>(не более 30 знаков)</span></div>
                        <div class="row-elements"<?php if (! $model->blog_title): ?> style="display: none;"<?php endif; ?>>
                            <span class="item-title"><?=$model->blog_title?></span>
                            <a href="javascript:void(0)" onclick="Album.updateField(this)" class="edit tooltip" title="Редактировать название альбома"></a>
                        </div>
                        <div class="row-elements"<?php if ($model->blog_title): ?> style="display: none;"<?php endif; ?>>
                            <?=$form->textField($model, 'blog_title', array('placeholder' => 'Введите название альбома'))?>
                            <button onclick="Album.updateFieldSubmit(this, '.item-title'); return false;" class="btn btn-green-small"><span><span>Ok</span></span></button>
                        </div>
                        <?=$form->error($model, 'blog_title')?>

                    </div>
                </div>

                <div class="bottom">
                    <button class="btn btn-green-medium"><span><span>Сохранить настройки</span></span></button>
                </div>

                <?php $this->endWidget(); ?>

            </div>

            <?php if (Yii::app()->user->id == $this->user->id && $this->user->hasFeature(3)): ?>

                <div class="headings-style tab-box tab-box-2">
                    <!-- google fonts -->
                    <script type="text/javascript">
                        WebFontConfig = {
                            google: { families: [ 'Bad+Script::latin,cyrillic', 'Istok+Web::latin,cyrillic', 'Ruslan+Display::latin,cyrillic', 'Marck+Script::latin,cyrillic', 'Oranienbaum::latin,cyrillic', 'Lobster::latin,cyrillic', 'Russo+One::latin,cyrillic', 'Stalinist+One::latin,cyrillic', 'Comfortaa::latin,cyrillic' ] }
                        };
                        (function() {
                            var wf = document.createElement('script');
                            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                            wf.type = 'text/javascript';
                            wf.async = 'true';
                            var s = document.getElementsByTagName('script')[0];
                            s.parentNode.insertBefore(wf, s);
                        })(); </script>

                    <div class="clearfix">
                        <div class="fonts-style">
                            <p>Выберите шрифт</p>
                            <ul class="pattern-list clearfix">
                                <?php for ($i = 0; $i <= 9; $i++): ?>
                                    <li><a href="javascript:void(0)" onclick="Features.selectFeature('blogFontStyle', <?=$i?>, function(){Features.blogFontStyle(<?=$i?>)})"<?php if ($blogFontStyle == $i): ?> class="active"<?php endif; ?>><span class="pattern font-<?=$i?>"><?=($i == 0) ? 'Обычный' : 'Мой блог'?></span></a></li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                        <div class="color-style">
                            <p>Выберите цвет</p>
                            <ul class="pattern-list clearfix">
                                <?php for ($i = 0; $i <= 6; $i++): ?>
                                    <li><a href="javascript:void(0)" onclick="Features.selectFeature('blogFontColor', <?=$i?>, function(){Features.blogFontColor(<?=$i?>)})"<?php if ($blogFontColor == $i): ?> class="active"<?php endif; ?>><span class="pattern font-color-<?=$i?>"></span></a></li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="heading-preview font-color-<?=$blogFontColor?> font-<?=$blogFontStyle?>" data-font-color="<?=$blogFontColor?>" data-font-style="<?=$blogFontStyle?>">
                        Говорим о коллекциях и не только
                    </div>
                    <div class="bottom">
                        <button class="btn-green btn-green-medium" onclick="window.location.reload()">Сохранить настройки</button>
                    </div>
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php $this->endContent(); ?>