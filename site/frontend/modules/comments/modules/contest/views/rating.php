<?php
/**
 * @var site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant $participant
 */
$this->pageTitle = $this->contest->name . ' - Лидеры';
$cs = Yii::app()->clientScript;
$cs->registerAMD('contestCommentsIndex', array('kow'));
?>
<?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\ParticipantWidget', array(
    'contestId' => $this->contest->id,
));
?>
<contest-rating params="contestId: <?=$this->contest->id?>"></contest-rating>
