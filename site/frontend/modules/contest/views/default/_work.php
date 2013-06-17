<li>
    <div class="contest-ball clearfix">
        <div class="user-info clearfix">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->author,
                'size' => 'small',
                'small' => true,
            )); ?>
            <div class="details">
                <?=HHtml::link(CHtml::encode($data->author->fullName), $data->author->url, array('class'=>'username'), true)?>
            </div>
            <?php if ($this->action->id != 'results'): ?>
                <div class="ball">
                    <div class="ball-count"><?=$data->rate?></div>
                    <div class="ball-text"><?=HDate::GenerateNoun(array('балл', 'балла', 'баллов'), $data->rate)?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="img">
        <a href="javascript:void(0)" data-id="<?=$data->photoAttach->photo->id?>">
            <?=CHtml::image($data->photoAttach->photo->getPreviewUrl(210, null, Image::WIDTH))?>
            <span class="btn">Посмотреть</span>
        </a>
    </div>
    <div class="item-title"><?=$data->title?></div>
</li>