<?php
/**
 * @var $model BlogContent
 */
$ViewModelData = $model->getSettingsViewModel();

?><div class="like-control like-control__small-indent clearfix">
    <?php $this->widget('Avatar', array('user' => $model->author)) ?>
</div>
<div class="js-like-control" data-bind="visible: ! removed()">
    <div class="like-control like-control__pinned clearfix">
        <a href="javascript:;" class="like-control_ico like-control_ico__like powertip<?php if (!Yii::app()->user->isGuest && Yii::app()->user->getModel()->isLiked($model)) echo ' active' ?>" onclick="HgLike(this, 'BlogContent',<?=$model->id ?>);" title="Нравиться"><?=PostRating::likesCount($model) ?></a>
        <a href="javascript:;" class="like-control_ico like-control_ico__repost powertip<?php if (!Yii::app()->user->isGuest && Yii::app()->user->getModel()->isReposted($model)) echo ' active' ?>" title="Репост"><?=$model->sourceCount ?></a>
        <!-- ko stopBinding: true -->
        <?php $this->widget('FavouriteWidget', array('model' => $model, 'right' => true)); ?>
        <!-- /ko -->
    </div>
    <?php if ($model->author_id == Yii::app()->user->id):?>
        <div class="article-settings">
            <div class="article-settings_i">
                <a href="javascript:;" class="article-settings_a article-settings_a__settings powertip" data-bind='css: {active: displayOptions}, click: show' title="Настройки"></a>
            </div>
            <div class="article-settings_hold" data-bind="slideVisible: displayOptions()">
                <div class="article-settings_i">
                    <a href="" class="article-settings_a article-settings_a__pin powertip" data-bind="click: attach, css: {active: attached}" title="Прикрепить сверху"></a>
                </div>
                <div class="article-settings_i">
                    <a href="<?=$this->createUrl('form', array('id' => $model->id))?>" data-theme="transparent" class="article-settings_a article-settings_a__edit powertip fancy" title="Редактировать"></a>
                </div>
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