<?php $this->beginContent('//layouts/common'); ?>
<?php
    Yii::app()->clientScript
        ->registerCssFile('/stylesheets/user.css')
        ->registerScriptFile('/javascripts/ko_blog.js')
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

<script type="text/javascript">
    //blogInfo = new BlogInfoViewModel(<?=CJSON::encode($this->getBlogData())?>);
    //$(".blogInfo").each(function(index, el) {
    //    ko.applyBindings(blogInfo, el);
    //});

    function BlogRecordSettings(data) {
        var self = this;
        ko.mapping.fromJS(data, {}, self);
        self.displayOptions = ko.observable(false);
        self.displayPrivacy = ko.observable(false);

        self.attach = function(){
            $.post('/newblog/attachBlog/', {id: self.id()}, function (response) {
                if (response.status) {
                    self.attached(!self.attached());
                }
            }, 'json');
            self.displayOptions(false);
        };
        self.show = function(){
            self.displayOptions(!self.displayOptions());
        };
        self.showPrivacy = function(){
            self.displayPrivacy(!self.displayPrivacy());
        };
        self.privacyClass = ko.computed(function () {
            if (self.privacy() == 0)
                return 'ico-users__all';
            else return 'ico-users__friend';
        });
        self.setPrivacy = function(privacy){
            $.post('/newblog/updatePrivacy/', {id: self.id(), privacy:privacy}, function (response) {
                if (response.status) {
                    self.privacy(privacy);
                    self.displayPrivacy(false);
                }
            }, 'json');

        };
    }

    ko.bindingHandlers.slideVisible = {
        init: function(element, valueAccessor) {
            var value = valueAccessor();
            $(element).toggle(ko.utils.unwrapObservable(value));
        },
        update: function(element, valueAccessor) {
            var value = valueAccessor();
            if (value && !$(element).is(':visible') || !value && $(element).is(':visible'))
                $(element).slideToggle(300);
        }
    };

    ko.bindingHandlers.toggleVisible = {
        init: function(element, valueAccessor) {
            var value = valueAccessor();
            $(element).toggle(ko.utils.unwrapObservable(value));
        },
        update: function(element, valueAccessor) {
            var value = valueAccessor();
            if (value && !$(element).is(':visible') || !value && $(element).is(':visible'))
                $(element).toggle(200);
        }
    };

</script>
<?php $this->endContent(); ?>