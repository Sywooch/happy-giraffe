<div class="interesting">
    <div class="block-title">Вам может быть интересно</div>
    <ul>
        <?php foreach ($link_pages as $link_page): ?>
            <li><?=CHtml::link($link_page->keyword->name, $link_page->pageTo->url); ?></li>
        <?php endforeach; ?>
    </ul>
</div>