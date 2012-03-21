<div class="inner contest" id="contest">
    <div class="content-title">Правила конкурса</div>
    <div class="contest-rules">

        <h4>1. Сроки проведения конкурса “Веселая семейка”</h4>

        <p>1.1 Фотоконкурс “Веселая семейка” проводится с 21.03.2012 по 20.04.2012 г. на сайте <?php echo CHtml::link('http://www.happy-giraffe.ru', array('/')); ?>.</p>

        <h4>2. Условия участия</h4>

        <p>2.1 Для участия в фотоконкурсе необходимо заполнить свой профиль и написать необходимую информацию о членах своей семьи</p>

        <p>2.2 От одного пользователя принимается одно фото.</p>

        <p>2.3 Фото должно быть хорошего качества и соответствовать теме фотоконкурса.</p>

        <br>
        <?php if($this->contest->isStatement): ?>
            <center><?php echo CHtml::link('<span><span>Участвовать</span></span>', array('/contest/statement', 'id' => $this->contest->primaryKey), array('class' => 'btn btn-green-arrow-big')) ?></center>
        <?php endif; ?>

    </div>

</div>