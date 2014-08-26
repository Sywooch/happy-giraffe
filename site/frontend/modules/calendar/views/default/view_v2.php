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
    <div class="b-main_row calendar-serv-note calendar-serv-note__blue-light margin-t40">
        <div class="b-main_cont">
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
<div class="b-main_cont">
    <div class="b-main_col-wide">   
        <h1 class="heading-link-xxl heading-link-xxl__center"><?= $period->heading ?></h1>
    </div>
    <table class="article-nearby clearfix">
        <tr>
            <td><a href="#" class="article-nearby_a article-nearby_a__l"><span class="article-nearby_tx">4-й месяц </span></a></td>
            <td><a href="#" class="article-nearby_a article-nearby_a__r"><span class="article-nearby_tx">6-й месяц</span></a></td>
        </tr>
    </table>
</div>
<div class="b-main_cont">
    <div class="b-main_col-article b-main_col-article__center">
<?php
echo $period->text;
?>
    </div>
</div>
<?php if ($period->communities): ?>
    <div class="baby-clubs">

        <div class="block-title">
            <span>Общайтесь!</span>
            Клубы для общения
        </div>

        <ul>
            <?php foreach ($period->communities as $c): ?>
                <li>
                    <div class="img club-img <?= $c->css_class ?>">
                        <?= CHtml::link(CHtml::image('/images/club_img_' . $c->id . '.png'), $c->url) ?>
                    </div>
                    <div class="text">
                        <div class="item-title"><?= CHtml::link($c->title, $c->url) ?></div>
                        <div class="topics">Тем: <?= CHtml::link($c->contentsCount, $c->url) ?></div>
                        <?= CHtml::link('<i class="icon"></i>' . $c->commentsCount, $c->url, array('class' => 'comments')) ?>
                    </div>
                </li>
            <?php endforeach; ?>

        </ul>

    </div>
<?php endif; ?>