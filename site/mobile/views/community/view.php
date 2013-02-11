<?php
/**
 * @var $content CommunityContent
 * @var $community MobileCommunity
 */
?>

<?=CHtml::link($mobileCommunity->title, $mobileCommunity->url)?>

<?=$this->render('_post', compact('content'))?>