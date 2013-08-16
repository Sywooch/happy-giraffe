<?php
/**
 * @var User $user
 */
$user = $this->user;

$this->beginContent('//layouts/common_new'); ?>
<div class="content-cols">
    <div class="col-1">
        <?php $this->widget('Avatar', array('user' => $user, 'size' => 200, 'location' => true)) ?>
    </div>

    <div class="col-23-middle clearfix">

        <ul class="breadcrumbs-big clearfix">
            <li class="breadcrumbs-big_i">
                <a class="breadcrumbs-big_a" href="<?=$user->getUrl() ?>"><?=$this->user->getFullName() ?></a>
            </li>
            <li class="breadcrumbs-big_i"><?=$this->title ?></li>
        </ul>
        <div class="col-gray">

            <?=$content ?>

        </div>
    </div>
</div>
<?php $this->pageTitle = $this->user->getFullName(). ' - ' . $this->title; ?>
<?php $this->endContent(); ?>