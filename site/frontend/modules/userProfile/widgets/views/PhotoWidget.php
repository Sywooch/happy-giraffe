<?php
/**
 * @var site\frontend\modules\photo\models\PhotoAlbum $album
 */
?>

<album-section params="userId: <?= $album->author_id ?>, randomAlbum: <?=($album === null) ? null : $album->id?>"></album-section>