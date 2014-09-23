<?php
/* @var $this Controller
 * @var $model RecipeBookDisease
 */
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
            <div class="custom-likes">
                <div class="custom-likes_slogan">Поделитесь с друзьями!</div>
                <div class="custom-likes_in">
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div data-yasharel10n="ru" data-yasharequickservices="vkontakte,facebook,twitter,odnoklassniki,moimir" data-yasharetheme="counter" data-yasharetype="small" class="yashare-auto-init"></div>
                </div>
            </div>
            <?php $this->renderPartial('//banners/_disease'); ?>
            <div class="margin-b40"></div>
        </div>
    </div>
</div>