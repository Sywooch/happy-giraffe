<?php
$this->hideAdsense = true;
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;

$breadcrumbs = [
    'Контрактубекс' => ['/posts/contractubex/default/index'],
    $this->post->title,
];

?>

<div class="b-breadcrumbs" style="margin-left: 0;">
  		
<?php 

$this->widget('zii.widgets.CBreadcrumbs', [
    'links'                => $breadcrumbs,
    'tagName'              => 'ul',
    'homeLink'             => FALSE,
    'separator'            => '',
    'activeLinkTemplate'   => '<li><a href="{url}">{label}</a></li>',
    'inactiveLinkTemplate' => '<li>{label}</li>',
]); 

?>

</div>

<?php $this->beginClip('header-banner'); ?>
<div class="header-banner-medium">
    <a class="sidebar-promo-banner_button" href="<?=$this->createUrl('/posts/contractubex/default/index')?>">Узнать больше!</a>
</div>
<?php $this->endClip(); ?>

<?php $this->renderPartial('_view'); ?>
