<ul class="userSection-iframe-stat">
    <li>
        <div class="userSection-iframe-stat_count"><?=$rating['answers_count']?></div>
        <div class="userSection-iframe-stat_desc">Ответы</div>
    </li>
    <?php if ($flowerCount > 0): ?>
        <li>
            <div class="userSection-iframe-stat_count"><?=$rating['votes_count']?></div>
            <div class="userSection-iframe-stat_desc">
                <?php for($i=0; $i < $flowerCount; $i++){?>
                    <span class="userSection-iframe-stat_thanks"></span>
                <?php } ?>
                Спасибо
            </div>
        </li>
    <?php endif; ?>
</ul>