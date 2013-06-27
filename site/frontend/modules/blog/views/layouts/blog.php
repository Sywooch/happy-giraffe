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

        <div class="menu-simple blogInfo">
            <ul class="menu-simple_ul">
                <!-- ko foreach: rubrics -->
                <li class="menu-simple_li" data-bind="css: { active : $root.currentRubricId == id() }">
                    <a class="menu-simple_a" data-bind="text: title, attr: { href : url }"></a>
                </li>
                <!-- /ko -->
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
                <img alt="" class="blog-title-b_img" data-bind="attr: { src : photo().thumbSrc() }">
            </div>
            <h1 class="blog-title-b_t" data-bind="text: title"></h1>
        </div>

        <?=$content ?>
    </div>

</div>

<script type="text/javascript">
    blogVM = new BlogViewModel(<?=CJSON::encode($this->getBlogData())?>);
    $(".blogInfo").each(function(index, el) {
        ko.applyBindings(blogVM, el);
    });
</script>

<?php $this->endContent(); ?>