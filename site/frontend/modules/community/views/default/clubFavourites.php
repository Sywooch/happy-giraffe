<div class="content-cols clearfix">

    <div class="col-1">
        <div class="menu-simple">
            <ul class="menu-simple_ul">
                <li class="menu-simple_li<?php if ($type === null) echo ' active' ?>">
                    <a href="<?=$this->createUrl('/community/default/clubFavourites', array('clubId' => $this->club->id))?>" class="menu-simple_a">Все</a>
                </li>
                <li class="menu-simple_li<?php if ($type == 1) echo ' active' ?>">
                    <a href="<?=$this->createUrl('/community/default/clubFavourites', array('clubId' => $this->club->id, 'type' => 1))?>" class="menu-simple_a">Статьи</a>
                </li>
                <li class="menu-simple_li<?php if ($type == 2) echo ' active' ?>">
                    <a href="<?=$this->createUrl('/community/default/clubFavourites', array('clubId' => $this->club->id, 'type' => 2))?>" class="menu-simple_a">Видео</a>
                </li>
                <li class="menu-simple_li<?php if ($type == 3) echo ' active' ?>">
                    <a href="<?=$this->createUrl('/community/default/clubFavourites', array('clubId' => $this->club->id, 'type' => 3))?>" class="menu-simple_a">Фото-посты</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-23-middle ">
        <?php $this->widget('zii.widgets.CListView', array(
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