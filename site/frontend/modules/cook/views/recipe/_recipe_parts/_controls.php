<div class="float-l">
    <div class="like-control like-control__small-indent clearfix">
        <?php $this->widget('Avatar', array('user' => $recipe->author)) ?>
    </div>
    <div class="js-like-control">
        <div class="like-control like-control__pinned clearfix">
            <?php $this->widget('application.modules.blog.widgets.LikeWidget', array('model' => $recipe)); ?>
            <!-- ko stopBinding: true -->
            <?php $this->widget('FavouriteWidget', array('model' => $recipe, 'right' => true)); ?>
            <!-- /ko -->
        </div>

        <?php if (Yii::app()->authManager->checkAccess('editCookRecipe', Yii::app()->user->id) || Yii::app()->user->id == $recipe->author_id): ?>
            <div class="article-settings">
                <div class="article-settings_hold display-b">
                    <div class="article-settings_i">
                        <a href="<?=$this->createUrl('/cook/recipe/form/', array('id' => $recipe->id, 'section' => $recipe->section))?>" class="article-settings_a article-settings_a__edit powertip" title="Редактировать"></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>