<?php
/**
 * @var Community $community сообщество
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var int $rubric_id выбранная рубрика
 */

Yii::app()->clientScript->registerScriptFile('/javascripts/ko_community.js');
?>
<?php $this->renderPartial('_top', array('breadcrumbs' => true)); ?>

<div class="b-section">
    <div class="b-section_hold">
        <div class="content-cols clearfix">
            <div class="col-1">
                <div class="club-list club-list__big clearfix">
                    <ul class="club-list_ul textalign-c clearfix">
                        <li class="club-list_li">
                            <a href="" class="club-list_i">
                                <span class="club-list_img-hold">
                                    <img src="/images/club/2-w130.png" alt="" class="club-list_img">
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-23-middle">
                <div class="padding-l20">
                    <h1 class="b-section_t"><a href=""><?=$community->title ?></a></h1>
                    <?php $this->renderPartial('_links', compact('community')); ?>
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