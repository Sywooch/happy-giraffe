<div class="menu-simple menu-simple__after-article2">
    <div class="menu-simple_t-sub">Вам может быть интересно</div>
    <ul class="menu-simple_ul">
        <?php foreach ($link_pages as $link_page): ?>
            <li class="menu-simple_li">
                <?=CHtml::link($link_page->keyword->name, $link_page->pageTo->url, array('class'=>'menu-simple_a')); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>