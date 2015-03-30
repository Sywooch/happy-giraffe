<div class="b-consult-specialist">
    <div class="b-consult-specialist__img"><img src="/lite/images/services/consult/consult-man.png" alt=""></div>
    <div class="b-consult-specialist__name">Морозов Сергей Леонидович</div>
    <div class="b-consult-specialist__position">Врач педиатр</div>
    <div class="b-consult-specialist__edu">

        Кандидат медицинских наук, <br />
        научный сотрудник Научно-исследовательского <br />
        клинического института педиатрии <br />
        ГБОУ ВПО РНИМУ им. Н.И. Пирогова
    </div>
    <?php if (! $this->isConsultant()): ?>
    <a href="<?=$this->createUrl('create', array('slug' => $this->consultation->slug))?>" class="b-consult-button login-button" data-bind="follow:{}">Задать вопрос</a>
    <?php endif; ?>
</div>
