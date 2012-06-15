<h2>Рецепты</h2>

<?php
foreach ($recipes as $recipe) {
    ?>
<div>
    <div class="user clearfix">
        <?php
        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $recipe->author,
            'size' => 'small',
            'location' => false,
            'sendButton' => false
        ));
        ?>
    </div>
    <h3><a href="<?=$recipe->url?>"><?=$recipe->title?></a></h3>
</div>
<?php
}

?>
<h2>оформления</h2>
<?php

foreach ($decorations as $decoration) {
    ?>
<div>
    <h3><?=$decoration->title?></h3>
</div>
<?php
}

?>