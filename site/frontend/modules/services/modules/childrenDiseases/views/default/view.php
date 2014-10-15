<?php
/* @var $this Controller
 * @var $model RecipeBookDisease
 */
$this->breadcrumbs = array(
    '<span class="ico-club ico-club__s ico-club__13"></span>' => Yii::app()->createUrl('community/default/section', array('section_id' => 3)),
    'Справочник детских болезней' => Yii::app()->createUrl('services/childrenDiseases/default/index'),
    $model->title,
);
?>
<div class="child-disease">
    <div class="b-main_cont">
        <div class="b-main_col-wide">
            <h1 class="heading-link-xxl heading-link-xxl__center"><?php echo $model->title ?></h1>
        </div>
    </div>
</div>
<div class="b-main_row b-main_row__blue">
    <div class="b-main_cont">
        <div class="b-main_col-article b-main_col-article__center">
            <div class="wysiwyg-content">
                <?php echo $model->text ?>
            </div>
        </div>
    </div>
</div>
<div class="b-main_row">
    <div class="b-main_cont">
        <div class="b-main_col-article b-main_col-article__center">
            <div class="wysiwyg-content">
                <div class="b-main_wide-phone textalign-c"><img src="<?= isset($model->photo) ? $model->photo->getPreviewUrl(600, 450, Image::WIDTH) : '' ?>" alt=""></div>
                <h2><?php echo empty($model->reasons_name) ? 'Причины' : $model->reasons_name ?></h2>
                <?php echo $model->reasons_text ?>
                <h2><?php echo empty($model->symptoms_name) ? 'Симптомы' : $model->symptoms_name ?></h2>
                <?php echo $model->symptoms_text ?>
                <h2><?php echo empty($model->diagnosis_name) ? 'Диагностика' : $model->diagnosis_name ?></h2>
                <?php echo $model->diagnosis_text ?>
                <h2><?php echo empty($model->treatment_name) ? 'Лечение' : $model->treatment_name ?></h2>
                <?php echo $model->treatment_text ?>
                <h2><?php echo empty($model->prophylaxis_name) ? 'Профилактика' : $model->prophylaxis_name ?></h2>
                <?php echo $model->prophylaxis_text ?>
            </div>
            <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $model, 'lite' => true)); ?> 
            <?php $this->renderPartial('//banners/_direct_others'); ?>
            <div class="margin-b40"></div>
        </div>
    </div>
</div>