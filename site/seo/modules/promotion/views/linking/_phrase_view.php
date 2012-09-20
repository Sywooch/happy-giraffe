<?php
/**
 * @var $pages Page[]
 * @var $keywords Keyword[]
 * @var $phrase PagesSearchPhrase
 */
?>
<?php $this->renderPartial('__steps',compact('phrase', 'pages', 'keywords')); ?>

<div class="btn">

    <a href="javascript:;" class="btn-green" onclick="SeoLinking.AddLink();">Поставить ссылку</a>

</div>