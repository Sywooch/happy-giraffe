<?php
$this->pageTitle = $this->getText('title') . ' - ' . $period->title;
$this->breadcrumbs = array(
    $this->getText('title') => array('/calendar/default/index', 'calendar' => $this->calendar),
    $period->title,
);
$i = 0;
while ($periods[$i]->id !== $period->id)
    $i++;
$prevPeriod = isset($periods[$i - 1]) ? $periods[$i - 1] : null;
$nextPeriod = isset($periods[$i + 1]) ? $periods[$i + 1] : null;
?>
<?php
if ($period->features && $period->features_heading)
{
    // Странный костыль для вставки особенностей периода
    $features = explode("\n", trim($period->features));
    ob_start();
    ?>
    <div class="age-features<?php if ($period->calendar == 1): ?> age-features-pregnancy<?php endif; ?>">
    </div>
    <div class="b-main_row calendar-serv-note">
        <?php  preg_match('#(\d+)#',$period->features_heading, $calendar_count); ?>
        <?php if(isset($calendar_count[0])) { ?>
            <div class="calendar-serv-note_count"><?= $calendar_count[0] ?></div>
        <?php } ?>
        <div class="b-main_col-article b-main_col-article__center">
            <h2 class="calendar-serv-note_t"><?= preg_replace('#(\d+)#', '<span>$1</span>', $period->features_heading) ?></h2>
            <ul class="calendar-serv-note_ul">
                <?php
                foreach ($features as $f)
                    echo CHtml::tag('li', array('class' => 'calendar-serv-note_li'), $f);
                ?>
            </ul>
        </div>
    </div>
    <?php
    $features = ob_get_clean();
    Yii::import('site.frontend.extensions.phpQuery.phpQuery');
    $doc = phpQuery::newDocumentXHTML($period->text, $charset = 'utf-8');
    $paragraphs = $doc->find('p');
    $paragraphsCount = count($paragraphs);
    $pI = ($period->calendar == 0) ? floor($paragraphsCount / 3) : floor($paragraphsCount / 1.8);
    $p = $doc->find('p:eq(' . $pI . ')');
    $p->after($features);
    $period->text = $doc->html();
    $doc->unloadDocument();
}
?>
<div class="services-calendars services-calendars__<?= $this->getText('class') ?>">
    <div class="b-main_cont">
        <div class="b-main_col-wide">   
            <h1 class="heading-link-xxl heading-link-xxl__center"><?= $period->heading ?></h1>
        </div>
        <table class="article-nearby clearfix">
            <tr>
                <td><?php if ($prevPeriod) echo CHtml::link(CHtml::tag('span', array('class' => 'article-nearby_tx'), $prevPeriod->title), $prevPeriod->url, array('class' => 'article-nearby_a article-nearby_a__l')); ?></td>
                <td><?php if ($nextPeriod) echo CHtml::link(CHtml::tag('span', array('class' => 'article-nearby_tx'), $nextPeriod->title), $nextPeriod->url, array('class' => 'article-nearby_a article-nearby_a__r')); ?></td>
            </tr>
        </table>
    </div>
    <div class="b-main_cont">
        <div class="b-main_col-article b-main_col-article__center wysiwyg-content">
            <script>
                $(window).ready(function () {
                    var docWidth = $(document).width();
                    if (docWidth > 640 && docWidth < 1000) {
                        $('.calendar-serv-note_count').css({'right': (1000 - docWidth)/2})
                    }
                });
            </script>
            <?php
            echo $period->text;
            ?>
        </div>
        <!-- Реклама яндекса-->
        <?php $this->renderPartial('//banners/_direct_others'); ?>
    </div>
    <?php if ($period->communities): ?>
        <div class="b-main_row services-fast margin-b0">
            <div class="b-main_cont">
                <div class="services-fast_hold">
                    <div class="b-main_col-article b-main_col-article__center">
                        <div class="services-fast_t heading-m">Полезные сервисы. Попробуйте!</div>
                        <ul class="services-fast_ul">
                            <?php foreach ($period->services as $s): ?>
                                <li class="services-fast_li">
                                    <a class="services-fast_a" href="<?= $s->url ?>">
                                        <span class="services-fast_ico">
                                            <?= CHtml::image('/images/services/service_img_' . $s->id . '.png') ?>
                                            <span class="verticalalign-m-help"></span>
                                        </span>
                                        <div class="services-fast_tx">
                                            <?= $s->title ?>
                                        </div>
                                    </a>
                                </li>
                            <?php endforeach; ?>

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (false && $period->calendar == 1 && $nextPeriod): ?>
        <div class="ban-read-more hidden-md">
            <div class="ban-read-more_hold">
                <div class="ban-read-more_cont">
                    <div class="ban-read-more_t-sub">следующая неделя</div>
                    <div class="ban-read-more_t"><?= $nextPeriod->heading ?></div>
                    <div class="ban-read-more_desc"><?= $nextPeriod ?></div>
                    <span class="ban-read-more_arrow"></span>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
