<!-- Зодиаки-->
<ul class="zodiac-list_ul">
    <?php
    foreach ($models as $i => $model)
        $this->renderPartial('_preview', compact('model'));
    ?>
</ul>