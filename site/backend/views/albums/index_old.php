<div class="main">
    <div class="main-in">
        <div id="gallery" class="nopadding">
            <div class="header<?php echo isset($_GET['system']) && $_GET['system'] == 1 ? ' service-header' : '' ?>">
                <div class="title">
                    <big><?php echo isset($_GET['system']) && $_GET['system'] == 1 ? 'Служебные фотоальбомы' : '<span>Фотоальбомы</span>' ?></big>
                    <?php if(isset($_GET['system']) && $_GET['system'] == 1): ?>
                        <div class="note">
                            <p>В служебные фотоальбомы попадают изображения, которые использовались в ваших записях в блогах и клубах, а также в диалогах с другими пользователями. Эти альбомы не видны никому, кроме вас.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php foreach ($dataProvider->getData() as $model): ?>
            <div class="fast-album">
                <div class="header">
                    <div class="title">
                        <big>
                            Альбом <span>&laquo;<?php echo CHtml::link(CHtml::encode($model->title), $model->url); ?>&raquo;</span>
                            <?php if(0 && $model->isNotSystem && !Yii::app()->user->isGuest && Yii::app()->user->id == $model->author_id): ?>
                                <div class="album-visibility small hl">
                                    <?php for ($i = 3; $i > $model->permission; $i--): ?>
                                        <span></span>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </big>
                        <?php if ($model->description): ?>
                        <div class="note">
                            <p><?php echo CHtml::encode($model->description); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="gallery-photos clearfix">
                    <ul>
                        <?php foreach ($model->getRelated('photos', true, array('limit' => 3)) as $photo): ?>
                            <?php $this->renderPartial('_photo', array('data' => $photo)); ?>
                        <?php endforeach; ?>
                        <?php if (($count = count($model->photos)) >= 3): ?>
                        <li class="more">
                            <?php echo CHtml::link('', $model->url, array('class' => 'icon')); ?>
                            <?php if($count > 3): ?>
                                еще <?php echo $count - 3; ?> фото
                            <?php else: ?>
                                смотреть
                            <?php endif; ?>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if($access === true): ?>
<div class="side-left gallery-sidebar">
    <div class="fast-add">
        <?php
        AlbumsController::loadUploadScritps();
        echo CHtml::link('<span><span>Загрузить фото</span></span>', array('addPhoto'), array('class' => 'fancy btn btn-green'));
        ?>
    </div>

    <div class="default-v-nav">
        <ul>
            <li<?php echo !isset($_GET['permission']) && !isset($_GET['system']) ? ' class="active"' : '' ?>>
                <div class="in">
                    <?php echo CHtml::link('Все альбомы', array('/albums/index')); ?>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li>
                <div class="in">
                    <?php echo CHtml::link('Альбомы для просмотра', array('/albums/index', 'system' => 0)); ?>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
                <ul>
                    <?php foreach(Album::$permissions as $index => $permission): ?>
                        <li<?php echo isset($_GET['permission']) && $_GET['permission'] == $index ? ' class="active"' : '' ?>>
                            <div class="in">
                                <?php echo CHtml::link($permission, array('/albums/index', 'permission' => $index)); ?>
                                <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li class="service<?php echo isset($_GET['system']) && $_GET['system'] == 1 ? ' active' : '' ?>">
                <div class="in">
                    <?php echo CHtml::link('Служебные альбомы', array('/albums/index', 'system' => 1)); ?>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
        </ul>

    </div>

</div>
<?php endif; ?>