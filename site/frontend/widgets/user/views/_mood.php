<div id="userMoodTooltip">
    <span><?php echo $mood->name; ?></span>
</div>

Мое настроение &ndash; <img id="userMood" src="/images/mood_smiles/mood_smile_<?php echo $mood->id; ?>.png" /><?php if ($canUpdate): ?> <a href="" class="pseudo small">Изменить</a><?php endif; ?>