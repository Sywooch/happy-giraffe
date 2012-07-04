<?php if ($photos): ?>

    <div class="box activity-photo">

        <div class="title">Случайное <span>ФОТО</span></div>

        <div class="carousel-container">
            <div id="activity-photo" class="jcarousel">
                <ul>
                    <?php foreach ($photos as $p): ?>
                    <li>
                        <div class="user">
                            <span class="icon-status status-<?php echo $p->author->online == 1 ? 'online' : 'offline'; ?>"></span>
                            <?=CHtml::link(CHtml::encode($p->author->fullName), $p->author->url)?>
                        </div>
                        <div class="img">
                            <?php echo CHtml::link(CHtml::image($p->getPreviewUrl(170, 130, Image::WIDTH, true)), $p->url); ?>
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