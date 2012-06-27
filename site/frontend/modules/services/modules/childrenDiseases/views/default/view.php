<?php
/* @var $this Controller
 * @var $model RecipeBookDisease
 */
?>
<h1><?php echo $model->title ?></h1>
<div class="disease-img">
    <img src="<?=isset($model->photo) ? $model->photo->getPreviewUrl(250, 350, Image::WIDTH) : '' ?>"/>
</div>

<div class="wysiwyg-content clearfix">
    <?php echo $model->text ?>
</div>

<div class="fast-nav">
    <a class="active" href="#reasons"><span>Причины</span></a>  &nbsp; | &nbsp;
    <a href="#symptoms"><span>Симптомы</span></a>     &nbsp; | &nbsp;
    <a href="#diagnosis"><span>Диагностика</span></a>     &nbsp; | &nbsp;
    <a href="#treatment"><span>Лечение</span></a>        &nbsp; | &nbsp;
    <a href="#prophylaxis"><span>Профилактика</span></a>
</div>

<div class="wysiwyg-content">
    <h2 id="reasons"><?php echo empty($model->reasons_name) ? 'Причины' : $model->reasons_name ?></h2>
    <?php echo $model->reasons_text ?>
    <h2 id="symptoms"><?php echo empty($model->symptoms_name) ? 'Симптомы' : $model->symptoms_name ?></h2>
    <?php echo $model->symptoms_text ?>
    <h2 id="diagnosis"><?php echo empty($model->diagnosis_name) ? 'Диагностика' : $model->diagnosis_name ?></h2>
    <?php echo $model->diagnosis_text ?>
    <h2 id="treatment"><?php echo empty($model->treatment_name) ? 'Лечение' : $model->treatment_name ?></h2>
    <?php echo $model->treatment_text ?>
    <h2 id="prophylaxis"><?php echo empty($model->prophylaxis_name) ? 'Профилактика' : $model->prophylaxis_name ?></h2>
    <?php echo $model->prophylaxis_text ?>
</div>