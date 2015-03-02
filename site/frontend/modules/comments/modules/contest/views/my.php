<?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\ParticipantWidget', array(
    'userId' => Yii::app()->user->id,
    'contestId' => $this->contest->id,
));
$cs = Yii::app()->clientScript;
$cs->registerAMD('contestCommentsIndex', array('kow'));
?>

<!-- призы-->
<contest-comments params="contestId: <?=$this->contest->id?>, userId: 23, title: 'Моя лента'"></contest-comments>
