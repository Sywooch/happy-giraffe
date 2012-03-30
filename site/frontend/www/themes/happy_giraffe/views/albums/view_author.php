<div class="main">
    <div class="main-in">
        <div id="gallery" class="nopadding">
            <div class="header">
                <div class="title">
                    <big>
                        Альбом <span>&laquo;<span class="album_title"><?php echo $model->title; ?></span>&raquo;</span>
                        <?php echo CHtml::link('<span class="tip">Редактировать</span>', array('albums/create', 'id' => $model->id), array('class' => 'edit', 'onclick=" return Album.changeTitle(this);"')); ?>
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
                    </big>
                    <div class="note">
                        <?php if($model->description && trim($model->description) != ''): ?>
                            <div class="fast-actions">
                                <?php echo CHtml::link('<span class="tip">Редактировать</span>', array('/albums/editDescription', 'id' => $model->id), array('class' => 'edit', 'onclick' => 'return Album.editDescription(this);')); ?>
                            </div>
                            <p><?php echo $model->description; ?></p>
                        <?php else: ?>
                            <div class="fast-actions">
                                <?php echo CHtml::link('<span class="tip">Написать комментарий</span>', array('/albums/editDescription', 'id' => $model->id), array('class' => 'add', 'onclick' => 'return Album.editDescription(this);')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="gallery-photos clearfix">
                <?php
                $this->widget('MyListView', array(
                    'id' => 'comment_list_view',
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_photo_author',
                    'summaryText' => 'показано: {start} - {end} из {count}',
                    'itemsTagName' => 'ul',

                    'pager' => array(
                        'class' => 'MyLinkPager',
                        'header' => 'Страницы',
                    ),
                    'template' => '{items}',
                    'viewData' => array(
                        'currentPage' => $dataProvider->pagination->currentPage,
                    ),
                    'afterAjaxUpdate' => 'appendAddLi();',
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<div class="side-left gallery-sidebar">
    <div class="fast-add">
        <?php
        $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget');
        $file_upload->loadScripts();
        $this->endWidget();
        echo CHtml::link('<span><span>Загрузить фото</span></span>', array('addPhoto', 'a' => $model->primaryKey), array('class' => 'fancy btn btn-green'));
        ?>
    </div>
    <div class="default-v-nav">
        <div class="title">Мои альбомы </div>
        <ul>
        <?php foreach($model->author->albums as $album): ?>
            <li<?php echo $model->id == $album->id ? ' class="active"' : ''; ?>>
                <div class="in">
                    <?php echo CHtml::link($album->title, array('/albums/view', 'id' => $album->id)); ?>
                    <span class="count"><?php echo count($album->photos); ?></span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>

<script type="text/javascript">
function appendAddLi() {
    $('#comment_list_view ul').append('<li class="add"><a href="<?php echo Yii::app()->createUrl('/albums/addPhoto', array('a' => $model->id)) ?>" class="fancy"><i class="icon"></i><span>Загрузить еще<br>фотографий</span></a></li>');
}
appendAddLi();
</script>