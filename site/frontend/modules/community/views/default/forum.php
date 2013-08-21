<?php
/**
 * @var Community $community сообщество
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var int $rubric_id выбранная рубрика
 */

Yii::app()->clientScript->registerScriptFile('/javascripts/ko_community.js');
?>
<?php $this->renderPartial('_top', array('community' => $community, 'breadcrumbs' => true)); ?>

<div class="b-section">
    <div class="b-section_hold">
        <div class="content-cols clearfix">
            <?php $this->renderPartial('_main_image', array('community' => $community, 'size' => 130)); ?>
            <div class="col-23-middle">
                <div class="padding-l20">
                    <h1 class="b-section_t"><a href=""><?=$community->title ?></a></h1>
                    <?php $this->renderPartial('_links', array('community' => $community, 'forum' => true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->renderPartial('_users2', compact('users', 'user_count')); ?>

        <?php $this->renderPartial('_rubrics', compact('community', 'rubric_id')); ?>

    </div>
    <div class="col-23-middle ">
        <?php $this->renderPartial('_list', compact('community', 'rubric_id')); ?>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new CommunitySubscription(<?=CJSON::encode(UserCommunitySubscription::subscribed(Yii::app()->user->id, $community->id))?>, <?=$community->id ?>);
        $(".js-community-subscription").each(function(index, el) {ko.applyBindings(vm, el)});
    });
</script>