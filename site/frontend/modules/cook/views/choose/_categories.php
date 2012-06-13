<?php
$categories = CookChooseCategory::model()->findAll();
$active = (Yii::app()->controller->action->id != 'category') ? 'active' : '';
?>
<ul>
    <li class="active">
        <a href="/cook/choose/" class="cook-cat active">
            <i class="icon-cook-cat icon-product-0"></i>
            <span>Все продукты</span>
        </a>
    </li>

    <?php
    foreach ($categories as $category) {
        $active = ($_GET['id'] == $category->slug) ? 'active' : '';
        $link = CController::createUrl('category', array('id' => $category->slug));
        echo '<li class="' . $active . '"><a href="' . $link . '" class="cook-cat ' . $active . '"><i class="icon-cook-cat icon-product-' . $category->id . '"></i><span>' . $category->title . '</span></a></li>';
    }
    ?>

</ul>