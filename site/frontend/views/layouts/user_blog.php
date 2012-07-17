<?php $this->beginContent('//layouts/main'); ?>

<?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerScriptFile('/javascripts/album.js')
        ->registerCssFile('/stylesheets/user.css')
    ;
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

            <div class="club-topics-list-new">

                <div class="block-title">О чем мой блог</div>

                <?php
                    $items = array();

                    foreach ($this->user->blog_rubrics as $rubric) {
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

                <div class="block-title"><i class="icon-readers"></i>Постоянные читатели <span>(<?=$this->user->friendsCount?>)</span></div>

                <ul class="clearfix">
                    <?php
                        $dp = $this->user->getFriends(array('limit' => 30, 'order' => 'RAND()'));
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

            <div class="fast-photos">

                <div class="block-title"><span>МОИ</span>свежие<br/>фото</div>

                <div class="preview">
                    <?php $i = 0; foreach ($this->user->getRelated('photos', false, array('limit' => 3, 'order' => 'created DESC')) as $p): ?>
                        <?=CHtml::image($p->getPreviewUrl(180, 180), null, array('class' => 'img-' . ++$i))?>
                    <?php endforeach; ?>
                </div>

                <?=CHtml::link('<i class="icon"></i>Смотреть', array('albums/user', 'id' => $this->user->id), array('class' => 'more'))?>

            </div>


            <div class="banner-box">
                <a href="<?=$this->createUrl('/cook/spices')?>"><img src="/images/banner_05.png" /></a>
            </div>

        </div>

        <div class="col-23 clearfix">

            <?php if (Yii::app()->user->isGuest): ?>
                <div class="new-blog-btn"><a href="#login" class="btn btn-orange-smallest fancy"><span><span>Создать блог</span></span></a></div>'
            <?php endif; ?>

            <div class="blog-title"><?=($this->user->blog_title === null) ? 'Мой личный блог' : $this->user->blog_title?><?php if ($this->user->id == Yii::app()->user->id):?> <a href="#blogSettings" class="settings fancy tooltip" title="Настройка блога"></a><?php endif; ?></div>

            <?=$content?>

        </div>

    </div>



</div>

<div style="display: none;">

    <div id="blogSettings" class="popup">

        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close tooltip" title="Закрыть"></a>

        <div class="popup-title">Настройки блога</div>

        <!--<div class="default-nav">
            <ul>
                <li class="active"><a href="">Название блога</a></li>
                <li class="disabled"><a>Рубрики блога</a></li>
                <li class="disabled"><a>Оформление блога</a></li>
            </ul>
        </div>-->

        <?php
            $form = $this->beginWidget('CActiveForm', array(
                'action' => array('/ajax/setValues/'),
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnType' => true,
                ),
                'htmlOptions' => array(
                    'onsubmit' => 'ajaxSetValues(this, function(response) {if (response) {$.fancybox.close();}}); return false;',
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

</div>

<?php $this->endContent(); ?>