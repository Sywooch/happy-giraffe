<?php
/**
 * @var CActiveDataProvider $dp
 * @var Community[] $communities
 * @var int $type
 * @var int $community_id
 */
?>
<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('Avatar', array('user' => Yii::app()->user->model, 'size' => Avatar::SIZE_LARGE)); ?>

        <div class="textalign-c margin-b40 clearfix">
            <a href="<?= $this->createUrl('/myGiraffe/default/recommends') ?>" class="btn-green btn-h46">Жираф рекомендует</a>
        </div>


        <div class="menu-list menu-list__purple">
            <a href="<?= $this->createUrl('/myGiraffe/default/index', array('type' => SubscribeDataProvider::TYPE_ALL)) ?>"
               class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_ALL) echo ' active' ?>">
                <span class="menu-list_hold">
                    <span class="menu-list_ico-img">
                        <img src="/images/club/0-w50.png" alt="">
                    </span>
                    <span class="menu-list_tx">Все подписки</span>
                    <?php $count = ViewedPost::getInstance()->newPostCount(Yii::app()->user->id, SubscribeDataProvider::TYPE_ALL);
                    if ($count) {
                        ?>
                        <span class="menu-list_count">+ <?= $count ?></span>
                    <?php } ?>
                </span>
            </a>
            <a href="<?= $this->createUrl('/myGiraffe/default/index', array('type' => SubscribeDataProvider::TYPE_FRIENDS)) ?>"
               class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_FRIENDS) echo ' active' ?>">
                <span class="menu-list_hold">
                    <span class="menu-list_tx">Новое у друзей</span>
                    <?php $count = ViewedPost::getInstance()->newPostCount(Yii::app()->user->id, SubscribeDataProvider::TYPE_FRIENDS);
                    if ($count) {
                        ?>
                        <span class="menu-list_count">+ <?= $count ?></span>
                    <?php } ?>
                </span>
            </a>
            <a href="<?= $this->createUrl('/myGiraffe/default/index', array('type' => SubscribeDataProvider::TYPE_BLOGS)) ?>"
               class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_BLOGS) echo ' active' ?>">
                <span class="menu-list_hold">
                    <span class="menu-list_tx">Новое в блогах</span>
                    <?php $count = ViewedPost::getInstance()->newPostCount(Yii::app()->user->id, SubscribeDataProvider::TYPE_BLOGS);
                    if ($count) {
                        ?>
                        <span class="menu-list_count">+ <?= $count ?></span>
                    <?php } ?>
                </span>
            </a>
            <?php foreach ($communities as $community): ?>
                <a href="<?= $this->createUrl('/myGiraffe/default/index', array('type' => SubscribeDataProvider::TYPE_COMMUNITY, 'community_id' => $community->id)) ?>"
                   class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_COMMUNITY && $community->id == $community_id) echo ' active' ?>">
                    <span class="menu-list_hold">
                        <span class="menu-list_ico-img">
                            <img src="/images/club/<?= $community->id ?>-w50.png" alt="">
                        </span>
                        <span class="menu-list_tx"><?= $community->title ?></span>
                        <?php $count = ViewedPost::getInstance()->newPostCount(Yii::app()->user->id, SubscribeDataProvider::TYPE_COMMUNITY, $community->id);
                        if ($count) {
                            ?>
                            <span class="menu-list_count">+ <?= $count ?></span>
                        <?php } ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
    <div class="col-23-middle col-gray">

        <?php $this->widget('HoroscopeWidget') ?>

        <?php $this->widget('PopularPostsWidget') ?>

        <div class="clearfix textalign-r margin-20">
            <span class="color-gray-dark padding-r5">Показывать только новые </span>
            <a id="show-only-new" class="a-checkbox<?php if (UserAttributes::get(Yii::app()->user->id, 'my_giraffe_only_new')) echo ' active' ?>" href="javascript:;"></a>
        </div>

        <?php
        $this->widget('zii.widgets.CListView', array(
            'cssFile' => false,
            'ajaxUpdate' => false,
            'dataProvider' => $dp,
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
            'viewData' => array('full' => false, 'show_new' => true),
        ));
        ViewedPost::getInstance()->addViews($dp->getData());
        ?>

    </div>
</div>
<script type="text/javascript">
    $('#show-only-new').click(function () {
        var self = $(this);
        var val = $(this).hasClass('active') ? 0 : 1;
        $.post('/my/onlyNew/', {val: val}, function (response) {
            if (response.success){
                self.toggleClass('active');
                location.reload();
            }
        }, 'json');
        return false;
    });
</script>