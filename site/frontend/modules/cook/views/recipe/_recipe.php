<?php
/* @var $this Controller
 * @var $data CookRecipe
 */

if (Yii::app()->user->checkAccess('recipe_tags')){
    $basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'recipe' . DIRECTORY_SEPARATOR . 'assets';
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

    $cs = Yii::app()->clientScript;
    $cs
        ->registerScriptFile($baseUrl . '/recipe_tags.js', CClientScript::POS_HEAD);

    $style = '.remove {display:inline-block;*zoom:1;*display:inline;vertical-align:middle;margin-left:5px;}
.remove .icon {display: inline-block;width: 12px;height: 14px;background: url(/images/common.png) no-repeat -314px -135px;vertical-align: middle;position: relative;top: -1px;}
.remove:hover .icon {background-position:-314px -148px;}';
    $cs->registerCss('recipe_tags_edit_css', $style);
}
?><div class="entry hrecipe clearfix">

    <?=CHtml::link($data->title, $data->url, array('class' => 'entry-title'))?>

    <div class="entry-header clearfix">

        <?php
            $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->author,
                'friendButton' => true,
                'location' => false,
            ));
        ?>

        <div class="meta">
            <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created)?></div>
            <div class="seen">Просмотров:&nbsp;<span><?=PageView::model()->viewsByPath($data->url)?></span></div><br>
            <a href="<?=$data->getUrl(true)?>">Комментариев: <?php echo $data->commentsCount; ?></a>
        </div>

    </div>

    <div class="entry-content">

        <div class="recipe-right">

            <div class="recipe-description">

                <?php if ($data->cuisine || $data->preparation_duration || $data->cooking_duration || $data->servings): ?>
                    <ul>
                        <?php if ($data->cuisine): ?>
                        <li>Кухня <span class="nationality"><!--<div class="flag flag-ua"></div> --><span class="cuisine-type"><?=$data->cuisine->title?></span></span></li>
                        <?php endif; ?>
                        <?php if ($data->preparation_duration): ?>
                        <li>Время подготовки <span class="time-1"><i class="icon"></i><span class=""><?=$data->preparation_duration_h?> : <?=$data->preparation_duration_m?></span></span></li>
                        <?php endif; ?>
                        <?php if ($data->cooking_duration): ?>
                        <li>Время приготовления <span class="time-2"><i class="icon"></i><span class=""><?=$data->cooking_duration_h?> : <?=$data->cooking_duration_m?></span></span></li>
                        <?php endif; ?>
                        <?php if ($data->servings): ?>
                        <li>Кол-во порций <span class="yield-count"><i class="icon"></i><span class="yield"><?=$data->servings?> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $data->servings)?></span></span></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>

                <div class="actions">

                    <!--<div class="action">
                        <a href="" class="print"><i class="icon"></i>Распечатать</a>
                    </div>

                    <div class="action">
                        <a href="" class="add-to-cookbook"><i class="icon"></i>Добавить в кулинарную книгу</a>
                    </div>-->

                    <div class="action share">
                        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                        Поделиться
                        <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus"></div>
                    </div>


                </div>

                <?php if (Yii::app()->user->checkAccess('recipe_tags')):?>
                    <div>
                        <p><b>Тэги</b></p>
                        <p>
                        <?php foreach ($data->tags as $tag): ?>
                            <span><?=$tag->title ?></span><a class="remove" onclick="CookRecipeTags.removeCookTag(<?=$data->id ?>, <?=$tag->id ?>, this)" href="javascript:;"><i class="icon"></i></a><br>
                        <?php endforeach; ?>
                        </p>
                        <?= CHtml::dropDownList('recipe_tag', UserAttributes::get(Yii::app()->user->id, 'last_recipe_tag_id'), CHtml::listData(CookRecipeTag::model()->findAll(), 'id', 'title'), array('style'=>'width:200px')); ?>
                        <a onclick="CookRecipeTags.setCookTag(<?=$data->id ?>, this)" href="javascript:;">добавить</a>
                    </div>
                <?php endif ?>

            </div>

        </div>

        <?php if ($data->mainPhoto !== null): ?>
            <div class="recipe-photo">

                <div class="big">
                    <?=CHtml::image($data->mainPhoto->getPreviewUrl(441, null, Image::WIDTH), $data->mainPhoto->title, array('class' => 'photo'))?>
                </div>

            </div>
        <?php endif; ?>

        <div style="clear:left;"></div>

        <h2>Приготовление</h2>

        <div class="instructions wysiwyg-content">

            <p><?=Str::truncate(strip_tags($data->text), 255)?> <?=CHtml::link('Весь рецепт<i class="icon"></i>', $data->url, array('class' => 'read-more'))?></p>

        </div>

    </div>

</div>