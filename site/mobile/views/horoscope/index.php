<ul>
    <?php foreach ($models as $model): ?>
        <li>
            <?=CHtml::image('/images/widget/horoscope/small/' . $model->zodiac . '.png')?>
        </li>
    <?php endforeach; ?>
</ul>