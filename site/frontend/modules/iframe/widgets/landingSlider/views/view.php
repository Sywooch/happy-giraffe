<?php
/**
 * @var $this \site\frontend\modules\iframe\widgets\landingSlider\LandingSlider
 * @var $pediators array
 */

?>

<section class="section-landing section-landing--bg">
    <div class="promo-wrapper">
        <div class="section-landing-slider">
            <div class="section-landing-h2 section-landing-text--bolder section-landing-text--white">C нами уже более 1000 педиатров и детских врачей</div>
            <div class="section-landing-slider-specialist">
                <div class="js-section-landing-slider-specialist">
                    <?php foreach ($pediators as $p): $flowerCount = (new \site\frontend\modules\iframe\components\QaRatingManager())->getViewCounters($p['user']->id)['flowerCount']; ?>
                    <div class="section-landing-slider-specialist__item">
                        <div class="section-landing-slider__header">
                            <div class="section-landing-slider-specialist__left"><span class="text-title text-title--h1"><?=$p['user']->lastName?> <?=$p['user']->firstName?> <?=$p['user']->middleName?></span>
                                <div class="section-landing-slider-specialist__name"><?=$p['user']->specialistInfo['title']?></div>
                                <div class="section-landing-slider-specialist__text"<?=$p['user']->city?></div>
                                <?php if ($infoString = $this->getInfoString($p['user']->id)): ?>
                                    <div class="section-landing-slider-specialist__text"><?=$infoString?></div>
                                <?php endif; ?>
                            </div>
                            <div class="section-landing-slider-specialist__right">
                                <a href="javascript:void(0);" class="ava ava--style ava--xl ava--xl_male">
                                    <?php if ($p['user']->avatarInfo['big']): ?>
                                        <img src="<?=$p['user']->avatarInfo['big']?>" class="ava__img" />
                                    <?php endif; ?>
                                </a>
                                <div class="b-pediatrician-list-item__box">
                                    <div class="b-pediatrician-list-item__cell"><span class="b-pediatrician-list-item__count"><?=$p['answers']?></span><span class="b-pediatrician-list-item__gray">Ответы</span>
                                    </div>
                                    <div class="b-pediatrician-list-item__cell"><span class="b-pediatrician-list-item__count"><?=$p['votes']?></span><span class="b-pediatrician-list-item__gray"><?php for ($i = 0; $i < $flowerCount; $i++): ?><span class="b-answer-header-box__ico"></span><?php endfor; ?></span>&nbsp;&nbsp;Спасибо</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="section-landing-slider__footer">
                    <div class="js-section-landing-slider__control-left section-landing-slider__control-left"><i class="icon icon-arrow-l"></i>
                    </div>
                    <div class="js-section-landing-slider__control-right section-landing-slider__control-right"><i class="icon icon-arrow-r"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>