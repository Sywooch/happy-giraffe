<?php $this->beginContent('//layouts/common_new'); ?>
    <div class="content-cols clearfix">
        <div class="col-1">
            <?php $this->widget('Avatar', array('user' => $this->user, 'size' => 200)); ?>
        </div>
        <div class="col-23-middle col-gray">
            <ul class="breadcrumbs-big clearfix">
                <li class="breadcrumbs-big_i">
                    <a href="<?=$this->user->getUrl() ?>" class="breadcrumbs-big_a"><?=$this->user->getFullName() ?></a>
                </li>
                <li class="breadcrumbs-big_i">Фотоальбомы </li>
            </ul>
            <div class="col-gray">
                <?=$content ?>
            </div>
        </div>

    </div>
<?php $this->endContent(); ?>