<?php
/**
 * @var site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant $participant
 */
?>
<?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\ParticipantWidget', array(
    'userId' => Yii::app()->user->id,
    'contestId' => $this->contest->id,
));
$cs = Yii::app()->clientScript;
$cs->registerAMD('contestCommentsIndex', array('kow'));
?>
<contest-rating params="contestId: <?=$this->contest->id?>"></contest-rating>
