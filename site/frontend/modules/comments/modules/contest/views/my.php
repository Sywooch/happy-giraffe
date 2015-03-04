<?php
$this->pageTitle = 'Лучший комментатор - О конкурсе';
$cs = Yii::app()->clientScript;
$cs->registerAMD('contestCommentsIndex', array('kow'));
?>

<?php
$this->widget('site\frontend\modules\comments\modules\contest\widgets\ParticipantWidget', array(
    'contestId' => $this->contest->id,
));
?>

<!-- призы-->
<contest-comments params="contestId: <?=$this->contest->id?>, userId: <?=Yii::app()->user->id?>, title: 'Моя лента'"></contest-comments>
