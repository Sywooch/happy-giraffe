<?php
Yii::app()->clientScript->registerPackage('ko_community');
?><div class="b-section b-section__club b-section__club-<?=$this->club->id ?>">
    <div class="b-section_hold">
        <div class="content-cols clearfix">
            <div class="col-1">
                <div class="club-list club-list__large clearfix">
                    <ul class="club-list_ul textalign-c clearfix">
                        <li class="club-list_li">
                            <a href="<?=$this->createUrl('/community/default/club', array('club_id'=>$this->club->id)) ?>" class="club-list_i">
                                <span class="club-list_img-hold">
                                    <img src="/images/club/<?=$this->club->id ?>-w240.png" alt="" class="club-list_img">
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-23-middle clearfix js-community-subscription">

                <div class="b-section_transp">
                    <h1 class="b-section_transp-t"><?=$this->club->title ?></h1>

                    <div class="b-section_transp-desc"><?=$this->club->description ?></div>

                    <a href="" class="b-section_club-add" data-bind="click: subscribe, visible: !active()">
                        <span class="b-section_club-add-tx">Вступить в клуб</span>
                    </a>

                    <div class="b-section_club-moder" style="display: none;">
                        <span class="b-section_club-moder-tx">Модераторы <br> клуба</span>
                        <?php foreach ($moderators as $moderator): ?>
                            <?php $this->widget('Avatar', array('user' => $moderator)); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <ul class="b-section_ul b-section_ul__white margin-l30 clearfix">
                    <?php $this->renderPartial('_links'); ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">

    <div class="col-1">
        <?php $this->renderPartial('_users'); ?>
        <?php if (count($this->club->communities) == 1)
            $this->renderPartial('_rubrics', array('rubrics' => $this->club->communities[0]->rubrics)); ?>
    </div>
    <div class="col-23-middle ">
        <?php $this->renderPartial('list'); ?>
    </div>

</div>

<script type="text/javascript">
    $(function() {
        vm = new CommunitySubscription(<?=CJSON::encode(UserClubSubscription::subscribed(Yii::app()->user->id, $this->club->id))?>, <?=$this->club->id ?>, <?=(int)UserClubSubscription::model()->getSubscribersCount($this->club->id) ?>);
        $(".js-community-subscription").each(function(index, el) {ko.applyBindings(vm, el)});
    });
</script>