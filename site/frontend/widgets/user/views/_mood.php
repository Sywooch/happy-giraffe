<div id="userMoodTooltip">
    <span><?php echo $mood->name; ?></span>
</div>
Мое настроение <img id="userMood" src="/images/widget/mood/<?php echo $mood->id; ?>.png" /><?php if ($canUpdate): ?> <a href="" class="pseudo small">Изменить</a><?php endif; ?>