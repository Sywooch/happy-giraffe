<a onclick="return Social.open('vk', this.href, 'vkontakte', 800, 300, this);"
   rel="nofollow"
   href="http://vk.com/share.php<?php echo $this->arrayToUrl($this->options); ?>"
   class="btn-icon vk"
   title="Опубликовать ссылку во ВКонтакте"></a>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'vk'); ?></div>