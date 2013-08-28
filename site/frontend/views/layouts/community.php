<?php
Yii::app()->clientScript->registerPackage('ko_community');

$this->beginContent('//layouts/main'); ?>
    <div class="content-cols clearfix">
        <div class="col-1">
            <div class="sidebar-search clearfix">
                <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx">
                <button class="sidebar-search_btn"></button>
            </div>
        </div>

        <div class="col-23-middle">
            <?php if (!Yii::app()->user->isGuest): ?>
                <div class="user-add-record user-add-record__small clearfix">
                    <div class="user-add-record_ava-hold">
                        <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 40)); ?>
                    </div>
                    <div class="user-add-record_hold">
                        <div class="user-add-record_tx">Я хочу добавить</div>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1)) ?>" data-theme="transparent"
                           class="user-add-record_ico user-add-record_ico__article fancy-top powertip" title="Статью"></a>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 3)) ?>" data-theme="transparent"
                           class="user-add-record_ico user-add-record_ico__photo fancy-top powertip" title="Фото"></a>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 2)) ?>" data-theme="transparent"
                           class="user-add-record_ico user-add-record_ico__video fancy-top powertip" title="Видео"></a>
                        <a href="<?= $this->createUrl('/blog/default/form', array('type' => 5)) ?>" data-theme="transparent"
                           class="user-add-record_ico user-add-record_ico__status fancy-top powertip" title="Статус"></a>
                    </div>
                </div>
            <?php endif ?>
            <?php if ($this->breadcrumbs):?>
                <div class="padding-l20">
                    <div class="crumbs-small clearfix">
                        <ul class="crumbs-small_ul">
                            <li class="crumbs-small_li">Я здесь:</li>
                            <li class="crumbs-small_li"><a href="/" class="crumbs-small_a">Главная</a></li> &gt;
                            <li class="crumbs-small_li"><a href="" class="crumbs-small_a">Наш дом</a></li> &gt;
                            <li class="crumbs-small_li"><a href="<?=$community->getUrl() ?>" class="crumbs-small_a"><?=$community->title ?></a></li> &gt;
                            <li class="crumbs-small_li"><span class="crumbs-small_last">Форум</span></li>
                        </ul>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="b-section">
        <div class="b-section_hold">
            <div class="content-cols clearfix">

                <div class="col-1">
                    <div class="club-list club-list__large clearfix">
                        <ul class="club-list_ul textalign-c clearfix">
                            <li class="club-list_li">
                                <a href="<?=$this->createUrl('/community/default/community', array('community_id'=>$this->community->id)) ?>" class="club-list_i">
                                    <span class="club-list_img-hold">
                                        <img src="/images/club/<?=$this->community->id ?>-w130.jpg" class="club-list_img">
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-23-middle">
                    <div class="padding-l20">
                        <h1 class="b-section_t"><a href=""><?=$this->community->title ?></a></h1>

                        <div class="clearfix">
                            <ul class="b-section_ul margin-l30 clearfix<?php if (isset($root)) echo ' b-section_ul__white'; ?>">
                                <li class="b-section_li">
                                    <a href="<?=$this->createUrl('/community/default/forum', array('community_id'=>$this->community->id)) ?>"
                                       class="b-section_li-a<?php if (isset($forum)) echo ' active' ?>">Форум</a>
                                </li>
                                <?php foreach($this->community->services as $service):?>
                                    <li class="b-section_li">
                                        <a href="<?=$service->getUrl() ?>" class="b-section_li-a<?php if (isset($service_id) && $service_id = $service->id) echo ' active' ?>"><?=$service->title ?></a>
                                    </li>
                                <?php endforeach ?>
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
            vm = new CommunitySubscription(<?=CJSON::encode(UserCommunitySubscription::subscribed(Yii::app()->user->id, $this->community->id))?>, <?=$this->community->id ?>);
            $(".js-community-subscription").each(function(index, el) {ko.applyBindings(vm, el)});
        });
    </script>
<?php $this->endContent(); ?>