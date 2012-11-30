<li class="masonry-news-list_item" data-block-id="<?=$data->blockId?>">
    <h3 class="masonry-news-list_title textalign-c">
        <a href="<?=$this->createUrl('/activity/friends')?>">Новые пользователи</a>
    </h3>
    <div class="textalign-c clearfix">
        <span class="date"><?=HDate::GetFormattedTime($data->last_updated)?></span>
    </div>
    <ul class="user-list">
        <?php foreach ($data->users as $u): ?>
            <li>
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $u,
                    'small' => true,
                )); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="textalign-c clearfix">
        <a href="<?=$this->createUrl('/activity/friends')?>" class="icon-friends"></a>
        <a href="<?=$this->createUrl('/activity/friends')?>">Смотреть всех</a>
    </div>
</li>