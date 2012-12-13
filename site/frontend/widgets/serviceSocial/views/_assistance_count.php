<div class="assistance-count">
    <div class="assistance_text"><?=$this->counter_title[0] ?></div>
    <div class="assistance-count_all clearfix">
        <?php for ($i = 8; $i >= 0; $i--)
            $this->render('__assistance_count', array('count' => $count, 'exp' => $i)); ?>
    </div>
    <div class="assistance_text"><?=HDate::GenerateNoun($this->counter_title[1], $count) ?></div>
</div>