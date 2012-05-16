<div class="box activity-top-5">

    <div class="title"><img src="/images/title_top5.png" /><span>5</span> самых-самых</div>

    <div class="tabs">

        <div class="nav">
            <ul>
                <li class="active"><a href="javascript:void(0);" onclick="setTab(this, 1);">Авторы</a></li>
                <li><a href="javascript:void(0);" onclick="setTab(this, 2);">Комментаторы</a></li>
            </ul>
        </div>

        <div class="tabs-container">

            <div class="tab-box tab-box-1" style="display:block;">

                <ul>
                    <?php foreach ($topAuthors as $i => $u): ?>
                        <li class="clearfix">
                            <span class="place place-<?=$i+1?>"><?=$i+1?></span>
                            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $u, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
                            <span class="value"><?=$u->authorsRate?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

            </div>

            <div class="tab-box tab-box-2">

                <ul>
                    <?php foreach ($topCommentators as $i => $u): ?>
                    <li class="clearfix">
                        <span class="place place-<?=$i+1?>"><?=$i+1?></span>
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $u, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
                        <span class="value"><?=$u->commentatorsRate?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>

            </div>

        </div>

    </div>

</div>
