<?php $this->renderPartial('_left_col',array(
    'cat_diseases' => $cat_diseases,
    'active_disease'=>$model
));

$js_content_report = "
$('.spam a').live('click', function() {
	report($(this).parents('.entry'));
	return false;
});
";

$js = "$('.art_lk_recipes').delegate('a', 'click', function(e) {
			e.preventDefault();
			var button = $(this);
			var offer = $(this).parents('.art_lk_recipes');
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

    <?php $this->renderPartial('disease_data',array(
        'recipes' => $recipes,
        'pages' => $pages
    )); ?>

<div class="clear"></div><!-- .clear -->

</div>