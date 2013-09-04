<div class="menu-simple menu-simple__after-article">
    <h3 class="margin-b15">Вам может быть интересно</h3>
    <ul class="menu-simple_ul">
        <?php foreach ($link_pages as $link_page): ?>
            <li class="menu-simple_li"><?=CHtml::link($link_page->keyword->name, $link_page->pageTo->url, array('class'=>'menu-simple_a')); ?></li>
        <?php endforeach; ?>
    </ul>
</div>