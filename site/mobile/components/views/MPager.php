<div class="margin-b10 textalign-c clearfix">
    <?php if ($this->currentPage > 0): ?>
        <a href="<?=$this->createPageUrl($this->currentPage - 1)?>" class="btn-lilac btn-medium float-l"><i class="ico-arrow ico-arrow__left"></i> Назад</a>
    <?php endif; ?>
    <?php if ($this->currentPage < $this->pageCount - 1): ?>
        <a href="<?=$this->createPageUrl($this->currentPage + 1)?>" class="btn-green btn-medium float-r">Вперед <i class="ico-arrow ico-arrow__right"></i></a>
    <?php endif; ?>
    <span class="page-numer"><?=$this->currentPage + 1?></span>
</div>