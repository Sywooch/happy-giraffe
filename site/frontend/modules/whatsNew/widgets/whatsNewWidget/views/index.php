<?php
if (Yii::app()->user->isGuest)
    Yii::app()->clientScript->registerScript('whatsNew_guest','WhatsNew.guest = true;', CClientScript::POS_HEAD);

$this->controller->beginWidget('SeoContentWidget');
?>
<div id="broadcast" class="broadcast-all">
    <div class="broadcast-widget">
        <div class="broadcast-title-box clearfix">
            <?php if (!Yii::app()->user->isGuest):?>
                <ul class="broadcast-widget-menu">
                    <li<?php if ($this->type == EventManager::WHATS_NEW_ALL) echo ' class="is-active"' ?>>
                        <a onclick="WhatsNew.ajax(<?=EventManager::WHATS_NEW_ALL ?>, this)" href="javascript:;"><span class="icon-boradcast-small" ></span> <span class="text">В прямом эфире</span></a>
                    </li>
                    <li<?php if ($this->type == EventManager::WHATS_NEW_CLUBS) echo ' class="is-active"' ?>>
                        <a onclick="WhatsNew.ajax(<?=EventManager::WHATS_NEW_CLUBS ?>, this)" href="javascript:;"><span class="text">В клубах</span></a>
                    </li>
                    <li<?php if ($this->type == EventManager::WHATS_NEW_BLOGS) echo ' class="is-active"' ?>>
                        <a onclick="WhatsNew.ajax(<?=EventManager::WHATS_NEW_BLOGS ?>, this)" href="javascript:;"><span class="text">В блогах</span></a>
                    </li>
                    <li<?php if ($this->type == EventManager::WHATS_NEW_FRIENDS) echo ' class="is-active"' ?>>
                        <a onclick="WhatsNew.ajax(<?=EventManager::WHATS_NEW_FRIENDS ?>, this)" href="javascript:;"><span class="icon-friends" ></span><span class="text">У друзей</span></a>
                    </li>
                </ul>
            <?php endif ?>
            <h3><i class="icon-boradcast"></i> Что нового</h3>
        </div>
        <div id="masonry-news-list-jcarousel" class="masonry-news-list jcarousel-holder clearfix jcarousel">

            <a class="prev jcarousel-control" href="#">предыдущая</a>
            <a class="next jcarousel-control" href="#">следующая</a>
            <div class="jcarousel">
                <ul id="masonry-news-list-jcarousel-ul">
                    <?php foreach ($dp->data as $block)
                            echo $block->code; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $this->controller->endWidget(); ?>
