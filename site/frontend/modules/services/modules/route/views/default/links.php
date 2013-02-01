<?php
/* @var $this DefaultController */

$routes = Route::model()->findAll();
?>

<?php foreach ($routes as $route): ?>
    <h2><?=$route->cityFrom->name . ' ' . $route->cityTo->name ?></h2>
    <div>
        <ul>
            <?php foreach ($route->outLinks as $link): ?>
                <li><?=$link->routeTo->wordstat ?>: <?=$link->keyword ?> <?=RouteKeyword::model()->find('text="'.$link->keyword.'"')->wordstat ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endforeach; ?>