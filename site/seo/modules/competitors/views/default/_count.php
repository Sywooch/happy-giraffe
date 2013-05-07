<?php
/* @var $this Controller
 * @var $model SiteKeywordVisit
 * @var $freq int
 * @var $site_id int
 * @var $total_count int
 */

$criteria = $model->getCriteriaWithoutFreq();
$cache_id = 'site_keywords_count_'.$site_id;
$counts=Yii::app()->cache->get($cache_id);
if($counts===false)
{
    $counts = array(
        1 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreqForCounts()->addCondition(Keyword::getFreqCondition(1))),
        2 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreqForCounts()->addCondition(Keyword::getFreqCondition(2))),
        3 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreqForCounts()->addCondition(Keyword::getFreqCondition(3))),
        4 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreqForCounts()->addCondition(Keyword::getFreqCondition(4))),
    );
    Yii::app()->cache->set($cache_id,$counts, 24*3600);
}
?>
<div class="result">
    <label>Найдено: <a href="javascript:;"
                       onclick="CompetitorsTable.SetFreq(0);"><?=$total_count; ?></a></label>
    <span<?php if ($freq == 1) echo ' class="active"' ?>><i class="icon-freq-1"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(1);"><?=$counts[1] ?></a></span>
    <span<?php if ($freq == 2) echo ' class="active"' ?>><i class="icon-freq-2"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(2);"><?=$counts[2] ?></a></span>
    <span<?php if ($freq == 3) echo ' class="active"' ?>><i class="icon-freq-3"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(3);"><?=$counts[3] ?></a></span>
    <span<?php if ($freq == 4) echo ' class="active"' ?>><i class="icon-freq-4"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(4);"><?=$counts[4] ?></a></span>
</div>