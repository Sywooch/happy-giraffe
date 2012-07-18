<?php
/**
 * @var CommunityContent[] $articles
 */
?>
<ul>
    <li><a href="<?= Yii::app()->createUrl('/community/list', array('community_id' => $community_id))?>"><img src="/images/<?=$image ?>"></a></li>
    <?php foreach ($articles as $article): ?>
    <li><a href="<?=$article->getUrl() ?>"><?=$article->title ?></a></li>
    <?php endforeach; ?>
</ul>

<div class="all-link"><a href="<?=($community_id == 22) ? Yii::app()->createUrl('/cook') : Yii::app()->createUrl('/community/list', array('community_id' => $community_id))?>">Все <?=$title ?> (<?=$count ?>)</a></div>