<div style="width:700px;margin: 0 auto;margin-top: 80px;">
<?php
    $articles = Favourites::model()->getWeekPosts();
    $this->renderFile(Yii::getPathOfAlias('site.common.tpl.weeklyNews').'.php', array('models'=>$articles));
?>
</div>