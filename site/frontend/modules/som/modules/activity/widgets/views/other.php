<?php

use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;

$model = $data->getDataObject();
?>
<?php if (is_null($model)): ?>
<article class="b-article b-article__list clearfix">
    <div class="b-article_cont clearfix">
        <div class="b-article_header clearfix">
            <div class="float-l">
            <!-- ava-->
            <a href="<?= $user->profileUrl ?>" class="ava ava__<?= $user->gender ? '' : 'fe' ?>male ava__middle-xs ava__middle-sm-mid ">
                <span class="ico-status ico-status__online"></span>
                <img alt="" src="<?= $user->avatarUrl ?>" class="ava_img">
            </a>
            <a href="<?= $user->profileUrl ?>" class="b-article_author"><?= $user->fullName ?></a>
            <?= HHtml::timeTag($data, array('class' => 'tx-date'), null); ?>
            <?php if ($user->specInfo !== null): ?>
                <div class="b-article_authorpos"><?=$user->specInfo['title']?></div>
            <?php endif; ?>
            </div>
        </div>
        <?php

        $view = 'site.frontend.modules.som.modules.activity.widgets.views.' . ActivityWidget::$types[$data->typeId][1];

        $this->renderPartial($view, [
            'data'      => $data,
            'user'      => $user,
            'widget'    => $widget
        ]);

        ?>
    </div>
</article>
<?php endif;?>
