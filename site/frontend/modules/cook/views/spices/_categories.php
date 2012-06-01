<?php
$categories = CookSpiceCategory::model()->findAll();
$active = (Yii::app()->controller->action->id != 'category') ? 'active' : '';
?>

<ul>

    <li class="<?=$active; ?>">
        <a href="" class="cook-cat <?=$active; ?>">
            <i class="icon-cook-cat icon-spice-0"></i>
            <span>По&nbsp;алфавиту</span>
        </a>
    </li>

    <?php
    foreach ($categories as $category) {
        $active = (Yii::app()->controller->action->id == 'category' and $_GET['id'] == $category->id) ? 'active' : '';
        $link = CHtml::normalizeUrl(array('category', 'id' => $category->id));
        echo '<li class="' . $active . '"><a href="' . $link . '" class="cook-cat ' . $active . '"><i class="icon-cook-cat icon-spice-' . $category->id . '"></i><span>' . $category->title . '</span></a></li>';
    }
    ?>

</ul>