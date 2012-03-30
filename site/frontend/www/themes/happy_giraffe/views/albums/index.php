<div class="main">
    <div class="main-in">
        <div id="gallery" class="nopadding">
            <div class="header">
                <div class="title">
                    <big><span>Фотоальбомы</span></big>
                </div>
            </div>
            <?php foreach ($dataProvider->getData() as $model): ?>
            <div class="fast-album">
                <div class="header">
                    <div class="title">
                        <big>
                            Альбом <span>&laquo;<?php echo CHtml::link($model->title, array('albums/view', 'id' => $model->id)); ?>&raquo;</span>
                            <?php if($model->checkAccess === true): ?>
                            <div class="visibility-picker">
                                <a onclick="albumVisibilityListToggle(this)" class="album-visibility" href="javascript:void(0);">
                                    <?php
                                    for($i = 3; $i > $model->permission; $i--)
                                        echo '<span></span>';
                                    ?>
                                    <span class="tip">Кому показывать</span>
                                </a>
                                <div class="visibility-list">
                                    <div class="tale"></div>
                                    <ul>
                                        <li onclick="albumVisibilitySet(this, 0, <?php echo $model->id; ?>)">
                                            <div class="text">для всех</div>
                                            <div class="album-visibility small">
                                                <span></span><span></span><span></span>
                                            </div>
                                        </li>
                                        <li onclick="albumVisibilitySet(this, 1, <?php echo $model->id; ?>)">
                                            <div class="text">для друзей</div>
                                            <div class="album-visibility small">
                                                <span></span><span></span>
                                            </div>
                                        </li>
                                        <li onclick="albumVisibilitySet(this, 2, <?php echo $model->id; ?>)">
                                            <div class="text">для меня</div>
                                            <div class="album-visibility small">
                                                <span></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                        </big>
                        <?php if ($model->description): ?>
                        <div class="note">
                            <p><?php echo $model->description; ?></p>
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
                            <?php echo CHtml::link('', array('albums/view', 'id' => $model->id), array('class' => 'icon')); ?>
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
        $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget');
        $file_upload->loadScripts();
        $this->endWidget();
        echo CHtml::link('<span><span><i class="add"></i>Загрузить фото</span></span>', array('addPhoto'), array('class' => 'fancy btn btn-green'));
        ?>
    </div>

    <div class="default-v-nav">
        <ul>
            <li<?php echo !isset($_GET['permission']) ? ' class="active"' : '' ?>>
                <div class="in">
                    <?php echo CHtml::link('Все альбомы', array('/albums/index')); ?>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
            <li>
                <div class="in">
                    <a href="">Альбомы для просмотра</a>
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
            <li class="service">
                <div class="in">
                    <a href="">Служебные альбомы</a>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
        </ul>

    </div>

</div>
<?php endif; ?>