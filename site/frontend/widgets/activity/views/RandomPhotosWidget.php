<?php if ($photos): ?>

    <div class="box activity-photo">

        <div class="title">Случайное <span>ФОТО</span></div>

        <div class="carousel-container">
            <div id="activity-photo" class="jcarousel">
                <ul>
                    <?php foreach ($photos as $p): ?>
                    <li>
                        <div class="user">
                            <span class="icon-status status-<?php echo $p->user->online == 1 ? 'online' : 'offline'; ?>"></span>
                            <?=CHtml::link($p->user->fullName, $p->user->url)?>
                        </div>
                        <div class="img">
                            <?php echo CHtml::link(CHtml::image($p->getPreviewUrl(150, 150, Image::WIDTH)), array('/albums/photo', 'id' => $p->id)); ?>
                        </div>
                        <div class="item-title"><?php echo $p->title != '' ? $p->title : '&nbsp;' ?></div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="javascript:void(0);" onclick="$('#activity-photo').jcarousel('scroll', '-=1')" class="prev">предыдущая</a>
            <a href="javascript:void(0);" onclick="$('#activity-photo').jcarousel('scroll', '+=1')" class="next">следующая</a>
        </div>

    </div>

<?php endif; ?>