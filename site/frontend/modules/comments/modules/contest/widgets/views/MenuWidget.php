<li class="header-menu_li">
    <a href="<?=Yii::app()->createUrl('/comments/contest/default/index', array('contestId' => $this->contest->id))?>" class="header-menu_a">
        <span class="header-menu_ico header-menu_ico__contest"></span>
        <span class="header-menu_tx">Конкурс</span>
        <?php if ($this->participant !== null && $this->participant->score > 0): ?>
            <span class="header-menu_count blue"><?=$this->participant->score?></span>
        <?php endif; ?>
    </a>
</li>