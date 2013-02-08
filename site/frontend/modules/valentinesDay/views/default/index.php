<?php
/**
 * @var $recipe_tag CookRecipeTag
 * @var $post CommunityContent
 */
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/isotope.css')
        ->registerScriptFile('/javascripts/jquery.isotope.min.js')
    ;

    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.valentines-best_li > a',
        'entity' => 'Album',
        'entity_id' => Album::getAlbumByType(User::HAPPY_GIRAFFE, Album::TYPE_VALENTINE)->id,
        'entity_url' => $this->createUrl('valentines'),
    ));
?>

<script type="text/javascript">
    var ValentineVideos = {
        initialIndex: 4,
        carousel : null,

        choose : function(index) {
            var el = $($('.valentine-gallery_ul > li').get(index));
            el.siblings('.active').removeClass('active');
            el.addClass('active');

            $('.valentine-recognition .margin-b30').html($('#embedTmpl').tmpl({vimeo_id : el.data('vimeoId')}));
        }
    }

    $(function() {
        ValentineVideos.carousel = $('.valentine-gallery_hold').jcarousel({
            list:'.valentine-gallery_ul',
            items:'.valentine-gallery_li'
        });

        $('.valentine-gallery_arrow__next').jcarouselControl({target:'+=1'});
        $('.valentine-gallery_arrow__prev').jcarouselControl({target:'-=1'});

        ValentineVideos.carousel.jcarousel('scroll', ValentineVideos.initialIndex - 2, false);
        ValentineVideos.choose(ValentineVideos.initialIndex);

        var $container = $(".valentines-best_ul");

        $container.imagesLoaded(function() {
            $container.isotope({
                itemSelector : ".valentines-best_li",
                masonry: {
                    columnWidth: 234
                }
            });
        });
    });
</script>

<h1 class="valentine-h1">День святого Валентина!</h1>
<div class="valentine-desc">День Святого Валентина - это праздник, который влюбленные отмечают по всему миру 14 февраля. И конечно же, Валентинов день - это семейный праздник!
    Порадуйте свою вторую половинку нежным смс с днем Валентина, красивым видео о любви или романтической валентинкой. <br>
    Пусть ваши отношения будут романтичными всегда!
</div>


<div class="content-cols clearfix">
    <div class="col-12">
        <div class="valentine-spent">
            <h2 class="valentine-spent_t">Как провести <br>День святого Валентина</h2>
            <a href="<?=$this->createUrl('howToSpend')?>" class="valentine-spent_img">
                <img src="/images/valentine-day/valentine-spent_img.png" alt="">
            </a>
            <div class="textalign-c">
                <a class="valentine-spent_a" href="<?=$this->createUrl('howToSpend')?>">Узнайте 20 секретов</a>
            </div>
        </div>
    </div>
    <?php $models = ValentineSms::LastSms();$url = $this->createUrl('sms');  ?>
    <div class="col-3">
        <div class="valentine-sms">
            <a href="<?=$url ?>" class="valentine-sms_h"></a>
            <?php foreach ($models as $model): ?>
            <a href="<?=$url ?>" class="valentine-sms-b">
                <span class="valentine-sms-b_t">«<?=$model->title ?>»</span>
                <span class="valentine-sms-b_p"><?=$model->getFormattedText() ?></span>
            </a>
            <?php endforeach; ?>
            <div class="textalign-r">
                <a href="<?=$url ?>" class="valentine-sms_more">205 SMS. Выберите свою</a>
            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-12">
        <div class="valentines-best">
            <h2 class="valentines-best_h">Лучшие валентинки</h2>
            <ul class="valentines-best_ul clearfix">
                <?php foreach ($valentines as $v) : ?>
                    <?php $this->renderPartial('_valentine', array('data' => $v)); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <?php $recipes = $recipe_tag->getLastRecipes(5); ?>
        <div class="valentine-cook">
            <h3 class="valentine-cook_t">Романтические блюда <br>ко дню святого Валентина</h3>
            <ul class="valentine-cook_ul">
                <?php foreach ($recipes as $recipe): ?>
                <li class="valentine-cook_li clearfix">
                    <a href="<?=$recipe->getUrl() ?>" class="valentine-cook_a">
                            <span class="valentine-cook_img">
                                <img src="<?=$recipe->getMainPhoto()->getPreviewUrl(95, 71, false, true) ?>" alt="">
                            </span>
                        <span class="valentine-cook_desc"><?=$recipe->title ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            <div class="textalign-r">
                <a href="<?=$recipe_tag->getUrl() ?>" class="valentine-cook_more"><?=$recipe_tag->recipesCount?> <?=HDate::GenerateNoun(array('рецепт', 'рецепта', 'рецептов'), $recipe_tag->recipesCount)?>  с</a>
            </div>
        </div>
    </div>
</div>

<div class="valentine-recognition" id="videos">
    <h2 class="valentine-recognition_t">
        10 красивых <br>признаний в любви
    </h2>
    <div class="valentine-recognition_p">Самые красивые, оригинальные, добрые и романтичные видео истории любви и о любви, которые собрали миллионы просмотров и никого не оставили равнодушным.  Драматические признания, необычные предложения руки и сердца, трогательные love  story - вдохновляйтесь и творите чудеса ради любимых!</div>
    <div class="margin-b30">

    </div>
    <div class="valentine-gallery">
        <a href="#" class="valentine-gallery_arrow valentine-gallery_arrow__prev"></a>
        <a href="#" class="valentine-gallery_arrow valentine-gallery_arrow__next"></a>
        <div class="valentine-gallery_hold">
            <ul class="valentine-gallery_ul">
                <?php foreach ($videos as $i => $video): ?>
                    <li class="valentine-gallery_li" data-vimeo-id="<?=$video->vimeo_id?>">
                        <a href="javascript:void(0)" onclick="ValentineVideos.choose(<?=$i?>)" class="valentine-gallery_a">
                            <span class="valentine-gallery_img">
                                <?=CHtml::image($video->photo->getPreviewUrl(152, 84, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP), $video->title)?>
                            </span>
                            <span class="valentine-gallery_desc"><?=$video->title?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script id="embedTmpl" type="text/x-jquery-tmpl">
    <iframe src="http://player.vimeo.com/video/${vimeo_id}" width="960" height="537" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</script>
