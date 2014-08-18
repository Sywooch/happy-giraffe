<?php
/**
 * @var CommunityContent|CookRecipe $data
 */
?>

<li class="post-list-simple_li">
    <div class="post-list-simple_top"><a href="<?=$data->author->getUrl()?>" class="a-light"><?=$data->author->getFullName()?></a>
        <?=HHtml::timeTag($data, array('class' => 'tx-date'))?>
    </div>
    <div class="post-list-simple_t"><a href="<?=$data->getUrl()?>" class="post-list-simple_t-a"><?=$data->title?></a></div>
</li>