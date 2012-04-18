<?php
/* @var $this Controller
 * @var $data RecipeBookRecipe
 */
?>
<div class="entry entry-full" id="RecipeBookRecipe_<?php echo $data->id; ?>">

    <div class="entry-header">
        <a href="<?php echo $this->createUrl('/recipeBook/default/view', array('id'=>$data->id))
            ?>"><h1><?php echo $data->title ?></h1></a>
        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->author)); ?>
        </div>

        <div class="meta">
            <div class="time"><?php echo Yii::app()->dateFormatter->format('d MMMM yyyy, H:mm', $data->created) ?></div>
            <div class="seen">Просмотров:&nbsp;<span><?php echo $data->views_amount ?></span></div>

        </div>
        <div class="clear"></div>
    </div>

    <div class="entry-content wysiwyg-content">
        <div class="rec_in">
            <div>
                <span>Ингредиенты:</span>
                <ul>
                    <?php foreach ($data->ingredients as $ingredient): ?>
                        <li><a href="#" onclick="return false;"><?php echo $ingredient->title ?></a> <?php echo 'x '.(int)$ingredient->amount.' '.$ingredient->unitValue; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div><!-- .rec_in -->
	<div class="clear"></div>
        <?php echo $data->text ?>
        <div class="clear"></div>
    </div>

    <div class="entry-footer">
        <div class="source">Источник:&nbsp;
            <?php if ($data->source_type == 'internet'):?>
            <img src="<?php echo $data->internet_favicon ?>">&nbsp;
            <a href="<?php echo $data->internet_link ?>" class="link"><?php echo $data->internet_title ?></a>&nbsp;
            <?php endif ?>
            <?php if ($data->source_type == 'me'):?>
            личный опыт
            <?php endif ?>
            <?php if ($data->source_type == 'book'):?>
            <?php echo $data->book_author.' &laquo;'.$data->book_name.'&raquo;' ?>
            <?php endif ?>
        </div>
        <span class="comm">Отзывов: <span><?php echo $data->commentsCount;  ?></span></span>
        <div class="spam">
            <?php $report = $this->beginWidget('site.frontend.widgets.reportWidget.ReportWidget', array('model' => $data));
            $report->button("$(this).parents('.spam')");
            $this->endWidget(); ?>
        </div>
        <div class="clear"></div>
        <?php if (!isset($short)):?>
            <div class="art_lk_recipes" rel="<?php echo $data->id ?>">
                <ul class="quest_fun">
                    <li><span>Считаете ли Вы полезным этот рецепт?</span></li>
                    <li class="agree_u"><a href="#">Да</a></li>
                    <li class="disagree_u"><a href="#">Нет</a></li>
                </ul>
            </div><!-- .art_lk_recipes -->
        <?php endif ?>

    </div>
</div>