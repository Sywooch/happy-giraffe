<?php
/* @var $this Controller
 * @var $data CookRecipe
 */
?><div class="entry recipe-article clearfix">

    <h1 class="fn"><a href="<?=$data->url ?>"><?=$data->title ?></a></h1>

    <div class="entry-header clearfix">

        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $data->author,'size'=>'small', 'time'=>$data->created, 'location'=>false, 'sendButton'=>false, 'online_status'=>false)); ?>

        <div class="meta meta-small">
            <div class="views"><span class="icon"></span> <span><?=PageView::model()->viewsByPath(str_replace('http://www.happy-giraffe.ru', '', $data->url), true)?></span></div>
            <div class="comments">
                <?=HHtml::link('', $data->getUrl(true), array('class'=>'icon'), true) ?>
                <?=HHtml::link($data->commentsCount, $data->getUrl(true), array(), true) ?>
            </div>
        </div>

    </div>

    <div class="entry-content">

        <?php $this->renderPartial('__cook_book', array('data' => $data)); ?>

        <div class="recipe-photo">
            <div class="big">
                <?php if ($data->mainPhoto) echo HHtml::image($data->mainPhoto->getPreviewUrl(460, null, Image::WIDTH), $data->mainPhoto->title, array('class' => 'photo'), true)?>
            </div>
        </div>

        <div style="clear:left;"></div>

        <?php if ($data->cuisine || $data->preparation_duration || $data->cooking_duration || $data->servings): ?>
        <div class="recipe-description clearfix">
            <div class="recipe-description-holder">
            <?php if ($data->cuisine): ?>
                <span class="country"><?php if (!empty($data->cuisine->country_id)):?><span class="flag-big flag-big-<?=$data->cuisine->country->iso_code ?>"></span><?php endif ?><?=$data->cuisine->title?></span>
            <?php endif; ?>
            <?php if ($data->preparation_duration): ?>
            <div class="recipe-description-item">
                <div class="icon-time-1 tooltip" title="Время подготовки"></div>
                <?=$data->preparation_duration_h?> : <?=$data->preparation_duration_m?>
            </div>
            <?php endif; ?>
            <?php if ($data->cooking_duration): ?>
            <div class="recipe-description-item" title="Время приготовления">
                <div class="icon-time-2 tooltip"></div>
                <?=$data->cooking_duration_h?> : <?=$data->cooking_duration_m?>
            </div>
            <?php endif; ?>
            <?php if ($data->servings): ?>
            <div class="recipe-description-item" title="Количество порций">
                <div class="icon-yield tooltip"></div>
                на <?=$data->servings?> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $data->servings)?>
            </div>
            <?php endif; ?>
        </div>
        </div>
        <?php endif; ?>

        <h2>Приготовление</h2>

        <div class="instructions wysiwyg-content">

            <p><?=Str::truncate(strip_tags($data->text), 400)?> <?=HHtml::link('Весь рецепт<i class="icon"></i>', $data->url, array('class' => 'read-more'), true)?></p>
        </div>

    </div>

</div>