<div id="gallery">
    <div class="header">
        <div class="clearfix">
            <div class="user">
                <div class="ava"><img src="/images/ava.png"/></div>
                <p><span>Анастасия</span><br/>Россия, Ярославль</p>
            </div>
            <div class="back-link">&larr; <a href="">В анкету</a></div>
        </div>
        <div class="title">
            <big>
                Альбом <span>&laquo;<?php echo $model->title; ?>&raquo;</span>
                <?php if($model->checkAccess === true): ?>
                    <a href="" class="edit"></a>
                <?php endif; ?>
            </big>
            <?php if ($model->description): ?>
            <div class="note">
                <?php if($model->checkAccess === true): ?>
                <div class="fast-actions">
                    <a href="" class="edit"></a>
                    <a href="" class="remove"></a>
                </div>
                <?php endif; ?>
                <p><?php echo $model->description; ?></p>
            </div>
            <?php endif; ?>
        </div>
        <?php if($model->checkAccess === true): ?>
            <div class="actions">
                <?php echo CHtml::link('<span><span>Добавить фото</span></span>', array('addPhoto', 'a' => $model->primaryKey), array('class' => 'fancy btn btn-green-medium')); ?>
                <button class="btn btn-gray-medium"><span><span>Удалить альбом</span></span></button>
            </div>
        <?php endif; ?>
    </div>
    <div class="gallery-photos clearfix">
        <ul>
            <?php foreach ($model->photos as $photo): ?>
            <li>
                <table>
                    <tr>
                        <td class="img">
                            <div>
                                <?php echo CHtml::link(CHtml::image($photo->getPreviewUrl(180, 180)), array('photo', 'id' => $photo->id)); ?>
                                <?php if($photo->checkAccess): ?>
                                    <a href="" class="remove"></a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr class="title">
                        <td align="center">
                            <div>
                                <?php echo $photo->file_name ?>
                                <?php if($photo->checkAccess): ?>
                                    <a href="" class="edit"></a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>