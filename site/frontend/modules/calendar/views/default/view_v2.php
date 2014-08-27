<?php
$this->pageTitle = $this->getText('title') . ' - ' . $period->title;
$this->breadcrumbs = array(
    $this->getText('title') => array('/calendar/default/index', 'calendar' => $this->calendar),
    $period->title,
);
?>
<?php
if ($period->features && $period->features_heading)
{
    // Странный костыль для вставки особенностей периода
    $features = explode("\n", $period->features);
    ob_start();
    ?>
    <div class="age-features<?php if ($period->calendar == 1): ?> age-features-pregnancy<?php endif; ?>">
    </div>
    <div class="b-main_row calendar-serv-note">
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
<!-- В зависимости от сервиса есть класс services-calendars__pregnancy или services-calendars__child -->
<div class="services-calendars services-calendars__child">
    <div class="b-main_cont">
        <div class="b-main_col-wide">   
            <h1 class="heading-link-xxl heading-link-xxl__center"><?= $period->heading ?></h1>
        </div>
        <table class="article-nearby clearfix">
            <tr>
                <?php
                $i = 0;
                while ($periods[$i]->id !== $period->id)
                    $i++;
                ?>
                <td><?php if(isset($periods[$i-1])) echo CHtml::link (CHtml::tag ('span', array('class' => 'article-nearby_tx'), $periods[$i-1]->title), $periods[$i-1]->url, array('class' => 'article-nearby_a article-nearby_a__l')); ?></td>
                <td><?php if(isset($periods[$i+1])) echo CHtml::link (CHtml::tag ('span', array('class' => 'article-nearby_tx'), $periods[$i+1]->title), $periods[$i+1]->url, array('class' => 'article-nearby_a article-nearby_a__r')); ?></td>
            </tr>
        </table>
    </div>
    <div class="b-main_cont">
        <div class="b-main_col-article b-main_col-article__center wysiwyg-content">
            <?php
            echo $period->text;
            ?>
        </div>
    </div>
    <?php if ($period->communities): ?>
        <!-- /Яндрекс реклама/ -->
        <div class="b-main_row services-fast margin-b0">
            <div class="b-main_cont">
                <div class="services-fast_hold">
                    <div class="b-main_col-article b-main_col-article__center">
                        <div class="services-fast_t heading-m">Полезные сервисы. Попробуйте!</div>
                        <ul class="services-fast_ul">
                            <?php foreach ($period->communities as $c): ?>
                                <li class="services-fast_li">
                                    <a class="services-fast_a" href="<?= $c->url ?>">
                                        <div class="services-fast_ico">
                                            <?= CHtml::image('/images/club_img_' . $c->id . '.png') ?>
                                        </div>
                                        <div class="services-fast_tx">
                                            <?= $c->title ?>
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
    <!-- /Баннер о следующей статье, появляется у планшета и меньших экранов/ -->
</div>