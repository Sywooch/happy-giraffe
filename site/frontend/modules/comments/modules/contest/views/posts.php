<?php
$this->pageTitle = 'Лучший комментатор - Что комментировать?';
?>
<div class="contest-commentator-blog_top">
    <h4 class="contest-commentator-blog_top__bold">Мы вам поможем и предложим прокомментировать интересные записи!</h4>
    <p>Для того, чтобы вам было проще, мы предлагаем ТОП-20 актуальнейших статей, которые будут постоянно обновляться! Комментируйте их, отвечайте на комментарии других пользователей, создавайте свои семыи и главный приз в 1000 рублей станет вашим!</p>
</div>
<div class="contest-commentator-blog_hold">
    <?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\PostsWidget'); ?>
</div>