<?php
/**
 * @var Service $services
 */
?><div class="col-1">

    <?php $this->renderPartial('_users'); ?>

    <div class="banner">
        <a href="">
            <img src="/images/banners/6.jpg" alt="">
        </a>
    </div>
</div>
<div class="col-23-middle ">

    <div class="col-gray">
        <div class="heading-title margin-b10 margin-t15 clearfix">
            Сервисы для кулинаров
        </div>
        <p class="margin-l20 margin-r40 color-gray-dark">Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам. Оптимальный набор веса при беременности — это 10–14 кг.  </p>

        <div class="club-services">
            <?php foreach ($services as $service): ?>
                <div class="club-services_i clearfix">
                    <div class="club-services_img">
                        <?=CHtml::link(CHtml::image($service->photo->getPreviewUrl(104, null, Image::WIDTH)), $service->url)?>
                    </div>
                    <div class="club-services_desc">
                        <a href="<?=$service->url ?>" class="club-services_t"><?=$service->title?></a>
                        <div class="club-services_tx">
                            <?=$service->description?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
