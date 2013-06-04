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
            <?php if (Yii::app()->user->id == $this->_contest_work->user_id): ?>
                <div class="actions">
                    <?=CHtml::link('', array('/albums/updatePhoto', 'id' => $this->_contest_work->getPhoto()->id), array('class' => 'edit fancy tooltip', 'title' => 'Редактировать'))?>
                </div>
            <?php endif; ?>
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

<style type="text/css">
    .contest-participant .img .actions {
        background: #fff;
        background: rgba(255, 255, 255, 0.8);
        width: 100%;
        padding: 3px 0;
        position: absolute;
        left: 0;
        top: 0;
        text-align: right;
        display: none;
    }
    .contest-participant .img:hover .actions {
        display: block;
    }
    .contest-participant .img .actions .edit {
        display: inline-block;
        width: 14px;
        height: 18px;
        background: url(/images/common.png) no-repeat -341px -136px !important;
        margin: 0 auto;
        position: relative;
        text-decoration: none;
        font-weight: normal;
        z-index: 3;
        vertical-align: middle;
        margin-left: 10px;
        top: -2px;
        margin-right: 5px;
    }
</style>