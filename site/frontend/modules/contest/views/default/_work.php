<li>
    <div class="contest-ball clearfix">
        <div class="user-info clearfix">
            <?php $this->widget('Avatar', array('user' => $data->author, 'size' => Avatar::SIZE_MICRO)); ?>
            <div class="details">
                <?=HHtml::link(CHtml::encode($data->author->fullName), $data->author->url, array('class'=>'username'), true)?>
            </div>
            <?php if ($this->action->id != 'results'): ?>
                <div class="ball">
                    <div class="ball-count"><?=$data->rate?></div>
                    <div class="ball-text"><?=Str::GenerateNoun(array('балл', 'балла', 'баллов'), $data->rate)?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="img">
        <a href="javascript:void(0)" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($data->photoAttach->photo->id)?>)">
            <?=CHtml::image($data->photoAttach->photo->getPreviewUrl(210, null, Image::WIDTH))?>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="item-title"><?=$data->title?></div>
</li>