<?php
/**
 * @var \site\frontend\modules\photo\models\Photo $photo
 */
?>

<gif-image params="link: '<?=Yii::app()->thumbs->getThumb($photo, 'buzzSidebar', false, false)?>', animated: '<?=Yii::app()->thumbs->getThumb($photo, 'buzzSidebar', false, true)?>'"></gif-image>