<div class="nav v-nav">
    <ul>
        <?php foreach($albums->getData() as $album): ?>
            <li<?php echo $album->id == $model->id ? ' class="active"' : ''; ?>>
                <?php echo CHtml::link(
                    $album->title,
                    array('/albums/attach', 'entity' => $this->entity, 'entity_id' => $this->entity_id, 'mode' => 'albums', 'a' => $album->id), array(
                        'onclick' => 'return Attach.changeAlbum(this);'
                    )); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div id="gallery"<?php echo !$model ? ' class="nomargin"' : '' ?>>
    <?php if($model): ?>
        <div class="gallery-photos clearfix">
        <?php
        $dataProvider = new CActiveDataProvider('AlbumPhoto', array(
            'criteria' => array(
                'condition' => 'removed = 0 and album_id = :album_id',
                'params' => array(':album_id' => $model->id)
            ),
            'pagination' => array('pageSize' => 9),
        ));
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$dataProvider,
            'itemView'=>'_photo',
            'summaryText' => 'показано: {start} - {end} из {count}',
            'pager' => array(
                'class' => 'MyLinkPager',
                'header' => 'Страницы',
            ),
            'emptyText' => 'У Вас нет фото в альбоме',
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
    <?php else: ?>
        <div class="album-empty">У Вас нет альбомов</div>
    <?php endif; ?>
</div>