<?php
/**
 * Author: alexk984
 * Date: 06.12.12
 */

if (Yii::app()->user->checkAccess('recipe_tags')){
    $basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'recipe' . DIRECTORY_SEPARATOR . 'assets';
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

    $cs = Yii::app()->clientScript;
    $cs
        ->registerScriptFile($baseUrl . '/recipe_tags.js', CClientScript::POS_HEAD);

    $style = '.remove {display:inline-block;*zoom:1;*display:inline;vertical-align:middle;margin-left:5px;}
.remove .icon {display: inline-block;width: 12px;height: 14px;background: url(/images/common.png) no-repeat -314px -135px;vertical-align: middle;position: relative;top: -1px;}
.remove:hover .icon {background-position:-314px -148px;}';
    $cs->registerCss('recipe_tags_edit_css', $style);
?>
<div>
    <p><b>Редактирование тэгов (необходимы права)</b></p>
    <p>
        <?php foreach ($recipe->tags as $tag): ?>
        <span><?=$tag->title ?></span><a class="remove" onclick="CookRecipeTags.removeCookTag(<?=$recipe->id ?>, <?=$tag->id ?>, this)" href="javascript:;"><i class="icon"></i></a><br>
        <?php endforeach; ?>
    </p>
    <?= CHtml::dropDownList('recipe_tag', UserAttributes::get(Yii::app()->user->id, 'last_recipe_tag_id'), CHtml::listData(CookRecipeTag::model()->alphabet()->findAll(), 'id', 'title'), array('style'=>'width:200px')); ?>
    <a onclick="CookRecipeTags.setCookTag(<?=$recipe->id ?>, this)" href="javascript:;">добавить</a>
</div>
<?php } ?>