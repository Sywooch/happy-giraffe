<?php
/**
 * Author: alexk984
 * Date: 06.12.12
 */
$tags = CookRecipeTag::model()->alphabet()->findAll();
foreach($tags as $tag)
    echo CHtml::link($tag->title, '/cook/recipe/tag/'.$tag->id.'/').' - '.$tag->recipesCount. '<br>';