<li class="masonry-news-list_item" data-block-id="<?=$data->blockId?>">
    <h3 class="masonry-news-list_title textalign-c">
        <?php if (Yii::app()->user->isGuest):?>
            <a href="#login" class="fancy" data-theme="white-square">Новые пользователи</a>
        <?php else: ?>
            <a href="<?=$this->createUrl('/friends/find')?>">Новые пользователи</a>
        <?php endif ?>
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
    <?php if (!Yii::app()->user->isGuest):?>
        <div class="textalign-c clearfix">
            <a href="<?=$this->createUrl('/friends/find')?>" class="icon-friends"></a>
            <a href="<?=$this->createUrl('/friends/find')?>">Смотреть всех</a>
        </div>
    <?php endif ?>
</li>