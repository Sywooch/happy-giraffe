<?php
/**
 * @var site\frontend\modules\photo\models\PhotoAlbum $album
 * @var int $count
 */
?>

<album-section params="userId: <?=$this->user->id?>, randomAlbum: <?=($album === null) ? null : $album->id?>, count: <?=$count?>"></album-section>