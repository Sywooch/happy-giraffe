<div class="entry hrecipe clearfix">

    <?=CHtml::link($data->title, $data->url, array('class' => 'entry-title'))?>

    <div class="entry-header clearfix">

        <?php
            $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $data->author,
                'friendButton' => true,
                'location' => false,
                'hideLinks'=>true
            ));
        ?>

        <div class="meta">
            <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created)?></div>
            <div class="seen">Просмотров:&nbsp;<span><?=PageView::model()->viewsByPath($data->url)?></span></div><br>
            <?=HHtml::link('Комментариев: '. $data->commentsCount,$data->getUrl(true), array(), true ) ?>
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

            <p><?=Str::truncate(strip_tags($data->text), 255)?> <?=HHtml::link('Весь рецепт<i class="icon"></i>', $data->url, array('class' => 'read-more'), true)?></p>

        </div>

    </div>

</div>