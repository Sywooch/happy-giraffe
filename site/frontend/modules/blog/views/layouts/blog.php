<?php
Yii::app()->clientScript
    ->registerCssFile('/stylesheets/user.css')
    ->registerPackage('ko_blog')
    ->registerPackage('ko_upload');

$data = $this->user->getBlogData();
$data['currentRubricId'] = $this->rubric_id;
?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('Avatar', array('user' => $this->user, 'size' => 200, 'message_link' => false, 'blog_link' => false, 'location' => true, 'age' => true)); ?>

        <div class="aside-blog-desc blogInfo" data-bind="visible: descriptionToShow().length > 0">
            <div class="aside-blog-desc_tx" data-bind="html: descriptionToShow"><?=$data['description']?></div>
        </div>

        <?php $this->renderPartial('_subscribers'); ?>
        <div class="menu-simple blogInfo" id="rubricsList" data-bind="visible: showRubrics">
        <?php $this->renderPartial('_rubric_list', array('currentRubricId' => $this->rubric_id)); ?>
        </div>
        <?php $this->renderPartial('_popular'); ?>

    </div>
    <div class="col-23-middle">
        <?php if (Yii::app()->user->id == $this->user->id):?>
            <a href="<?=$this->createUrl('settings/form')?>" data-theme="transparent" class="blog-settings fancy">Настройки блога</a>
        <?php endif ?>
        <div class="col-gray">
            <div class="blog-title-b blogInfo">
                <div class="blog-title-b_img-hold">
                    <img alt="" class="blog-title-b_img" data-bind="attr: { src : photoThumbSrcToShow }">
                </div>
                <h1 class="blog-title-b_t" data-bind="text: title, visible: title().length > 0"><?=$data['title']?></h1>
            </div>

            <?=$content ?>
        </div>
    </div>

</div>
<script type="text/javascript">
    blogVM = new BlogViewModel(<?=CJSON::encode($data)?>);
    $(".blogInfo").each(function(index, el) {
        ko.applyBindings(blogVM, el);
    });
</script>

<?php $this->endContent(); ?>