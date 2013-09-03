<?php
Yii::app()->clientScript->registerPackage('ko_community');

$this->beginContent('//layouts/main'); ?>
<div class="b-section">
    <div class="b-section_hold">
        <div class="content-cols clearfix">

            <div class="col-1">
                <div class="club-list club-list__large clearfix">
                    <ul class="club-list_ul textalign-c clearfix">
                        <li class="club-list_li">
                            <a href="<?=$this->createUrl('/community/default/club', array('club_id'=>$this->club->id)) ?>" class="club-list_i">
                                <span class="club-list_img-hold">
                                    <img src="/images/club/<?=$this->club->id ?>-w130.png" class="club-list_img">
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-23-middle">
                <div class="padding-l20">
                    <h1 class="b-section_t"><a href="<?=$this->createUrl('/community/default/club', array('club_id'=>$this->club->id)) ?>"><?=$this->club->title ?></a></h1>

                    <div class="clearfix">
                        <ul class="b-section_ul clearfix">
                            <?php $this->renderPartial('application.modules.community.views.default._links'); ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <?=$content ?>
</div>

<script type="text/javascript">
    $(function() {
        vm = new CommunitySubscription(<?=CJSON::encode(UserClubSubscription::subscribed(Yii::app()->user->id, $this->club->id))?>, <?=$this->club->id ?>, <?=(int)UserClubSubscription::model()->getSubscribersCount($this->club->id) ?>);
        $(".js-community-subscription").each(function(index, el) {ko.applyBindings(vm, el)});
    });
</script>
<?php $this->endContent(); ?>