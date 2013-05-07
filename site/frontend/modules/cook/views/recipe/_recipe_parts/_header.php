<h1 class="fn"><?php if ($full):?><?=CHtml::encode(trim($recipe->title)) ?><?php else: ?><a class="entry-title" href="<?=$recipe->url ?>"><?=CHtml::encode(trim($recipe->title)) ?></a><?php endif;
    if ($full && !Yii::app()->user->isGuest) {
        if (Yii::app()->authManager->checkAccess('editCookRecipe', Yii::app()->user->id) || Yii::app()->user->id == $recipe->author_id)
            echo CHtml::link('', $this->createUrl('/cook/recipe/form/', array('id' => $recipe->id, 'section' => $recipe->section)), array('class' => 'icon-edit'));

        if (Yii::app()->authManager->checkAccess('editCookRecipe', Yii::app()->user->id) || Yii::app()->user->id == $recipe->author_id) {
            $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
                'model' => $recipe,
                'callback' => 'RecipeRemove',
                'author' => !Yii::app()->user->isGuest && Yii::app()->user->id == $recipe->author_id,
                'cssClass' => 'icon-remove'
            ));
            Yii::app()->clientScript->registerScript('after_remove', 'function RecipeRemove() {window.location = "' . $this->createUrl('/cook/recipe') . '";}', CClientScript::POS_HEAD);
        }
    }?>
    <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $recipe)); ?></h1>

<div class="entry-header clearfix">

    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $recipe->author, 'size' => 'small', 'time' => $recipe->created, 'location' => false, 'sendButton' => false, 'online_status' => false)); ?>

    <div class="meta meta-small">
        <div class="views"><span class="icon"></span>
            <span><?=($full) ? $this->getViews() : PageView::model()->viewsByPath($recipe->url)?></span>
        </div>
        <div class="comments">
            <?=HHtml::link('', $recipe->getUrl(true), array('class' => 'icon'), true) ?>
            <?=HHtml::link($recipe->commentsCount, $recipe->getUrl(true), array(), true) ?>
        </div>
    </div>

</div>