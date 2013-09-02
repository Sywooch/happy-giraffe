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
                    <h1 class="b-section_t"><a href=""><?=$this->club->title ?></a></h1>

                    <div class="clearfix">
                        <ul class="b-section_ul margin-l30 clearfix<?php if (isset($root)) echo ' b-section_ul__white'; ?>">
                            <li class="b-section_li">
                                <a href="<?=$this->createUrl('/community/default/forum', array('forum_id'=>$this->club->id)) ?>"
                                   class="b-section_li-a<?php if (isset($this->forum) && $this->forum) echo ' active' ?>">Форум</a>
                            </li>
                            <?php if (count($this->club->services) < 2):?>
                                <?php foreach($this->club->services as $service):?>
                                    <li class="b-section_li">
                                        <a href="<?=$service->getUrl() ?>" class="b-section_li-a<?php if (isset($service_id) && $service_id = $service->id) echo ' active' ?>"><?=$service->title ?></a>
                                    </li>
                                <?php endforeach ?>
                            <?php else: ?>
                                <li class="b-section_li">
                                    <a href="<?=$this->createUrl('/community/default/services', array('club_id'=>$this->club->id)) ?>" class="b-section_li-a<?php if (Yii::app()->controller->action->id == 'services' ) echo ' active' ?>">Сервисы</a>
                                </li>
                            <?php endif ?>
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
        vm = new CommunitySubscription(<?=CJSON::encode(UserClubSubscription::subscribed(Yii::app()->user->id, $this->club->id))?>, <?=$this->club->id ?>);
        $(".js-community-subscription").each(function(index, el) {ko.applyBindings(vm, el)});
    });
</script>
<?php $this->endContent(); ?>