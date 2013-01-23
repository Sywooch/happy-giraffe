<?php
    $cs = Yii::app()->clientScript;
    $cs
        ->registerCssFile('/stylesheets/baby.css')
    ;
?>

<?php if ($period->features && $period->features_heading): ?>
    <?php
        $features = explode("\n", $period->features);
    ?>
    <?php ob_start(); ?>
    <div class="age-features<?php if ($period->calendar == 1): ?> age-features-pregnancy<?php endif; ?>">
        <div class="title"><?=preg_replace('#(\d+)#', '<span>$1</span>', $period->features_heading)?>:</div>
        <ul>
            <?php foreach ($features as $f): ?>
                <li><?=$f?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php $features = ob_get_clean(); ?>
    <?php
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        $doc = phpQuery::newDocumentXHTML($period->text, $charset = 'utf-8');
        $paragraphs = $doc->find('p');
        $paragraphsCount = count($paragraphs);
        $pI = ($period->calendar == 0) ? floor($paragraphsCount / 3) : floor($paragraphsCount / 1.8);
        $p = $doc->find('p:eq(' . $pI . ')');
        $p->after($features);
        $period->text = $doc->html();
        $doc->unloadDocument();
    ?>
<?php endif; ?>

<div id="crumbs">
    <a href="">Главная</a> &nbsp;>&nbsp; <a href="">Клубы</a> &nbsp;>&nbsp; <span>Календарь ребенка</span>
</div>

