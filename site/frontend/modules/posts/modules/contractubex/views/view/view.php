<?php
$this->pageTitle = $this->post->title;
$this->metaDescription = $this->post->metaObject->description;
$this->metaNoindex = $this->post->isNoindex;
$this->breadcrumbs = array(
    'Контрактубекс' => array('/posts/contractubex/default/index'),
    $this->post->title,
);
?>

<?php $this->beginClip('header-banner'); ?>
<div class="header-banner-medium"></div>
<?php $this->endClip(); ?>

<?php $this->renderPartial('_view'); ?>
