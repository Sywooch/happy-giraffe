<div class="assistance-count">
    <div class="assistance_text"><?=$this->counter_title[0] ?></div>
    <div class="assistance-count_all clearfix">
        <span class="assistance-count_item"><?=floor($count / 10000000) % 10 ?></span>
        <span class="assistance-count_item"><?=floor($count / 1000000) % 10 ?></span>
        <span class="assistance-count_item"><?=floor($count / 100000) % 10 ?></span>
        <span class="assistance-count_item"><?=floor($count / 10000) % 10 ?></span>
        <span class="assistance-count_item active"><?=floor($count / 1000) % 10 ?></span>
        <span class="assistance-count_item active"><?=floor($count / 100) % 10 ?></span>
        <span class="assistance-count_item active"><?=floor($count / 10) % 10 ?></span>
        <span class="assistance-count_item active"><?=$count % 10 ?></span>
    </div>
    <div class="assistance_text"><?=HDate::GenerateNoun($this->counter_title[1], $count) ?></div>
</div>