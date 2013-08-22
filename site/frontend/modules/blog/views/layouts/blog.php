<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerPackage('ko_blog')
        ->registerScript('file-upload2', 'var FileAPI = { debug: false, pingUrl: false }', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/upload/FileAPI.min.js', CClientScript::POS_BEGIN)
        ->registerScriptFile('/javascripts/upload/FileAPI.id3.js', CClientScript::POS_BEGIN)
        ->registerScriptFile('/javascripts/upload/FileAPI.exif.js', CClientScript::POS_BEGIN)
    ;

    $data = $this->getBlogData();
?>
<?php $this->beginContent('//layouts/common_new'); ?>
<?php if (!Yii::app()->user->isGuest):?>
    <div class="content-cols clearfix">
        <div class="col-1">
            <div class="sidebar-search clearfix">
                <form action="/search/">
                    <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" name="text" id="blog-search" onkeyup="BlogSearch.keyUp(this)">
                    <input type="button" class="sidebar-search_btn" id="blog-search-btn" onclick="return BlogSearch.click()"/>
                </form>
            </div>
        </div>
        <div class="col-23-middle">
            <div class="user-add-record clearfix">
                <div class="user-add-record_ava-hold">
                    <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel())) ?>
                </div>
                <div class="user-add-record_hold">
                    <div class="user-add-record_tx">Я хочу добавить</div>
                    <a href="<?=$this->createUrl('form', array('type' => 1))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
                    <a href="<?=$this->createUrl('form', array('type' => 3))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
                    <a href="<?=$this->createUrl('form', array('type' => 2))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy">Видео</a>
                    <a href="<?=$this->createUrl('form', array('type' => 5))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy">Статус</a>
                </div>
            </div>
            <?php if (Yii::app()->user->id == $this->user->id):?>
                <a href="<?=$this->createUrl('settings/form')?>" data-theme="transparent" class="blog-settings fancy">Настройки блога</a>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('Avatar', array('user' => $this->user, 'size' => 200, 'message_link' => false, 'blog_link' => false)); ?>

        <div class="aside-blog-desc blogInfo" data-bind="visible: descriptionToShow().length > 0">
            <div class="aside-blog-desc_tx" data-bind="html: descriptionToShow"><?=$data['description']?></div>
        </div>

        <?php $this->renderPartial('_subscribers'); ?>
        <?php $this->renderPartial('_rubric_list'); ?>
        <?php $this->renderPartial('_popular'); ?>

    </div>
    <div class="col-23-middle col-gray">
        <div class="blog-title-b blogInfo">
            <div class="blog-title-b_img-hold">
                <img alt="" class="blog-title-b_img" data-bind="attr: { src : photo().thumbSrc() }">
            </div>
            <h1 class="blog-title-b_t" data-bind="text: title, visible: title().length > 0"><?=$data['title']?></h1>
        </div>

        <?=$content ?>
    </div>

</div>
<script type="text/javascript">
    blogVM = new BlogViewModel(<?=CJSON::encode($data)?>);
    $(".blogInfo").each(function(index, el) {
        ko.applyBindings(blogVM, el);
    });
</script>

<?php $this->endContent(); ?>