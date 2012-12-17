<li>
    <?php if ($partner->name): ?>
    <span><?=$data->relationshipStatusString?></span>
    <?php else: ?>
    <?php if ($partner->photo !== null): ?>
        <div class="img"><?=CHtml::image($data->photo->photo->getPreviewUrl(66, 66), $baby->name)?></div>
        <?php endif; ?>
    <span class="yellow"><?=$partnerTitleNew?></span> <br>
    <span><?=$partner->name?></span>
    <?php endif; ?>
</li>