<?php
/* @var $this Controller
 * @var $model SiteKeywordVisit
 * @var $freq int
 */

$criteria = $model->getCriteriaWithoutFreq();
$counts = array(
    1 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreq()->addCondition(Keyword::getFreqCondition(1))),
    2 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreq()->addCondition(Keyword::getFreqCondition(2))),
    3 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreq()->addCondition(Keyword::getFreqCondition(3))),
    4 => SiteKeywordVisit::model()->count($model->getCriteriaWithoutFreq()->addCondition(Keyword::getFreqCondition(4))),
);
?>
<div class="result">
    <label>Найдено: <a href="javascript:;"
                       onclick="CompetitorsTable.SetFreq(0);"><?=SiteKeywordVisit::model()->count($criteria); ?></a></label>
    <span<?php if ($freq == 1) echo ' class="active"' ?>><i class="icon-freq-1"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(1);"><?=$counts[1] ?></a></span>
    <span<?php if ($freq == 2) echo ' class="active"' ?>><i class="icon-freq-2"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(2);"><?=$counts[2] ?></a></span>
    <span<?php if ($freq == 3) echo ' class="active"' ?>><i class="icon-freq-3"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(3);"><?=$counts[3] ?></a></span>
    <span<?php if ($freq == 4) echo ' class="active"' ?>><i class="icon-freq-4"></i> <a href="javascript:;"
                                                                                        onclick="CompetitorsTable.SetFreq(4);"><?=$counts[4] ?></a></span>
</div>