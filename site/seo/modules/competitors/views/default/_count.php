<?php
/* @var $this Controller
 * @var $model KeyStats
 * @var $freq int
 */

$criteria = $model->getCriteriaWithoutFreq();
$models = KeyStats::model()->findAll($criteria);

$counts = array(1=>0, 2=>0,3=>0,4=>0);
foreach($models as $model){
    if ($model->keyword->getFreq()){
        $counts[$model->keyword->getFreq()]++;
    }
}
?><div class="result">
    <label>Найдено: <a href="javascript:;" onclick="CompetitorsTable.SetFreq(0);"><?=KeyStats::model()->count($criteria); ?></a></label>
    <span<?php if ($freq == 1) echo ' class="active"' ?>><i class="icon-freq-1"></i> <a href="javascript:;" onclick="CompetitorsTable.SetFreq(1);"><?=$counts[1] ?></a></span>
    <span<?php if ($freq == 2) echo ' class="active"' ?>><i class="icon-freq-2"></i> <a href="javascript:;" onclick="CompetitorsTable.SetFreq(2);"><?=$counts[2] ?></a></span>
    <span<?php if ($freq == 3) echo ' class="active"' ?>><i class="icon-freq-3"></i> <a href="javascript:;" onclick="CompetitorsTable.SetFreq(3);"><?=$counts[3] ?></a></span>
    <span<?php if ($freq == 4) echo ' class="active"' ?>><i class="icon-freq-4"></i> <a href="javascript:;" onclick="CompetitorsTable.SetFreq(4);"><?=$counts[4] ?></a></span>
</div>