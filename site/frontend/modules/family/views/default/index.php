<?php
/**
 * @var LiteController $this
 * @var site\frontend\modules\family\models\Family $family
 * @var site\frontend\modules\family\models\FamilyMember[] $members
 */
?>

<div class="b-main_cont b-main_cont__wide">
    <div class="family-user">
        <div class="ico-myfamily"></div>
        <div class="family-user_main-img-hold">
            <!-- У изображений соотношения сторон сохраняются -->
            <!-- 0,65 соотношение сторон-->
            <picture class="b-album_img-picture">
                <source srcset="/lite/images/example/photoalbum/2-960.jpg 1x, /lite/images/example/photoalbum/1-1920.jpg 2x" media="(min-width: 640px)"><img src="/lite/images/example/photoalbum/1-1280.jpg" alt="Фото" class="b-album_img-big">
            </picture>
        </div>
        <!-- family-about-->
        <div class="family-about">
            <?php if ($family): ?>
            <div class="family-about_bubble">
                <div class="family-about_t">О нашей семье</div>
                <div class="family-about_tx"><?=$family->description?></div>
            </div>
            <?php endif; ?>
            <?php $this->widget('site\frontend\modules\family\widgets\MembersListWidget\MembersListWidget', array(
                'family' => $family,
            )); ?>
        </div>
        <!-- /family-about-->
        <div class="visible-md">
            <!-- family-member-->
            <div class="family-member">
                <div class="family-member_row clearfix"><a href="#" class="family-member_i"><img src="/lite/images/example/w350-h450-1.jpg" alt="" class="family-member_img">
                        <div class="family-member_overlay"><span class="ico-zoom ico-zoom__abs"></span></div></a>
                    <!-- Ширину высчитывать в зависимости от фотографии 880 - щирина фото-->
                    <!-- -->
                    <div style="width: 530px;" class="family-member_about family-member_about__green family-member_about__right">
                        <div class="family-member_about-in">
                            <div class="family-member_about-hold">
                                <div class="ico-family-big ico-family-big__wife"></div>
                                <div class="family-member_about-name">

                                    Жена Виктория
                                </div>
                            </div>
                            <div class="family-member_about-tx-hold">
                                <div class="family-member_about-tx">В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на дольки. а не только лишь на экране, все же Роберт Паттинсон и Кристен Стюарт расстались и покаВ половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на дольки. а не только лишь на экране, все же Роберт Паттинсон и Кристен Стюарт расстались и покаВ половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. Поломаем не небольшие кусочки крекер. Апельсин почистим и разберем на дольки. а не только лишь на экране, все же Роберт Паттинсон и Кристен Стюарт расстались и пока</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="family-member_row clearfix">
                    <!-- Ширину высчитывать в зависимости от фотографии 880 - щирина фото-->
                    <div style="width: 280px;" class="family-member_about family-member_about__carrot family-member_about__left">
                        <div class="family-member_about-in">
                            <div class="family-member_about-hold">
                                <div class="ico-family-big ico-family-big__husband"></div>
                                <div class="family-member_about-name">

                                    Муж Потап
                                </div>
                            </div>
                            <div class="family-member_about-tx-hold">
                                <div class="family-member_about-tx">В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. </div>
                            </div>
                        </div>
                    </div><a href="#" class="family-member_i"><img src="/lite/images/example/w600-h450-2.jpg" alt="" class="family-member_img">
                        <div class="family-member_overlay"><span class="ico-zoom ico-zoom__abs"></span></div></a>
                </div>
                <div class="family-member_row clearfix"><a href="#" class="family-member_i"><img src="/lite/images/example/w600-h450-2.jpg" alt="" class="family-member_img">
                        <div class="family-member_overlay"><span class="ico-zoom ico-zoom__abs"></span></div></a>
                    <div style="width: 280px;" class="family-member_about family-member_about__blue family-member_about__right">
                        <div class="family-member_about-in">
                            <div class="family-member_about-hold">
                                <div class="ico-family-big ico-family-big__boy-3"></div>
                                <div class="family-member_about-name">

                                    Сын Вася 18 месяцев
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="family-member_row clearfix">
                    <div style="width: 100%;" class="family-member_about family-member_about__lilac">
                        <div class="family-member_about-in">
                            <div class="family-member_about-hold">
                                <div class="ico-family-big ico-family-big__baby"></div>
                                <div class="family-member_about-name">

                                    Сын Вася 18 месяцев
                                </div>
                            </div>
                            <div class="family-member_about-tx-hold">
                                <div class="family-member_about-tx">В половине чашке горячей воды разведем желатин. Дадим ему остыть. Желе для торта разводим согласно инструкции. </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /family-member-->
            <div class="i-allphoto"> <a href="" class="i-allphoto_a">Смотреть семейный альбом</a></div>
        </div>
    </div>
</div>