<div class="assistance-count">
    <div class="assistance_text"><?=$this->counter_title[0] ?></div>
    <div class="assistance-count_all clearfix">
        <div class="assistance-count_dash">
            <?php for ($i = 5; $i >= 3; $i--)
                $this->render('__assistance_count', array('count' => $count, 'exp' => $i)); ?>
        </div>
        <div class="assistance-count_dash">
            <?php for ($i = 2; $i >= 0; $i--)
                $this->render('__assistance_count', array('count' => $count, 'exp' => $i)); ?>
        </div>
    </div>
    <div class="assistance_text"><?=Str::GenerateNoun($this->counter_title[1], $count) ?></div>
</div>