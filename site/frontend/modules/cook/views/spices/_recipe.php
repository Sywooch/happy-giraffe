<?php
/**
 * Author: alexk984
 * Date: 14.06.12
 * @var CookRecipe $recipe
 */
?><li>
    <div class="item-title"><a href=""><?=$recipe->title_ablative ?></a></div>
    <?php
    $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
        'user' => $recipe->author,
        'size' => 'small',
        'location' => false,
        'sendButton' => false
    ));
    ?>
    <div class="content">
        <img src="<?=$recipe->photo->getPreviewUrl(243, 243, false, true, AlbumPhoto::CROP_SIDE_TOP) ?>" />
        <p>
            <b>Ингредиенты для &laquo;<?=$recipe->title ?>&raquo;</b>
            2 шт. филе белой рыбы<br/>
            1 столовая ложка лимонного сока<br/>
            оливковое масло<br/>
            150 г. шампиньонов<br/>
            2 дольки чеснока<br/>
        </p>
    </div>
</li>