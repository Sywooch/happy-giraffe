<div id="login">

    <div class="title"><i class="img"></i><span>SEO-<span>жираф</span></span></div>

    <div class="user-info clearfix">
        <div class="ava"><img src="<?=Yii::app()->user->getModel()->getAvatarUrl(72) ?>" alt=""></div>
        <div class="details">
            <a href="javascript:;" class="username"><?=Yii::app()->user->getModel()->name ?></a>

            <div class="btn-logout">
                <a href="/logout" class="btn-gray-small">Выйти</a>
            </div>
        </div>
    </div>

    <div class="user-nav">

        <div class="block-title">Куда<br>идем?</div>

        <ul>
            <?php foreach ($this->getUserModules() as $key => $module): ?>
                <li><a href="<?=$module ?>"><?=$key ?></a></li>
            <?php endforeach; ?>
        </ul>

    </div>

</div>