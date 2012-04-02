<a onclick="return Social.open('tw', this.href, 'twitter', 800, 300, this);"
   rel="nofollow"
   href="http://twitter.com/intent/tweet?text=<?php echo urlencode($this->options['title'] . ' ' . $this->options['url']); ?>"
   title="Поделиться с друзьями в Twitter"
   class="btn-icon twt"></a>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'tw'); ?></div>