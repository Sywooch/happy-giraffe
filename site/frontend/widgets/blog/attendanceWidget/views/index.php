<div class="blog-statistic">
    <div class="block-title">Посещаемость блога</div>
    <div class="clearfix">
        <div class="counter-speed-img"></div>
        <div class="count-lines">
            <div class="row">
                Вчера: <?=$yesterday?>
            </div>
            <div class="row">
                Сегодня: <?=$today?>
            </div>
            <div class="row">
                Всего:
                <div class="blog-count-all">
                    <?php for ($i = 0; $i < 7; $i++): ?>
                        <?=(($i + strlen($total)) < 7) ? CHtml::tag('span', array(), '0') : CHtml::tag('span', array('class' => 'active'), substr($total, 7 - strlen($total) - $i, 1))?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>