<?php
/**
 * @var Contest $model
 * @var AlbumPhoto $photo
 */
$work = $photo->getAttachByEntity('ContestWork')->model;
$collection = new ContestPhotoCollection(array('contestId' => $work->contest_id));
?>

<div id="photo-inline" itemscope itemtype="http://schema.org/ImageObject">


    <div class="content-cols clearfix">
        <div class="col-gray-light">

            <div class="col-23-middle">
                <div class="photo-inline_top">

                    <div class="meta">
                        <div class="clearfix">
                            <div class="count">
                                <a href="<?=$this->createUrl('/contest/default/list', array('id' => $model->id))?>" class="btn-green">Смотреть всех участников</a>
                            </div>

                            <div class="album-title">
                                Фотоконкурс <br><?=CHtml::link($model->title, $model->url)?>
                            </div>

                        </div>
                    </div>

                    <div class="title"><h1 itemprop="name"><?=$photo->w_title?></h1></div>

                </div>
                <div class="bordered">

                    <div class="img">
                        <div class="user clearfix">

                            <div class="user-info clearfix">
                                <?php $this->widget('application.widgets.userAvatarWidget.Avatar', array('user' => $photo->author, 'size' => '40')); ?>
                                <div class="details">
                                    <a href="<?=$photo->author->getUrl()?>" class="username"><?=$photo->author->getFullName()?></a>
                                </div>
                            </div>
                            <!-- <div class="favorites-control">
                                <a class="favorites-control_a powertip" href="">
                                    145
                                </a>
                            </div> -->
                        </div>

                        <a class="img-hold" href="javascript:void(0)" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($photo->id)?>)">
                            <?php if ($photo->w_title): ?>
                                <?=CHtml::image($photo->getPreviewUrl(null, 550, Image::HEIGHT), $photo->w_title, array('itemprop' => 'contentURL', 'title'=>$photo->w_title))?>
                            <?php else: ?>
                                <?=CHtml::image($photo->getPreviewUrl(null, 550, Image::HEIGHT), '', array('itemprop' => 'contentURL'))?>
                            <?php endif; ?>

                            <meta itemprop="width" content="<?=$photo->width?> px">
                            <meta itemprop="height" content="<?=$photo->height?> px">
                            <span class="ico-zoom"></span>
                        </a>

                    </div>

                    <!-- <div class="photo-comment" itemprop="description">Квашеная капуста с клюквой, грибами, соусом, зеленью и еще очень длинный комментарий про это оформление блюда, да нужно двести знаков для этого комментария, уже вроде набралось или нет кто будет считать</div> -->

                </div>
                <!--
                    <div class="entry-nav clearfix">
                      <div class="next">
                        <span>Предыдущая статья</span>
                        <a href="">Лечение краснухи. Как избежать тяжелейших последствий</a>
                      </div>
                      <div class="prev">
                        <span>Следуюшая статья</span>
                        <a href="">Корь у ребенка. Симптомы кори. Лечение кори</a>
                      </div>
                    </div> -->
                <div class="clearfix">
                    <div class="photo-window_contest-logo">
                        <a href="<?=$model->url?>">
                            <img alt="" src="/images/contest/photo-window_contest-logo_12.png">
                        </a>
                    </div>


                    <div class="photo-window-contest-meter">
                        <div class="photo-window-contest-meter_count">
                            <div class="photo-window-contest-meter_num"><?=$work->rate?></div>
                            <div class="photo-window-contest-meter_ball"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $work->rate)?></div>
                        </div>
                        <div class="photo-window-contest-meter_vote">
                            <div class="photo-window-contest-meter_vote-tx">Голосовать!</div>
                            <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
                                'title' => 'Вам понравилось фото?',
                                'notice' => '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>',
                                'model' => $work,
                                'type' => 'simple',
                                'options' => array(
                                    'title' => CHtml::encode($photo->w_title),
                                    'image' => $photo->getPreviewUrl(180, 180),
                                    'description' => $photo->w_description,
                                ),
                            ));  ?>
                        </div>
                    </div>

                </div>

                <?php if (Yii::app()->user->id == $work->user_id): ?>
                    <div class="sharelink-friends">
                        <div class="clearfix">
                            <div class="sharelink-friends_t">Cсылка на конкурсную работу</div>
                            <input type="text" onclick="$(this).select();" value="<?=$work->getUrl(false, true)?>" class="sharelink-friends_itx">

                        </div>
                        <div class="sharelink-friends_desc">Хочешь победить в конкурсе? Разошли эту ссылку друзьям и знакомым, сделай подписью в скайпе, аське и статусом в социальных сетях. Чем больше человек проголосует за твою работу, тем выше шансы на победу!</div>
                    </div>
                <?php endif; ?>

                <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $photo, 'full' => true)); ?>
            </div>
            <!-- <div class="col-3">
                <div class="margin-t100">
                    <a href=""><img src="/images/contest/banner-w240-10.jpg" alt=""></a>
                </div>
            </div> -->
        </div>
    </div>
</div>