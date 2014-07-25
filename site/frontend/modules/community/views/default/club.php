<?php
Yii::app()->clientScript->registerPackage('ko_community');
?><div class="b-section b-section__club b-section__club-<?=$this->club->id ?>">
    <div class="b-section_hold">
        <div class="content-cols clearfix">
            <div class="col-1">
                <div class="club-list club-list__large clearfix">
                    <ul class="club-list_ul textalign-c clearfix">
                        <li class="club-list_li">
                            <a href="<?=$this->club->url?>" class="club-list_i">
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
                    <div class="b-section_transp-t"><?=$this->club->title ?></div>

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

                <ul class="b-section_ul b-section_ul__white clearfix">
                    <?php $this->renderPartial('_links', array('show_forum' => false)); ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-23-middle ">

        <?php if (!Yii::app()->user->isGuest && count($this->club->communities) == 1):?>
            <div class="clearfix margin-r20 margin-b20 js-community-subscription" data-bind="visible: active">
                <a href="<?=$this->createUrl('/blog/default/form', array('type' => 1, 'club_id' => $this->club->communities[0]->id)) ?>"
                   class="btn-blue btn-h46 float-r fancy-top">Добавить в клуб</a>
            </div>
        <?php endif ?>

        <?php $this->renderPartial('list', array('dp' => CommunityContent::model()->getClubContents($this->club->id))); ?>
    </div>

    <div class="col-1">
        <?php $this->renderPartial('_users'); ?>
        <?php if (count($this->club->communities) == 1)
            $this->renderPartial('_rubrics', array('rubrics' => $this->club->communities[0]->rootRubrics)); ?>

        <?php $this->widget('CommunityPopularWidget', array('club' => $this->club)); ?>
    </div>

</div>

<script type="text/javascript">
    $(function() {
        vm = new CommunitySubscription(<?=CJSON::encode(UserClubSubscription::subscribed(Yii::app()->user->id, $this->club->id))?>, <?=$this->club->id ?>, <?=(int)UserClubSubscription::model()->getSubscribersCount($this->club->id) ?>);
        $(".js-community-subscription").each(function(index, el) {ko.applyBindings(vm, el)});
    });
</script>