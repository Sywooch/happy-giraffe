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
            <?php echo CHtml::link('Все альбомы ('.count($model->author->albums).')', array('/albums/user', 'id' => $model->author_id)) . '<br/>'; ?>
        </div>
        <div class="title">
            <big>
                Альбом <span>&laquo;<?php echo $model->title; ?>&raquo;</span>
            </big>
            <?php if ($model->description): ?>
            <div class="note">
                <p><?php echo $model->description; ?></p>
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