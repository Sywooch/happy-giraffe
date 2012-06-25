<?php
/**
 * @var Page $page
 */

echo $page->getArticleTitle().'<br>';
echo $page->getArticleLink().'<br>';
$goodPhrases = $page->goodPhrases();

foreach($goodPhrases as $phrase){
    echo CHtml::link($phrase->keyword->name, '#', array('onclick'=>'SeoModule.getPhraseData(this, '.$phrase->id.')')).'<br>';
}
?>
<div id="result" style="height:50px;">

</div>