<?php Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
/* @var $this Controller
 * @var $model RecipeBookDisease
 */
?>
<div id="handbook_article_ill">
    <div class="left-inner">
        <div class="themes">
            <div class="theme-pic"><?php echo $model->category->title; ?></div>
            <ul class="leftlist">
                <?php foreach ($cat as $cat_disease): ?>
                <li><a <?php if ($cat_disease->id == $model->id) echo 'class="current" ' ?>
                    href="<?php echo $this->createUrl('view', array('url' => $cat_disease->slug)) ?>"><?php
                    echo $cat_disease->title ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="leftbanner">

        </div>

    </div>

    <div class="right-inner">
        <div class="about_ill">
            <h1><?php echo $model->title ?></h1>
            <?php echo $model->text ?>
            <div class="clear"></div><!-- .clear -->
            <ul class="list_ill_ab">
                <li class="current_t"><a href="#"><span>Причины</span></a></li>
                <li>|</li>
                <li><a href="#symptoms"><span>Симптомы</span></a></li>
                <li>|</li>
                <li><a href="#diagnosis"><span>Диагностика</span></a></li>
                <li>|</li>
                <li><a href="#treatment"><span>Лечение</span></a></li>
                <li>|</li>
                <li><a href="#prophylaxis"><span>Профилактика</span></a></li>
            </ul>
        </div>
        <!-- .about_ill -->
        <h2><?php echo empty($model->reasons_name) ? 'Причины' : $model->reasons_name ?></h2>
        <?php echo $model->reasons_text ?>
        <h2 id="symptoms"><?php echo empty($model->symptoms_name) ? 'Симптомы' : $model->symptoms_name ?></h2>
        <?php echo $model->symptoms_text ?>
        <h2 id="diagnosis"><?php echo empty($model->diagnosis_name) ? 'Диагностика' : $model->diagnosis_name ?></h2>
        <?php echo $model->diagnosis_text ?>
        <h2 id="treatment"><?php echo empty($model->treatment_name) ? 'Лечение' : $model->treatment_name ?></h2>
        <?php echo $model->treatment_text ?>
        <h2 id="prophylaxis"><?php echo empty($model->prophylaxis_name) ? 'Профилактика' : $model->prophylaxis_name ?></h2>
        <?php echo $model->prophylaxis_text ?>
        <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
//        'title' => 'Полезен ли материал?',
        'model' => $model,
        'options' => array('title' => 'Полезен ли материал?',),
    )); ?>
    </div>
</div><!-- .handbook_article_ill -->