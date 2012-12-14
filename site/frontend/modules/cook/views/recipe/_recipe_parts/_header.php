<h1 class="fn">
    <a href="<?=$recipe->url ?>"><?=$recipe->title ?></a>
    <?php if (Yii::app()->authManager->checkAccess('editCookRecipe', Yii::app()->user->id) || Yii::app()->user->id == $recipe->author_id):?>
        <?php echo CHtml::link('', $this->createUrl('/cook/recipe/form/', array('id' => $recipe->id, 'section' => $recipe->section)), array('class' => 'icon-edit'));?>
        <?php echo CHtml::link('', $this->createUrl('/cook/recipe/form/', array('id' => $recipe->id, 'section' => $recipe->section)), array('class' => 'icon-remove'));?>
    <?php endif; ?>
</h1>

<div class="entry-header clearfix">

    <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $recipe->author,'size'=>'small', 'time'=>$recipe->created, 'location'=>false, 'sendButton'=>false, 'online_status'=>false)); ?>

    <div class="meta meta-small">
        <div class="views"><span class="icon"></span> <span><?=PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $recipe->url), true)?></span></div>
        <div class="comments">
            <?=HHtml::link('', $recipe->getUrl(true), array('class'=>'icon'), true) ?>
            <?=HHtml::link($recipe->commentsCount, $recipe->getUrl(true), array(), true) ?>
        </div>
    </div>

</div>