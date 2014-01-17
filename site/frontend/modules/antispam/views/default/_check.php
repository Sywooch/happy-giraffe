<?php
/**
 * @var AntispamCheck $data
 */
?>

<!-- antispam_i-->
<div class="antispam_i clearfix">
    <div class="antispam_cont">
        <?php if ($data->entity == 'CommunityContent' || $data->entity == 'BlogContent'): ?>
            <?php $this->renderPartial('site.frontend.modules.blog.views.default.view', array('data' => $data->relatedModel, 'full' => false)); ?>
        <?php endif; ?>
    </div>
    <div class="antispam_control">
        <div class="margin-b5 clearfix"><a class="ico-del margin-r5"></a><a href="" class="ava ava__small"><span class="ico-status"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg" class="ava_img"/></a>
        </div>
        <div class="color-gray font-sx">Сегодня  23:15</div>
    </div>
</div>
<!-- /antispam_i-->