<?php $this->renderPartial('_left_col',array(
    'cat_diseases' => $cat_diseases,
    'active_disease'=>$model->id
)); ?>

<div class="right-inner">

    <?php $this->renderPartial('disease_data',array(
        'recipes' => $recipes,
        'pages' => $pages
    )); ?>

<div class="clear"></div><!-- .clear -->

</div>