<div id="baby">

    <?php if ($period->calendar == 0): ?>
        <div class="age-list">
            <div class="block-title"><span>Выберите возраст Вашего ребенка</span></div>
            <ul>
                <?php foreach ($periods as $i => $p): ?>
                    <?php
                        if ($i == 0) {
                            $class = 'birth';
                        } elseif ($i < 4) {
                            $class = 'weeks';
                        } elseif ($i < 19) {
                            $class = 'monthes';
                        } elseif ($i < 22) {
                            $class = 'years';
                        } elseif ($i == 24) {
                            $class = 'teen one-line';
                        } else {
                            $class = 'teen';
                        }

                        if ($i == 0) {
                            $aContent = '<i class="icon-stork"></i>';
                        } elseif ($i > 21) {
                            $aContent = $p->title;
                        } else {
                            $aContent = '';
                        }

                        $active = $period->id == $p->id;
                    ?>
                    <li class="<?=$class?><?php if ($active): ?> active<?php endif; ?>">
                        <?=CHtml::link($aContent, $p->url, array('title' => $p->title, 'class' => 'tooltip'))?>
                        <div class="age-title"><?=$p->title?></div>
                        <?php if ($i == 0): ?>
                            <div class="no-flag">Рождение</div>
                        <?php elseif ($i == 5): ?>
                            <div class="flag"><i class="icon"></i>1 месяц</div>
                        <?php elseif ($i == 10): ?>
                            <div class="flag"><i class="icon"></i>6 месяцев</div>
                        <?php elseif ($i == 16): ?>
                            <div class="flag hl"><i class="icon"></i>1 год</div>
                        <?php elseif ($i == 22): ?>
                            <div class="flag"><i class="icon"></i>3 года</div>
                        <?php elseif ($i == 23): ?>
                        <div class="flag"><i class="icon"></i>7 лет</div>
                        <?php elseif ($i == 24): ?>
                        <div class="flag"><i class="icon"></i>11 лет</div>
                        <?php elseif ($i == 25): ?>
                        <div class="flag"><i class="icon"></i>15 лет</div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                <li>
                    <i class="icon-18"></i>
                </li>
            </ul>
        </div>
    <?php else: ?>
        <div class="age-list age-list-pregnancy">
            <div class="block-title"><span>Выберите период вашей беременности</span></div>
            <ul>
                <?php foreach ($periods as $i => $p): ?>
                <?php
                    if ($i == 0) {
                        $class = 'planing teen one-line';
                    } elseif ($i == (count($periods) - 1)) {
                        $class = 'birthing teen one-line';
                    } else {
                        $class = 'weeks';
                    }

                    $aContent = ($i == 0 || $i == (count($periods) - 1)) ? $p->title : '';

                    $active = $period->id == $p->id;
                ?>
                <li class="<?=$class?><?php if ($active): ?> active<?php endif; ?>">
                    <?=CHtml::link($aContent, $p->url, array('title' => $p->title, 'class' => 'tooltip'))?>
                    <div class="age-title"><?=$p->title?></div>
                    <?php if ($i == 1): ?>
                    <div class="flag"><i class="icon"></i>1 триместр</div>
                    <?php elseif ($i == 13): ?>
                    <div class="flag"><i class="icon"></i>2 триместр</div>
                    <?php elseif ($i == 28): ?>
                    <div class="flag"><i class="icon"></i>3 триместр</div>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="content-box clearfix">

        <div class="main">
            <div class="main-right">

                <div class="article<?php if ($period->calendar == 1): ?> article-pregnancy<?php endif; ?>">
                    <?php
                        if (! empty($period->heading)) {
                            $heading = $period->heading;
                        } elseif ($period->calendar == 0) {
                            $heading = 'Вашему малышу ' . $period->title;
                        } else {
                            $heading = $period->title . ' беременности';
                        }
                    ?>
                    <h1><?=$heading?></h1>
                    <div class="entry-nav clearfix">
                        <?php if ($next = $period->next): ?>
                            <div class="next">
                                <?=CHtml::link($next->title, $next->url)?> &rarr;
                            </div>
                        <?php endif; ?>
                        <?php if ($prev = $period->prev): ?>
                            <div class="prev">
                                &larr; <?=CHtml::link($prev->title, $prev->url)?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="wysiwyg-content clearfix">

                        <?=$period->text?>

                    </div>

                </div>

                <?php if ($period->services): ?>
                    <div class="baby-fast-services">
                        <div class="block-title"><span>Попробуйте!</span> Полезные сервисы</div>
                        <ul>
                            <?php foreach ($period->services as $s): ?>
                                <li>
                                    <div class="img"><?=CHtml::link(CHtml::image('/images/services/service_img_' . $s->id . '.png'), $s->url)?></div>
                                    <div class="text">
                                        <div class="item-title"><?=CHtml::link($s->title, $s->url)?></div>
                                        <p><?=$s->description?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>

        </div>

        <div class="side-right">

            <?php if ($period->randomContents): ?>
                <div class="need-to-know">

                    <?php if ($period->calendar == 0): ?>
                        <div class="block-title">
                            <span><?=$period->title?></span>
                            Важно знать!
                        </div>
                    <?php endif; ?>

                    <ul>
                        <?php foreach ($period->randomContents as $c): ?>
                            <li>
                                <?php if ($period->calendar != 0): ?>
                                    <div class="user clearfix">
                                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                        'user' => $c->author,
                                        'size' => 'small',
                                        'location' => false,
                                        'sendButton' => false,
                                    )); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="item-title"><?=CHtml::link($c->title, $c->url)?></div>
                                <?php if ($img = $c->contentImage): ?>
                                    <div class="img"><?=CHtml::link(CHtml::image($img), $c->url)?></div>
                                <?php endif; ?>
                                <?php if ($content = $c->getContentText(170)): ?>
                                    <div class="content">
                                        <p><?=trim($content)?> &nbsp; <?=CHtml::link('Читать', $c->url)?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="meta">
                                    <span class="views"><i class="icon"></i><?=PageView::model()->viewsByPath($c->url)?></span>
                                    <?=CHtml::link('<i class="icon"></i>' . $c->commentsCount, $c->getUrl(true), array('class' => 'comments'))?>
                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>

                </div>
            <?php endif; ?>

            <?php if ($period->communities): ?>
                <div class="baby-clubs">

                    <div class="block-title">
                        <span>Общайтесь!</span>
                        Клубы для общения
                    </div>

                    <ul>
                        <?php foreach ($period->communities as $c): ?>
                            <li>
                                <div class="img club-img <?=$c->css_class ?>">
                                    <?=CHtml::link(CHtml::image('/images/club_img_' . $c->id . '.png'), $c->url)?>
                                </div>
                                <div class="text">
                                    <div class="item-title"><?=CHtml::link($c->title, $c->url)?></div>
                                    <div class="topics">Тем: <?=CHtml::link($c->contentsCount, $c->url)?></div>
                                    <?=CHtml::link('<i class="icon"></i>' . $c->commentsCount, $c->url, array('class' => 'comments'))?>
                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>

                </div>
            <?php endif; ?>

        </div>
    </div>

</div>