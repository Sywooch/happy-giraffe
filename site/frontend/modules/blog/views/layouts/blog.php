<?php $this->beginContent('//layouts/common'); ?>
<?php $cs = Yii::app()->clientScript->registerCssFile('/stylesheets/user.css'); ?>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('UserAvatarWidget', array('user' => $this->user, 'size' => 'big')); ?>

        <?php if ($this->user->status !== null):?>
            <div class="aside-blog-desc">
                <div class="aside-blog-desc_tx">
                    <?=$this->user->status->purified->text?>
                </div>
            </div>
        <?php endif ?>

        <?php $this->renderPartial('_subscribers'); ?>

        <div class="menu-simple">
        <?php $items = array();
        foreach ($this->user->blog_rubrics as $rubric)
            $items[] = array(
                'label' => $rubric->title,
                'url' => $this->getUrl(array('rubric_id' => $rubric->id)),
                'active' => $rubric->id == $this->rubric_id,
                'linkOptions' => array('class' => 'menu-simple_a')
            );

        $this->widget('zii.widgets.CMenu', array(
            'items' => $items,
            'itemCssClass' => 'menu-simple_li',
            'htmlOptions' => array('class' => 'menu-simple_ul')
        ));
        ?>
        </div>

        <?php $this->renderPartial('_popular'); ?>

    </div>

    <div class="col-23 col-23__gray">
        <div class="blog-title-b">
            <div class="blog-title-b_img-hold">
                <img src="/images/example/w720-h128.jpg" alt="" class="blog-title-b_img">
            </div>
            <h1 class="blog-title-b_t"><?=$this->user->blogTitle ?> </h1>
        </div>

        <?=$content ?>
    </div>

</div>
<?php $this->endContent(); ?>