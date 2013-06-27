<?php $this->beginContent('//layouts/common'); ?>
<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerScriptFile('/javascripts/ko_blog.js', CClientScript::POS_END)
        ->registerScriptFile('/javascripts/jquery.Jcrop.min.js')
    ;
?>
<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('UserAvatarWidget', array('user' => $this->user, 'size' => 'big')); ?>

        <div class="aside-blog-desc blogInfo" data-bind="visible: description().length > 0">
            <div class="aside-blog-desc_tx" data-bind="html: description"></div>
        </div>

        <?php $this->renderPartial('_subscribers'); ?>

        <div class="menu-simple">
            <ul class="menu-simple_ul">
                <?php foreach ($this->user->blog_rubrics as $rubric): ?>
                    <li class="menu-simple_li<?php if ($rubric->id == $this->rubric_id) echo ' active' ?>">
                        <a href="<?=$this->getUrl(array('rubric_id' => $rubric->id)) ?>" class="menu-simple_a"><?=$rubric->title ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php $this->renderPartial('_popular'); ?>

    </div>
    <?php if ($this->user->id == Yii::app()->user->id): ?>
        <div class="col-23">
            <a href="<?=$this->createUrl('settingsForm')?>" data-theme="transparent" class="blog-settings fancy">Настройки блога</a>
        </div>
    <?php endif; ?>
    <div class="col-23 col-23__gray">
        <div class="blog-title-b blogInfo" data-bind="visible: title().length > 0">
            <div class="blog-title-b_img-hold">
                <img src="/images/example/w720-h128.jpg" alt="" class="blog-title-b_img">
            </div>
            <h1 class="blog-title-b_t" data-bind="text: title"></h1>
        </div>

        <?=$content ?>
    </div>

</div>
<?php $this->endContent(); ?>