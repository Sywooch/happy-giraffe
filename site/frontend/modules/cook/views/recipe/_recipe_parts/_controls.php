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
    </div>
</div>