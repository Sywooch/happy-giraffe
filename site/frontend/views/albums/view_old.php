<div class="main">
    <div class="main-in">
        <div id="gallery" class="nopadding">
            <div class="header">
                <div class="all-link">
                    <?php echo CHtml::link('Все альбомы ('.count($model->author->albums).')', array('/albums/user', 'id' => $model->author_id)) . '<br/>'; ?>
                </div>
                <div class="title">
                    <big>
                        Альбом <span>&laquo;<?php echo CHtml::encode($model->title); ?>&raquo;</span>
                    </big>
                    <?php if ($model->description): ?>
                    <div class="note">
                        <p><?php echo CHtml::encode($model->description); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="gallery-photos clearfix">
                <?php
                $this->widget('MyListView', array(
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_photo',
                    'summaryText' => 'показано: {start} - {end} из {count}',
                    'pager' => array(
                        'class' => 'AlbumLinkPager',
                    ),
                    'id' => 'comment_list_view',
                    'template' => '<ul id="photos_list">{items}</ul>
                            <div class="pagination pagination-center clearfix">
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
    </div>
</div>

<div class="side-left gallery-sidebar">
    <div class="default-v-nav">
        <div class="title">Мои альбомы </div>
        <ul>
        <?php foreach($model->author->albums('albums:noSystem') as $album): ?>
            <li<?php echo $model->id == $album->id ? ' class="active"' : ''; ?>>
                <div class="in">
                    <?php echo CHtml::link(CHtml::encode($album->title), $album->url); ?>
                    <span class="count"><?php echo count($album->photos); ?></span>
                    <span class="tale"><img src="/images/default_v_nav_active.png"></span>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>