<?php $this->renderPartial('_left_col',array(
    'cat_diseases' => $cat_diseases,
    'active_disease'=>$active_disease
));

$js_content_report = "$('.spam a').live('click', function() {
	report($(this).parents('.entry'));
	return false;
});";

Yii::app()->clientScript
    ->registerScript('content_report', $js_content_report);

?>

<div class="right-inner">
    <?php $this->renderPartial('_view',array('data'=>$model, 'short'=>true)); ?>

    <div class="like-block" rel="<?php echo $model->id ?>">
        <div class="block">
            <div class="rate"><?php echo $model->votes_pro - $model->votes_con ?></div>
            рейтинг
        </div>
        <big>Рецепт полезен?</big>
        <div class="your_opinion">
            <?php $this->widget('VoteWidget', array(
                'model'=>$model,
                'template'=>
                '<ul>
                    <li class="agree_u"><a vote="1" class="{active1}" href="#">Да</a><span class="votes_pro">{vote1}</span> (<span class="pro_percent">{vote_percent1}</span>%)</li>
                    <li class="disagree_u"><a vote="0" class="{active0}" href="#">Нет</a><span class="votes_con">{vote0}</span> (<span class="con_percent">{vote_percent0}</span>%)</li>
                </ul>',
                'links' => array('.disagree_u a','.agree_u a'),
                'result'=>array(0=>array('.votes_con','.con_percent'),1=>array('.votes_pro','.pro_percent')),
                'main_selector'=>'.like-block',
                'rating'=>'.rate'
            )); ?>
        </div><!-- .your_opinion -->
        <div class="clear"></div>
    </div>

    <?php if (!empty($more_recipes)):?>
        <div class="more">
            <big class="title">
                Еще рецепты - <ins class="clr_bl"><?php echo $model->disease->name ?></ins>
                <a href="<?php echo $this->createUrl('/recipeBook/default/disease', array('url'=>$model->disease->slug))
                    ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
            </big>
            <?php foreach ($more_recipes as $recipe): ?>
            <div class="block">
                <b><a href="<?php echo $this->createUrl('/recipeBook/default/view', array('id'=>$recipe->id))
                    ?>"><?php echo $recipe->name ?></a></b>
                <div class="more_ing">
                    <span>Ингредиенты:</span>
                    <ul>
                        <?php foreach ($recipe->ingredients as $ingredient): ?>
                        <li><a href="#"><?php echo $ingredient->name ?></a> <?php echo 'x '.(int)$ingredient->amount.' '.$ingredient->unitValue; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php echo $recipe->text ?>
            </div>
            <?php endforeach; ?>
            <div class="clear"></div>
        </div>
    <?php endif ?>

    <?php $this->widget('CommentWidget', array(
        'model' => 'RecipeBookRecipe',
        'object_id' => $model->id,
    )); ?>
</div>