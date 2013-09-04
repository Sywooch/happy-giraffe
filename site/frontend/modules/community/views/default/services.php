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
        <div class="heading-title margin-b10 margin-t15 clearfix" style="display: none;">
            Сервисы для кулинаров
        </div>
        <p class="margin-l20 margin-r40 color-gray-dark"><?=$this->club->services_description ?></p>

        <div class="club-services">
            <?php foreach ($services as $service) if ($service->show) { ?>
                <div class="club-services_i clearfix">
                    <?php if ($service->photo_id !== null):?>
                        <div class="club-services_img">
                            <?=CHtml::link(CHtml::image($service->photo->getPreviewUrl(104, null, Image::WIDTH)), $service->url)?>
                        </div>
                    <?php endif ?>
                    <div class="club-services_desc">
                        <a href="<?=$service->url ?>" class="club-services_t"><?=$service->title?></a>
                        <div class="club-services_tx">
                            <?=$service->description?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
