<?php if ($this->_contest_work === null): ?>
    <div class="contest-advert contest-advert-<?=$this->_contest->id?>">
        <a href="<?=$this->controller->createUrl('/contest/default/view', array('id' => $this->contest_id))?>" class="contest-advert-btn">Принять участие!</a>
    </div>
<?php else: ?>
    <?php
        if ($this->registerGallery)
            $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
                'selector' => '.contest-participant:data(contestId=' . $this->_contest->id . ') .img > a',
                'entity' => 'Contest',
                'entity_id' => $this->_contest->id,
                'entity_url' => $this->_contest->getUrl(),
                'query' => array('sort' => 'created'),
            ));
    ?>
    <div class="contest-participant" data-contest-id="<?=$this->_contest->id?>">
        <img src="/images/contest/widget-<?=$this->_contest->id?>.jpg" alt="<?=$this->_contest->title?>" calss="contest-title">
        <div class="img">
            <a href="javascript:void(0)" data-id="<?=$this->
                _contest_work->
                photoAttach->
                photo
                ->id?>">
                <?=CHtml::image($this->_contest_work->photoAttach->photo->getPreviewUrl(210, null, Image::WIDTH))?>
                <span class="btn">Посмотреть</span>
            </a>
            <div class="item-title"><?=$this->_contest_work->title?></div>
        </div>
        <div class="clearfix">
            <div class="position">
                <strong><?=$this->_contest_work->position?></strong> место
            </div>
            <div class="ball">
                <div class="ball-count"><?=$this->_contest_work->rate?></div>
                <div class="ball-text"><?=HDate::GenerateNoun(array('балл', 'балла', 'баллов'), $this->_contest_work->rate)?></div>
            </div>
        </div>
    </div>
<?php endif; ?>