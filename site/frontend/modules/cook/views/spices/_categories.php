<?php
$categories = CookSpicesCategories::model()->findAll();
$active = (Yii::app()->controller->action->id != 'category') ? 'active' : '';
?>

<ul>

    <li class="<?=$active; ?>">
        <a href="<?=$this->createUrl('/cook/spices/') ?>" class="cook-cat <?=$active; ?>">
            <i class="icon-cook-cat icon-cook-cat-0"></i>
            <span>По&nbsp;алфавиту</span>
        </a>
    </li>

    <?php
    foreach ($categories as $category) {
        $active = (Yii::app()->controller->action->id == 'category' and $_GET['id'] == $category->slug) ? 'active' : '';
        $link = CController::createUrl('category', array('id' => $category->slug));
        echo '<li class="' . $active . '"><a href="' . $link . '" class="cook-cat ' . $active . '"><i class="icon-cook-cat icon-cook-cat-' . $category->id . '"></i><span>' . $category->title . '</span></a></li>';
    }
    ?>

</ul>