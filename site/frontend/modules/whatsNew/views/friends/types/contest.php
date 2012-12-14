<?php
    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.masonry-news-list_item:data(id=' . $data->blockId . ') .img > a',
        'entity' => 'Contest',
        'entity_id' => $data->work->contest->id,
        'entity_url' => $data->work->contest->url,
        'query' => array('sort' => 'created'),
    ));
?>

<div class="contest-participant">
    <img class="title-img" alt="<?=$data->work->contest->title?>" src="/images/broadcast/title-contest-<?=$data->work->contest->id?>.jpg">
    <div class="img">
        <a href="javascript:void(0)" data-id="<?=$data->work->photoAttach->photo->id?>">
            <?=CHtml::image($data->work->photoAttach->photo->getPreviewUrl(210, null, Image::WIDTH))?>
            <span class="btn">Посмотреть</span>
        </a>
        <div class="item-title"><?=$data->work->title?></div>
    </div>
    <div class="clearfix">
        <div class="position">
            <strong><?=$data->work->position?></strong> место
        </div>
        <div class="ball">
            <div class="ball-count"><?=$data->work->rate?></div>
            <div class="ball-text"><?=HDate::GenerateNoun(array('балл', 'балла', 'баллов'), $data->work->rate)?></div>
        </div>
    </div>
</div>
<div class="comments-all">
    <a href="" class="textdec-onhover">Поддержите друга!</a>
</div>