<div class="broadcast-widget">
    <div class="broadcast-title-box">
        <h3><i class="icon-boradcast"></i> Прямой <span class="amethyst">эфир</span></h3>
        <ul class="broadcast-widget-menu">
            <li>
                <a href="<?=Yii::app()->createUrl('/whatsNew/default/index')?>"><span class="icon-boradcast-small" ></span>Весь прямой эфир</a>
            </li>
            <li>
                <a href="<?=Yii::app()->createUrl('/whatsNew/default/clubs')?>">Что нового в клубах</a>
            </li>
            <li>
                <a href="<?=Yii::app()->createUrl('/whatsNew/default/blogs')?>">Что нового в блогах</a>
            </li>
            <li>
                <a href="<?=Yii::app()->createUrl('/whatsNew/friends/index')?>"><span class="icon-friends" ></span>Что нового у друзей</a>
            </li>
        </ul>
    </div>
    <div class="carousel-container">
        <div id="masonry-news-list-jcarousel" class="masonry-news-list clearfix jcarousel">

            <a class="prev" href="#" ><</a>
            <a class="next" href="#">></a>
            <!--<a href="javascript:void(0);" onclick="$('#masonry-news-list-jcarousel').jcarousel('scroll', '-=1')" class="prev">предыдущая</a>
                                                 <a href="javascript:void(0);" onclick="$('#masonry-news-list-jcarousel').jcarousel('scroll', '+=1')" class="next">следующая</a> -->
            <ul id="masonry-news-list-jcarousel-ul">
                <?php foreach ($dp->data as $block): ?>
                    <?=$block->code?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>