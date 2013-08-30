<?php
/**
 * @var CActiveDataProvider $dp
 * @var Community[] $communities
 * @var int $type
 * @var int $community_id
 */
?><div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->widget('Avatar', array('user' => Yii::app()->user->model, 'size' => Avatar::SIZE_LARGE)); ?>

        <div class="textalign-c margin-b40 clearfix">
            <a href="<?=$this->createUrl('/myGiraffe/default/recommends') ?>" class="btn-green btn-h46">Жираф рекомендует</a>
        </div>


        <div class="menu-list menu-list__purple">
            <a href="<?=$this->createUrl('/myGiraffe/default/index', array('type'=>SubscribeDataProvider::TYPE_ALL)) ?>" class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_ALL) echo ' active' ?>">
                <span class="menu-list_hold">
                    <span class="menu-list_ico-img">
                        <img src="/images/club/0-w50.png" alt="">
                    </span>
                    <span class="menu-list_tx">Все подписки</span>
                    <span class="menu-list_count">+ 28</span>
                </span>
            </a>
            <a href="<?=$this->createUrl('/myGiraffe/default/index', array('type'=>SubscribeDataProvider::TYPE_FRIENDS)) ?>" class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_FRIENDS) echo ' active' ?>">
                <span class="menu-list_hold">
                    <span class="menu-list_tx">Новое у друзей</span>
                    <span class="menu-list_count">+ 2568</span>
                </span>
            </a>
            <a href="<?=$this->createUrl('/myGiraffe/default/index', array('type'=>SubscribeDataProvider::TYPE_BLOGS)) ?>" class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_BLOGS) echo ' active' ?>">
                <span class="menu-list_hold">
                    <span class="menu-list_tx">Новое в блогах</span>
                    <span class="menu-list_count">+ 28</span>
                </span>
            </a>
            <?php foreach ($communities as $community): ?>
                <a href="<?=$this->createUrl('/myGiraffe/default/index', array('type'=>SubscribeDataProvider::TYPE_COMMUNITY, 'community_id'=>$community->id))?>" class="menu-list_i<?php if ($type == SubscribeDataProvider::TYPE_COMMUNITY && $community->id == $community_id) echo ' active' ?>">
                    <span class="menu-list_hold">
                        <span class="menu-list_ico-img">
                            <img src="/images/club/<?=$community->id ?>-w50.png" alt="">
                        </span>
                        <span class="menu-list_tx"><?=$community->title ?></span>
                        <span class="menu-list_count">+ 2</span>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
    <div class="col-23-middle col-gray">

        <div class="clearfix textalign-r margin-20">
            <span class="color-gray-dark padding-r5">Показывать только новые </span>
            <a class="a-checkbox active" href=""></a>
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
            'viewData' => array('full' => false),
        ));
        ?>

    </div>
</div>