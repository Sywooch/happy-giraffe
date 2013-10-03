<?php
/**
 * @var $model BlogContent
 */
$ViewModelData = $model->getSettingsViewModel();
$ownArticle = $model->author_id == Yii::app()->user->id;

?><div class="like-control like-control__small-indent clearfix">
    <?php if ($ad = $model->isAd()): ?>
        <span class="ava">
            <?=CHtml::image($ad['img'], $ad['text'])?>
        </span>
    <?php else: ?>
        <?php $this->widget('Avatar', array('user' => $model->by_happy_giraffe ? User::model()->findByPk(1) : $model->author)) ?>
    <?php endif; ?>
</div>
<div class="js-like-control<?php if ($ownArticle) echo ' like-control__self' ?>" data-bind="visible: ! removed()">
    <div class="like-control like-control__pinned clearfix">

        <?php $this->widget('application.modules.blog.widgets.LikeWidget', array('model' => $model)); ?>

        <!-- ko stopBinding: true -->
        <?php $this->widget('application.modules.blog.widgets.RepostWidget', array('model' => $model, 'right' => true)); ?>
        <!-- /ko -->

        <!-- ko stopBinding: true -->
        <?php $this->widget('FavouriteWidget', array('model' => $model, 'right' => true)); ?>
        <!-- /ko -->

    </div>
    <?php if ($contestWork !== null): ?>
        <?php $this->renderPartial('application.modules.blog.views.default._meter', compact('contestWork')); ?>
    <?php endif; ?>
    <?php if (!Yii::app()->user->isGuest && ($model->canEdit() || $model->canRemove()) && !$isRepost): ?>
        <div class="article-settings">
            <div class="article-settings_i">
                <a href="javascript:;" class="article-settings_a article-settings_a__settings powertip" data-bind='css: {active: displayOptions}, click: show' title="Настройки"></a>
            </div>
            <div class="article-settings_hold" data-bind="slideVisible: displayOptions()">
                <?php if ($model->author_id == Yii::app()->user->id && $model->getIsFromBlog()):?>
                    <div class="article-settings_i">
                        <a href="" class="article-settings_a article-settings_a__pin powertip" data-bind="click: attach, css: {active: attached}" title="Прикрепить"></a>
                    </div>
                <?php endif ?>
                <div class="article-settings_i">
                    <a href="<?= $this->createUrl('/blog/default/form', array('id' => $model->id, 'club_id' => $model->getIsFromBlog() ? '' : $model->rubric->community_id)) ?>"
                       class="article-settings_a article-settings_a__edit powertip fancy-top" title="Редактировать"></a>
                </div>
                <?php if ($model->author_id == Yii::app()->user->id && $model->getIsFromBlog()):?>
                <div class="article-settings_i">
                    <a href="javascript:;" class="ico-users powertip" data-bind="css: {active: displayPrivacy, 'ico-users__friend': privacy() == 1, 'ico-users__all': privacy() == 0}, click: showPrivacy" title="Приватность"></a>
                    <div class="article-settings_drop" data-bind="toggleVisible: displayPrivacy()">
                        <div class="article-settings_drop-i">
                            <a href="" class="article-settings_drop-a" data-bind="click: function(data, event) { setPrivacy(0, data, event)}">
                                <span class="ico-users ico-users__all"></span>
                                Показывать всем
                            </a>
                        </div>
                        <div class="article-settings_drop-i">
                            <a href="" class="article-settings_drop-a" data-bind="click: function(data, event) { setPrivacy(1, data, event)}">
                                <span class="ico-users ico-users__friend"></span>
                                Только друзьям
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <div class="article-settings_i">
                    <a class="article-settings_a article-settings_a__delete powertip" data-bind="click: remove" title="Удалить"></a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                var viewModel = new BlogRecordSettings(<?=CJSON::encode($ViewModelData)?>);
                ko.applyBindings(viewModel, document.getElementById('blog_settings_<?=$model->id ?>'));
            });
        </script>
    <?php endif ?>
</div>