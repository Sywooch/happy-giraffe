<div class="entry hrecipe clearfix">

    <h1 class="fn"><?=$data->title?></h1>

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
            <div class="seen">Просмотров:&nbsp;<span><?=$this->getViews()?></span></div><br>
            <a href="<?=$data->getUrl(true)?>">Комментариев: <?php echo $data->commentsCount; ?></a>
        </div>

    </div>

    <div class="entry-content">

        <div class="recipe-right">

            <div class="recipe-description">

                <?php if ($recipe->cuisine || $recipe->preparation_duration || $recipe->cooking_duration || $recipe->servings): ?>
                    <ul>
                        <?php if ($recipe->cuisine): ?>
                        <li>Кухня <span class="nationality"><!--<div class="flag flag-ua"></div> --><span class="cuisine-type"><?=$recipe->cuisine->title?></span></span></li>
                        <?php endif; ?>
                        <?php if ($recipe->preparation_duration): ?>
                        <li>Время подготовки <span class="time-1"><i class="icon"></i><span class=""><?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?></span></span></li>
                        <?php endif; ?>
                        <?php if ($recipe->cooking_duration): ?>
                        <li>Время приготовления <span class="time-2"><i class="icon"></i><span class=""><?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?></span></span></li>
                        <?php endif; ?>
                        <?php if ($recipe->servings): ?>
                        <li>Кол-во порций <span class="yield-count"><i class="icon"></i><span class="yield"><?=$recipe->servings?> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?></span></span></li>
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

            <p><?=Str::truncate(strip_tags($data->text))?> <?=CHtml::link('Весь рецепт<i class="icon"></i>', $data->url, array('class' => 'read-more'))?></p>

        </div>

    </div>

</div>