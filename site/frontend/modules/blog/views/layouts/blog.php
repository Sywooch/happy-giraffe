<?php $this->beginContent('//layouts/common_new'); ?>
<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerScriptFile('/javascripts/ko_blog.js')
        ->registerScriptFile('/javascripts/jquery.Jcrop.min.js')
        ->registerScriptFile('/javascripts/upload.js')
        ->registerScript('file-upload2', 'var FileAPI = { debug: false, pingUrl: false }', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/upload/FileAPI.min.js', CClientScript::POS_BEGIN)
        ->registerScriptFile('/javascripts/upload/FileAPI.id3.js', CClientScript::POS_BEGIN)
        ->registerScriptFile('/javascripts/upload/FileAPI.exif.js', CClientScript::POS_BEGIN)
        ->registerScriptFile('/javascripts/knockout-2.2.1.js');
    Yii::app()->controller->widget('site.common.extensions.imperavi-redactor-widget.ImperaviRedactorWidget', array('onlyRegisterScript' => true));

?>
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
                    <?php $this->widget('UserAvatarWidget', array('user' => Yii::app()->user->getModel())); ?>
                </div>
                <div class="user-add-record_hold">
                    <div class="user-add-record_tx">Я хочу добавить</div>
                    <a href="<?=$this->createUrl('form', array('type' => 1))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
                    <a href="<?=$this->createUrl('form', array('type' => 3))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
                    <a href="<?=$this->createUrl('form', array('type' => 2))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__video fancy">Видео</a>
                    <a href="<?=$this->createUrl('form', array('type' => 5))?>"  data-theme="transparent" class="user-add-record_ico user-add-record_ico__status fancy">Статус</a>
                </div>
            </div>
            <a href="<?=$this->createUrl('settings/form')?>" data-theme="transparent" class="blog-settings fancy">Настройки блога</a>
        </div>
    </div>
<?php endif ?>

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
    <div class="col-23-middle col-gray">
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