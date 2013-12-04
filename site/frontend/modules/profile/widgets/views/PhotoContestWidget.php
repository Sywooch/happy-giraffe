<?php
/**
 * @var ContestWork $work
 */
?>

<div class="b-article-conversion b-article-conversion__contest b-article-conversion__<?=$work->contest_id?>">
    <div class="b-article-conversion_hold clearfix">
        <div class="textalign-c">
            <div class="b-article b-article-prev verticalalign-m">

                <div class="b-article-prev_cont clearfix">
                    <div class="b-article-prev_t clearfix">
                        <a class="b-article-prev_t-a" href="<?=$work->getUrl()?>"><?=$work->title?></a>
                        <span class="b-article-prev_t-count"><?=$work->rate?></span>
                    </div>
                    <div class="b-article-prev_in">
                        <div class="b-article_in-img">
                            <!-- img width 235px -->
                            <a href="<?=$work->getUrl()?>"><?=CHtml::image($work->photoAttach->photo->getPreviewUrl(235, null, Image::WIDTH), $work->title, array('class' => 'content-img'))?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="b-article-conversion_crosshead">
                <div class="b-article-conversion_crosshead-top">
                    <a href="<?=$work->contest->getUrl()?>" class="b-article-conversion_crosshead-logo">
                        <img src="/images/contest/b-article-conversion__<?=$work->contest_id?>_crosshead-logo.png" alt="">
                    </a>
                </div>

                <div class="b-article-conversion_crosshead-desc">Проголосуйте за нас. <br>Нажмите на кнопки!</div>
                <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
                    'title' => 'Вам понравилось фото?',
                    'notice' => '<big>Это конкурсные баллы</big><p>Нажатие на кнопку социальных сетей +1 балл.<br />Нажатие сердечка от Весёлого Жирафа +2 балла.</p>',
                    'model' => $work,
                    'type' => 'simple',
                    'options' => array(
                        'title' => CHtml::encode($work->title),
                        'image' => $work->photoAttach->photo->getPreviewUrl(180, 180),
                        'description' => '',
                    ),
                ));  ?>

            </div>
        </div>
    </div>
</div>