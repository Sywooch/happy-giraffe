<?php $this->renderPartial('_left_col',array(
    'cat_diseases' => $cat_diseases,
    'active_disease'=>$active_disease
));

$js_content_report = "$('.spam a').live('click', function() {
	report($(this).parents('.entry'));
	return false;
});";

$js = "$('.your_opinion').delegate('a', 'click', function(e) {
			e.preventDefault();
			var button = $(this);
			var offer = button.parents('.like-block');
			var a = {agree_u: 1, disagree_u: 0};
			var lol = button.parents('li').attr('class');
			var vote = a[lol];
			var offer_id = offer.attr('rel');
			$.ajax({
				dataType: 'JSON',
				type: 'POST',
				url: " . CJSON::encode(Yii::app()->createUrl('recipeBook/default/vote')) . ",
				data: {
					id: offer_id,
					vote: vote,
				},
				success: function(response) {
					//var b = {0: 'red', 1: 'green'};
					//offer.find('a').removeClass('btn-red-small').removeClass('btn-green-small').addClass('btn-gray-small');
					//button.removeClass('btn-gray-small').addClass('btn-' + b[vote] + '-small');
					offer.find('span.votes_pro').text(response.votes_pro+' ('+response.pro_percent+'%)');
					offer.find('span.votes_con').text(response.votes_con+' ('+response.con_percent+'%)');
				},
			});
		});
	";

Yii::app()->clientScript
    ->registerScript('content_report', $js_content_report)
    ->registerScript('recipe_vote', $js);

?>

<div class="right-inner">
    <?php $this->renderPartial('_view',array('data'=>$model, 'short'=>true)); ?>

    <div class="like-block" rel="<?php echo $model->id ?>">
        <div class="block">
            <div class="rate"><?php echo $model->getTotalVotes() ?></div>
            рейтинг
        </div>
        <big>Рецепт полезен?</big>
        <div class="your_opinion">
            <ul>
                <li class="agree_u"><a href="#">Да</a><span class="votes_pro"><?php echo $model->votes_pro ?> (<?php echo $model->proPercent ?>%)</span></li>
                <li class="disagree_u"><a href="#">Нет</a><span class="votes_con"><?php echo $model->votes_con ?> (<?php echo $model->conPercent ?>%)</span></li>
            </ul>
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