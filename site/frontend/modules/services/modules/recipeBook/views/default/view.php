<?php Yii::app()->clientScript->registerMetaTag('noindex', 'robots'); ?>

<?php $this->renderPartial('_left_col',array(
    'cat_diseases' => $cat_diseases,
    'active_disease'=>$active_disease
));
?>

<div class="right-inner">
    <?php $this->renderPartial('_view',array('data'=>$model, 'short'=>true)); ?>

    <div class="like-block" rel="<?php echo $model->id ?>">
        <div class="block-in">
            <div class="fast-rating"><span><?php echo $model->votes_pro - $model->votes_con ?></span> рейтинг</div>
        <div class="title">Рецепт полезен?</div>
        <div class="your_opinion">
            <?php $this->widget('application.widgets.voteWidget.VoteWidget', array(
                'model'=>$model,
                'template'=>
                '<div class="green"><a vote="1" class="btn btn-green-medium" href="#"><span><span>Да</span></span></a> &nbsp; <span><span class="votes_pro">{vote1}</span> (<span class="pro_percent">{vote_percent1}</span>%)</span></div>
                    <div class="red"><a vote="0" class="btn btn-red-medium" href="#"><span><span>Нет</span></span></a> &nbsp; <span><span class="votes_con">{vote0}</span> (<span class="con_percent">{vote_percent0}</span>%)</span></div>',
                'links' => array('.red a','.green a'),
                'result'=>array(0=>array('.votes_con','.con_percent'),1=>array('.votes_pro','.pro_percent')),
                'main_selector'=>'.like-block',
                'rating'=>'.fast-rating span'
            )); ?>
        </div>
        </div>
    </div>

    <?php if (!empty($more_recipes)):?>
        <div class="content-more clearfix">
            <big class="title">
                Еще рецепты - <ins class="clr_bl"><?php echo $model->disease->title ?></ins>
                <a href="<?php echo $this->createUrl('disease', array('url'=>$model->disease->slug))
                    ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
            </big>
            <?php foreach ($more_recipes as $recipe): ?>
            <div class="block">
                <b><a href="<?php echo $this->createUrl('view', array('id'=>$recipe->id))
                    ?>"><?php echo $recipe->title ?></a></b>
                <div class="more_ing">
                    <span>Ингредиенты:</span>
                    <ul>
                        <?php foreach ($recipe->ingredients as $ingredient): ?>
                        <li><a href="#" onclick="return false;"><?php echo $ingredient->title ?></a> <?php echo 'x '.(int)$ingredient->amount.' '.$ingredient->unitValue; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php echo $recipe->text ?>
            </div>
            <?php endforeach; ?>
            <div class="clear"></div>
        </div>
    <?php endif ?>

    <?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
        'model' => $model,
    )); ?>
</div>