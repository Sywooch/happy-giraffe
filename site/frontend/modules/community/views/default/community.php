<?php
/**
 * @var Community $community сообщество
 * @var User[] $moderators модераторы клуба
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var int $rubric_id выбранная рубрика
 */
?>
<div class="content-cols clearfix">
    <div class="col-1">
        <div class="sidebar-search clearfix">
            <input type="text" placeholder="Поиск по сайту" class="sidebar-search_itx" id="" name="">
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
                       class="user-add-record_ico user-add-record_ico__article fancy powertip" title="Статью"></a>
                    <a href="<?= $this->createUrl('/blog/default/form', array('type' => 3)) ?>" data-theme="transparent"
                       class="user-add-record_ico user-add-record_ico__photo fancy powertip" title="Фото"></a>
                    <a href="<?= $this->createUrl('/blog/default/form', array('type' => 2)) ?>" data-theme="transparent"
                       class="user-add-record_ico user-add-record_ico__video fancy powertip" title="Видео"></a>
                    <a href="<?= $this->createUrl('/blog/default/form', array('type' => 5)) ?>" data-theme="transparent"
                       class="user-add-record_ico user-add-record_ico__status fancy powertip" title="Статус"></a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>


<div class="b-section b-section__club b-section__green">
    <div class="b-section_hold">
        <div class="content-cols clearfix">
            <div class="col-1">
                <div class="club-list club-list__large clearfix">
                    <ul class="club-list_ul textalign-c clearfix">
                        <li class="club-list_li">
                            <a href="" class="club-list_i">
                                <span class="club-list_img-hold">
                                    <img src="/images/club/3-w240.jpg" alt="" class="club-list_img">
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-23-middle clearfix js-community-subscription">

                <div class="b-section_transp">
                    <h1 class="b-section_transp-t"><?=$community->title ?></h1>

                    <div class="b-section_transp-desc"><?=$community->description ?></div>

                    <a href="" class="b-section_club-add" data-bind="click: subscribe, visible: !active()">
                        <span class="b-section_club-add-tx">Вступить в клуб</span>
                    </a>

                    <div class="b-section_club-moder" data-bind="visible: active()">
                        <span class="b-section_club-moder-tx">Модераторы <br> клуба</span>
                        <?php foreach ($moderators as $moderator): ?>
                            <?php $this->widget('Avatar', array('user' => $moderator)); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="clearfix">
                    <ul class="b-section_ul b-section_ul__white margin-l30 clearfix">
                        <li class="b-section_li"><a href="<?=$this->createUrl('/community/default/forum', array('community_id'=>$community->id)) ?>" class="b-section_li-a">Форум</a></li>
                        <?php if (!empty($community->services)):?>
                            <li class="b-section_li"><a href="<?=$this->createUrl('/community/default/services', array('community_id'=>$community->id)) ?>" class="b-section_li-a">Сервисы</a></li>
                        <?php endif ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-1">

        <div class="widget-friends clearfix">
            <div class="clearfix">
                <span class="heading-small">Участники клуба <span class="color-gray">(<?= $user_count ?>)</span> </span>
            </div>
            <ul class="widget-friends_ul clearfix">
                <?php foreach ($users as $user): ?>
                    <li class="widget-friends_i">
                        <?php $this->widget('Avatar', array('user' => $user)); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="menu-simple">
            <ul class="menu-simple_ul">
                <?php foreach ($community->rubrics as $rubric): ?>
                    <li class="menu-simple_li<?php if ($rubric->id == $rubric_id) echo ' active' ?>">
                        <a class="menu-simple_a" href="<?= $rubric->getUrl() ?>"><?= $rubric->title ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
    <div class="col-23-middle ">
        <div class="clearfix margin-r20 margin-b20 js-community-subscription" data-bind="visible: active">
            <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1)) ?>" data-theme="transparent"
               class="btn-blue btn-h46 float-r fancy">Добавить в клуб</a>
        </div>
        <div class="col-gray">

            <?php
            $this->widget('zii.widgets.CListView', array(
                'cssFile' => false,
                'ajaxUpdate' => false,
                'dataProvider' => CommunityContent::model()->getContents($community->id, $rubric_id, null),
                'itemView' => 'blog.views.default.view',
                'pager' => array(
                    'class' => 'HLinkPager',
                ),
                'template' => '{items}
                    <div class="yiipagination">
                        {pager}
                    </div>
                ',
                'emptyText' => '',
                'viewData' => array('full' => false),
            ));
            ?>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        vm = new CommunitySubscription(<?=CJSON::encode(UserCommunitySubscription::subscribed(Yii::app()->user->id, $community->id))?>, <?=$community->id ?>);

        $(".js-community-subscription").each(function(index, el) {
            ko.applyBindings(vm, el);
        });
    });

    function CommunitySubscription(active, community_id) {
        var self = this;
        self.active = ko.observable(active);
        self.community_id = community_id;
        self.subscribe = function () {
            $.post('/community/subscribe/', {community_id: self.community_id}, function (response) {
                if (response.status)
                    self.active(true);
            }, 'json');
        }
    }
</script>