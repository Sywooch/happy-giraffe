<h1 class="fn">
    <a href="<?=$recipe->url ?>"><?=$recipe->title ?></a>
    <?php
    if ($full) {
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
</h1>

<div class="entry-header clearfix">

    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $recipe->author, 'size' => 'small', 'time' => $recipe->created, 'location' => false, 'sendButton' => false, 'online_status' => false)); ?>

    <div class="meta meta-small">
        <div class="views"><span class="icon"></span>
            <span><?=PageView::model()->viewsByPath($recipe->url)?></span>
        </div>
        <div class="comments">
            <?=HHtml::link('', $recipe->getUrl(true), array('class' => 'icon'), true) ?>
            <?=HHtml::link($recipe->commentsCount, $recipe->getUrl(true), array(), true) ?>
        </div>
    </div>

</div>