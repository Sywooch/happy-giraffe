<li>
    <div class="img">
        <a href="">
            <?=CHtml::image($data->getPreviewUrl(210, null, Image::WIDTH))?>
            <span class="btn">Посмотреть</span>
        </a>
        <div class="actions">
            <a href="#photoPick.v2" class="edit fancy tooltip" title="Редактировать"></a>
            <a href="" class="remove tooltip" title="Удалить"></a>
        </div>
    </div>
    <?php if ($data->title): ?>
        <div class="item-title"><?=$data->title?></div>
    <?php endif; ?>
</li>