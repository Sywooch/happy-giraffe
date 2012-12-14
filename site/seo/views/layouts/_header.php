<?php if (!Yii::app()->user->checkAccess('commentator-manager')):?>
    <div class="title">
        <div class="user-info clearfix">
            <div class="ava small"><img src="<?=Yii::app()->user->getModel()->getAva() ?>" alt=""></div>
            <div class="details">
                <a href="javascript:;" class="username" onclick="$('.user-info .nav').toggle();"><?=Yii::app()->user->getModel()->name ?><i class="arr"></i></a>
            </div>
            <div class="nav" style="display: none;">
                <?php //if (count($this->getUserModules()) > 1):?>
                    <div class="clearfix">
                        <div class="block-title">Куда<br>идем?</div>
                        <ul>
                            <?php foreach ($this->getUserModules() as $key => $module): ?>
                            <li><a href="<?=$module ?>"><?=$key ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php //endif ?>

                <div class="btn-logout"><a href="/logout/" class="logout"><i class="icon"></i>Выход</a></div>
            </div>
        </div>

        <?php if ($this->icon == 1):?>
            <i class="img"></i>
            <span>SEO-<span>жираф</span></span> &nbsp; <?= $this->pageTitle ?>
        <?php else: ?>
            <i class="statistic-img"></i>
            <?= $this->pageTitle ?>
        <?php endif ?>
    </div>
<?php endif ?>

<?php if (!empty($this->fast_nav)): ?>
<?php foreach ($this->fast_nav as $nav): ?>
    <div class="fast-nav">
        <?php $this->widget('zii.widgets.CMenu', array(
        'items' => $nav
    ));?>
    </div>
<?php endforeach; ?>
<br clear="all"><br>
<?php endif ?>