<?php
//$albumsCount = count($albums = $this->user->getRelated('albums', true, array('scopes' => array('noSystem'), 'with'=>array('photoCount'))));
$criteria = new CDbCriteria;
$criteria->compare('author_id', $this->user->id);
$criteria->scopes = array('noSystem', 'active', 'permission');
$criteria->with = array('photoCount');
$albumsCount = count($albums = Album::model()->findAll($criteria));

foreach($albums as $key => $album)
    if ($album->photoCount == 0){
        $albumsCount--;
        unset($albums[$key]);
    }

if ($albumsCount > 0){
    shuffle($albums);
    $albums = array_slice($albums, 0, 2);
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/stylesheets/user.css');
?>
<div class="user-albums">
    <div class="box-title">
        <?php if(!Yii::app()->user->isGuest && $this->user->id == Yii::app()->user->id): ?>
            <?php
                Yii::import('application.controllers.AlbumsController');
                AlbumsController::loadUploadScritps();
                $link = Yii::app()->createUrl('/albums/addPhoto')
            ?>
            <a class="btn btn-orange-smallest a-right fancy" href="<?= $link; ?>"><span><span>Загрузить фото</span></span></a>
        <?php endif; ?>
        Фото
        <?= $albumsCount > 2 ? CHtml::link('Все альбомы (' . $albumsCount . ')', array('/albums/user', 'id' => $this->user->id)) : ''; ?>
    </div>
    <ul>
        <?php foreach($albums as $album): ?>
            <?php $photoCount = $album->photoCount ?>
            <?php if($photoCount == 0) continue; ?>
            <?php $album->photos = $album->getRelated('photos', true, array('limit' => 3)) ?>
            <li>
                <big>Альбом <?= CHtml::link(CHtml::encode($album->title), $album->url) ?></big>
                <div class="clearfix">
                    <div class="preview">
                        <?php $index = 1; ?>
                        <?php foreach($album->photos as $photo): ?>
                            <?= CHtml::link(CHtml::image($photo->getPreviewUrl(168, 144), '', array('class' => 'img-' . $index)), $photo->url); ?>
                            <?php $index++; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if($photoCount > 3): ?>
                        <a class="more" href="<?= $album->url ?>"><i class="icon"></i>еще <?= $photoCount - 3; ?> фото</a>
                    <?php else: ?>
                        <a class="more" href="<?= $album->url ?>"><i class="icon"></i>смотреть</a>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php } ?>