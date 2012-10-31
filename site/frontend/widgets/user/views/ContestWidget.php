<?php if ($this->_contest_work === null): ?>
    <div class="contest-mother-i-advert">
        <a href="<?=$this->controller->createUrl('/contest/default/view', array('id' => $this->contest_id))?>" class="btn-blue btn-blue-30">Приять участие!</a>
    </div>
<?php else: ?>
    <?php
        if ($this->registerGallery)
            $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
                'selector' => '.img > a',
                'entity' => 'Contest',
                'entity_id' => $this->_contest->id,
                'entity_url' => $this->_contest->getUrl(),
                'query' => array('sort' => 'created'),
            ));
    ?>
    <div class="contest-participant">
        <h3>Участвую в фотоконкурсе</h3>
        <img src="/images/contest/widget-mother-i.jpg" alt="" calss="contest-title" />
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