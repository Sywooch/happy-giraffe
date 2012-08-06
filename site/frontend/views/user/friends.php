<div class="col-1">

    <?php $this->renderPartial('_friends_sidebar'); ?>

</div>

<div class="col-23 clearfix">

    <div class="content-title-new"><?=($this->user->id == Yii::app()->user->id) ? 'Мои друзья' : 'Друзья'?></div>

    <?php
    if ($dataProvider->itemCount >= 6 && $show == 'all' || $this->user->id !== Yii::app()->user->id):?>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'id' => 'friends',
            'ajaxUpdate' => true,
            'dataProvider' => $dataProvider,
            'itemView' => '_friend',
            'itemsTagName' => 'ul',
            'template' =>
            '
                    <div class="friends clearfix">
                        {items}
                    </div>
                    <div class="pagination pagination-center clearfix">
                        {pager}
                    </div>
                ',
            'pager' => array(
                'class' => 'MyLinkPager',
                'header' => '',
            ),
        ));?>
        <?php elseif ($dataProvider->itemCount == 0):?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/wantToChat.js'); ?>
        <div class="friends clearfix">
            <ul>
                <li class="empty">
                    <div class="img"></div>
                </li>
                <li class="empty">
                    <div class="img"></div>
                </li>
                <li class="empty">
                    <div class="img"></div>
                </li>
                <li class="empty">
                    <div class="img"></div>
                </li>
                <li class="empty">
                    <div class="img"></div>
                </li>
                <li class="empty">
                    <div class="img"></div>
                </li>
            </ul>
        </div>
        <div class="friends-total empty">
            <span>У вас пока нет друзей.</span>
            <a href="<?=$this->createUrl('/activity/friends/') ?>">Найти ещё друзей</a>
            <a href="" class="wannachat" onclick="WantToChat.send(this); return false;">Хочу общаться!</a>
        </div>
        <?php else: ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/wantToChat.js'); ?>
        <div class="friends clearfix">
            <ul>
                <?php foreach ($dataProvider->data as $friend): ?>
                <?php $this->renderPartial('_friend', array('data' => $friend)); ?>
                <?php endforeach; ?>
                <?php for ($i = $dataProvider->itemCount; $i < 6; $i++) { ?>
                <li class="empty">
                    <div class="img"></div>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="friends-total">

            <span>У вас пока только <?=$dataProvider->itemCount . ' ' . HDate::GenerateNoun(array('друг', 'друга', 'друзей'), $dataProvider->itemCount) ?>.</span>

            <a href="<?=$this->createUrl('/activity/friends/') ?>">Найти ещё друзей</a>
            <a href="" class="wannachat" onclick="WantToChat.send(this); return false;">Хочу общаться!</a>

        </div>
        <?php   endif; ?>
</div>