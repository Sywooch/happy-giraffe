<a href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php echo urlencode($this->options['url']); ?>&title=<?php echo urlencode($this->options['title']); ?>"
   rel="nofollow"
   title="Поделиться с друзьями в +1"
   onclick="return Social.open('gp', this.href, 'gp', 800, 350, this);"
   class="btn-icon gp"></a>
<div class="count"><?php echo Rating::model()->countByEntity($this->model, 'gp'); ?></div>