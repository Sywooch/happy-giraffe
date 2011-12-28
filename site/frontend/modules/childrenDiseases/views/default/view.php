<?php
/* @var $this Controller
 * @var $model RecipeBookDisease
 */
$ilike = "
VK.init({
	apiId: 2450198,
	onlyWidgets: true
});
VK.Observer.subscribe('widgets.like.liked', function(count){
	rate(count);
});
VK.Observer.subscribe('widgets.like.unliked', function(count){
	rate(count);
});
	";

Yii::app()->clientScript
    ->registerScriptFile('http://vkontakte.ru/js/api/openapi.js', CClientScript::POS_HEAD)
    ->registerScript('ilike', $ilike, CClientScript::POS_HEAD)
?>
<div id="handbook_article_ill">
    <div class="left-inner">
        <div class="themes">
            <div class="theme-pic"><?php echo $model->category->name; ?></div>
            <ul class="leftlist">
                <?php foreach ($cat as $cat_disease): ?>
                <li><a <?php if ($cat_disease->id == $model->id) echo 'class="current" ' ?>
                    href="<?php echo $this->createUrl('/childrenDiseases/default/view', array('url' => $cat_disease->slug)) ?>"><?php
                    echo $cat_disease->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="leftbanner">
            <a href="/"><img src="/images/leftban.png"></a>
        </div>

    </div>

    <div class="right-inner">
        <div class="about_ill">
            <h1><?php echo $model->name ?></h1>
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
        <div class="like-block">
            <big>Полезен ли материал?</big>

            <div class="like">
			<span style="width:150px;">
				<div id="vk_like"
                     style="height: 22px; width: 180px; position: relative; clear: both; background-image: none; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: initial; background-position: initial initial; background-repeat: initial initial; "></div>
					<script type="text/javascript">
                        VK.Widgets.Like("vk_like", {type:"button"});
                    </script>
			</span>

                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div><!-- .handbook_article_ill -->