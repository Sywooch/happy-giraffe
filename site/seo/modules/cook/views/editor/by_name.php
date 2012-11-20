<div class="cook-recipes clearfix">

    <div class="btn">
        <button onclick="CookModule.addTaskByName();">Отправить в задачи</button>
    </div>

    <form id="add-by-name" action="">
        <input name="section" type="hidden" value="<?=$_GET['section'] ?>"/>

        <div class="input">
            <label>Введите название рецепта</label>
            <input name="title" type="text" class="item-title"/><br/>
        </div>

        <div class="input" id="urls">
            <label>Ссылки на примеры</label>
            <input name="urls[]" type="text"/><br/>
        </div>

    </form>

</div>

<div class="cook-recipes-today">

    <div class="block-title"><span>Сегодня в задачах</span> <a href="<?=$this->createUrl('tasks') ?>">Перейти в
        раздачу</a></div>

    <ol>
        <?php foreach ($tasks as $task): ?>
            <li><?=$task->article_title ?></li>
        <?php endforeach; ?>
    </ol>

</div>

<script type="text/javascript">
    $(function() {
        $('body').delegate('.cook-recipes div.input input:last', 'keyup', function(e){
            $(this).parent().append('<input name="urls[]" type="text"/><br/>');
        });
    });
</script>