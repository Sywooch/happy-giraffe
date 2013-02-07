<?php
/**
 * @var $recipe_tag CookRecipeTag
 * @var $post CommunityContent
 */

?><h1 class="valentine-h1">День святого Валентина!</h1>
<div class="valentine-desc">День Святого Валентина - это праздник, который влюбленные отмечают по всему миру 14 февраля. И конечно же, Валентинов день - это семейный праздник!
    Порадуйте свою вторую половинку нежным смс с днем Валентина, красивым видео о любви или романтической валентинкой. <br>
    Пусть ваши отношения будут романтичными всегда!
</div>
<div class="content-cols clearfix">
    <div class="col-12">
        <div class="valentine-spent">
            <h2 class="valentine-spent_t">Как провести <br>День святого Валентина</h2>
            <a href="<?=$this->createUrl('howToSpend', array('open'=>1))?>" class="valentine-spent_img">
                <img src="/images/valentine-day/valentine-spent_img-2.png" alt="">
            </a>
            <div class="textalign-c">
                <a href="<?=$this->createUrl('howToSpend', array('open'=>1))?>" class="valentine-spent_a">
                    <i class="ico-camera-big"></i>смотреть <?=count($post->gallery->items) ?> фото
                </a>
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
                <a href="<?=$url ?>" class="valentine-sms_more">Читать все SMS-ки</a>
            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-12">
        <div class="valentines-best">
            <h2 class="valentines-best_h">Лучшие валентинки</h2>
            <ul class="valentines-best_ul clearfix">
                <li class="valentines-best_li">
                    <a href="" class="valentines-best_a">
                        <img src="/images/example/w220-h309-1.jpg" alt="">
                        <span class="valentines-best_btn">Отправить</span>
                    </a>
                </li>
                <li class="valentines-best_li">
                    <a href="" class="valentines-best_a">
                        <img src="/images/example/w220-h309-1.jpg" alt="">
                        <span class="valentines-best_btn">Отправить</span>
                    </a>
                </li>
                <li class="valentines-best_li">
                    <a href="" class="valentines-best_a">
                        <img src="/images/example/w220-h164-1.jpg" alt="">
                        <span class="valentines-best_btn">Отправить</span>
                    </a>
                </li>
                <li class="valentines-best_li">
                    <a href="" class="valentines-best_a">
                        <img src="/images/example/w220-h309-1.jpg" alt="">
                        <span class="valentines-best_btn">Отправить</span>
                    </a>
                </li>
                <li class="valentines-best_li">
                    <a href="" class="valentines-best_a">
                        <img src="/images/example/w220-h164-1.jpg" alt="">
                        <span class="valentines-best_btn">Отправить</span>
                    </a>
                </li>
                <li class="valentines-best_li">
                    <a href="" class="valentines-best_a">
                        <img src="/images/example/w220-h164-1.jpg" alt="">
                        <span class="valentines-best_btn">Отправить</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-3">
        <?php $recipes = $recipe_tag->getLastRecipes(); ?>
        <div class="valentine-cook">
            <h3 class="valentine-cook_t">Романтические блюда <br>ко дню святого Валентина</h3>
            <ul class="valentine-cook_ul">
                <?php foreach ($recipes as $recipe): ?>
                    <li class="valentine-cook_li clearfix">
                        <a href="<?=$recipe->getUrl() ?>" class="valentine-cook_a">
                            <span class="valentine-cook_img">
                                <img src="<?=$recipe->getMainPhoto()->getPreviewUrl(95, 100) ?>" alt="">
                            </span>
                            <span class="valentine-cook_desc"><?=$recipe->title ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="textalign-r">
                <a href="<?=$recipe_tag->getUrl() ?>" class="valentine-cook_more">Все рецепты</a>
            </div>
        </div>
    </div>
</div>

<div class="valentine-recognition">
    <h2 class="valentine-recognition_t">
        <span class="valentine-recognition_t-big">Самые</span>романтичные признания
    </h2>
    <div class="valentine-recognition_p">Самые красивые, оригинальные, добрые и романтичные видео истории любви и о любви, которые собрали миллионы просмотров и никого не оставили равнодушным.  Драматические признания, необычные предложения руки и сердца, трогательные love  story - вдохновляйтесь и творите чудеса ради любимых!</div>
    <div class="margin-b30">
        <img src="/images/example/w960-h537-1.jpg" alt="">
    </div>
    <div class="valentine-gallery">
        <a href="" class="valentine-gallery_arrow valentine-gallery_arrow__prev disabled"></a>
        <a href="" class="valentine-gallery_arrow valentine-gallery_arrow__next"></a>
        <div class="valentine-gallery_hold">
            <ul class="valentine-gallery_ul">
                <li class="valentine-gallery_li">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
                <li class="valentine-gallery_li">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
                <li class="valentine-gallery_li active">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
                <li class="valentine-gallery_li">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
                <li class="valentine-gallery_li">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
                <li class="valentine-gallery_li">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
                <li class="valentine-gallery_li">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
                <li class="valentine-gallery_li">
                    <a href="" class="valentine-gallery_a">
									<span class="valentine-gallery_img">
										<img src="/images/example/w152-h84-1.jpg" alt="">
									</span>
                        <span class="valentine-gallery_desc">Известная история</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>