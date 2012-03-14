<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <?php $this->widget('AvatarWidget', array('user' => $model->author)); ?>
                <p><span><?php echo $model->author->fullName; ?></span>
                    <?php if($model->author->country): ?>
                        <br><?php echo $model->author->country->name; ?></p>
                    <?php endif; ?>
            </div>
            <div class="back-link">&larr; <?php echo CHtml::link('В анкету', array('/user/profile', 'user_id' => $model->author->id)) ?></div>
        </div>
        <div class="all-link">
            <?php
            echo CHtml::link('Все альбомы ('.count($model->author->albums).')', array('/albums/user', 'id' => $model->author_id)) . '<br/>';
            $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget');
            $file_upload->loadScripts();
            $this->endWidget();
            echo CHtml::link('<span><span><i class="add"></i>Добавить фото</span></span>', array('addPhoto', 'a' => $model->primaryKey), array('class' => 'fancy btn btn-green-medium'));
            ?>
        </div>
        <div class="title">
            <big>
                Альбом <span>&laquo;<?php echo $model->title; ?>&raquo;</span>
                <?php echo CHtml::link('', array('albums/create', 'id' => $model->id), array('class' => 'edit')); ?>
            </big>
            <?php if ($model->description): ?>
            <div class="note">
                    <div class="fast-actions">
                        <?php echo CHtml::link('', array('/albums/editDescription', 'id' => $model->id), array('class' => 'edit', 'onclick' => 'return Album.editDescription(this);')); ?>
                        <?php echo CHtml::link('', array('/albums/editDescription', 'id' => $model->id), array('class' => 'remove', 'onclick' => 'return Album.removeDescription(this);')); ?>
                    </div>
                <p><?php echo $model->description; ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="gallery-photos clearfix">
        <?php
        $this->widget('MyListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_photo_author',
            'summaryText' => 'показано: {start} - {end} из {count}',
            'pager' => array(
                'class' => 'MyLinkPager',
                'header' => 'Страницы',
            ),
            'id' => 'comment_list_view',
            'template' => '<ul id="photos_list">{items}</ul>
                    <div class="pagination pagination-center clearfix">
                        {summary}
                        {pager}
                    </div>
                ',
            'viewData' => array(
                'currentPage' => $dataProvider->pagination->currentPage,
            ),
        ));
        ?>
    </div>
</div>


<?php
$remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
$remove_tmpl->registerTemplates();
$this->endWidget();
?>