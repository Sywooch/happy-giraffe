<div class="cook-recipes clearfix">

    <div class="btn">
        <button onclick="CookModule.addTaskByName(this)">Отправить в задачи</button>
    </div>

    <form id="add-by-name" action="">
        <div class="input">
            <label>Введите название рецепта</label>
            <input name="name" type="text" class="item-title"/><br/>
        </div>

        <div class="input">
            <label>Ссылки на примеры</label>
            <input name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
            <input style="display: none;" name="urls[]" type="text" onkeyup="$(this).next().next().show()"/><br/>
        </div>

    </form>

</div>

<div class="cook-recipes-today">

    <div class="block-title"><span>Сегодня в задачах</span> <a href="<?=$this->createUrl('tasks') ?>">Перейти в
        раздачу</a></div>

    <ol>
        <li>Вишневый пирог</li>
        <li>Зелень по-русски</li>
        <li>Отбивная из телятины</li>
    </ol>

</div>
		