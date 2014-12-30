<?php
/**
 * @var site\frontend\modules\photo\models\PhotoAlbum $album
 */
?>

<album-section params="userId: <?=$this->user->id?>, randomAlbum: <?=($album === null) ? null : $album->id?>"></album-section>