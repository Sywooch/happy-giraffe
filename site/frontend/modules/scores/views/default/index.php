<?php
/**
 * @var $list ScoreInput[]
 * @var $score UserScores
 */

?>
<div class="content-cols clearfix">
    <div class="col-1">
        <?php $this->widget('UserAvatarWidget', array('user' => Yii::app()->user->getModel(), 'size' => 'big')); ?>

        <div class="menu-list menu-list__blue">
            <a href="javascript:;" class="menu-list_i menu-list_i__career active" onclick="ScorePage.selectTab(this, <?=ScoreInput::SELECT_ALL ?>)">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx">Все баллы </span>
            </a>
            <a href="javascript:;" class="menu-list_i menu-list_i__activity" onclick="ScorePage.selectTab(this, <?=ScoreInput::SELECT_ACTIVITY ?>)">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx">Активность</span>
            </a>
            <a href="javascript:;" class="menu-list_i menu-list_i__progress" onclick="ScorePage.selectTab(this, <?=ScoreInput::SELECT_ACHIEVEMENTS ?>)">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx">Достижения</span>
            </a>
            <a href="javascript:;" class="menu-list_i menu-list_i__booty" onclick="ScorePage.selectTab(this, <?=ScoreInput::SELECT_AWARDS ?>)">
                <span class="menu-list_ico"></span>
                <span class="menu-list_tx">Трофеи</span>
            </a>
        </div>

    </div>

    <div class="col-23-middle clearfix">
        <div class="heading-title">
            Мои успехи - <?=$score->scores . ' ' . Str::GenerateNoun(array('балл', 'балла', 'баллов'), $score->scores) ?>
        </div>
        <div class="clearfix">

            <div id="score-list">
                <?php $this->renderPartial('list',compact('list', 'score')); ?>
            </div>

            <?php if (count($list) >= 20):?>
                <div class="margin-t60">
                    <div id="infscr-loading"><img alt="Loading..." src="/images/ico/ajax-loader.gif">

                        <div>Загрузка</div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<?php if (count($list) >= 20):?>
    <script type="text/javascript">
        $(function () {
            $('.layout-container').scroll(function () {
                if (($('#score-list').height() - 500) < $(this).scrollTop())
                    ScorePage.loadMore();
            });
        });
    </script>
<?php endif ?>