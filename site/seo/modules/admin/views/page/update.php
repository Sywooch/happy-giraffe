<h1>Update Page <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

<div>
    <p><b>Анкор лист:</b></p>
    <ul>
        <?php foreach ($model->keywordGroup->keywords as $keyword): ?>
        <li data-id="<?=$keyword->id ?>"><?=$keyword->name ?>
            <a href="javascript:;" onclick="Pages.remove(this)">del</a></li>
        <?php endforeach; ?>
    </ul>
</div>

<div>
    <p><b>Добавить ключевые слова:</b></p>
    <ul>
        <textarea name="keywords" id="keywords" cols="30" rows="15"></textarea>
        <a href="javascript:;" onclick="Pages.addKeywords()">add</a>
    </ul>
</div>
<script type="text/javascript">
    var Pages = {
        addKeywords:function () {
            $.post('/admin/page/addKeywords/', {keywords:$('#keywords').val(), id:<?=$model->id?>},
                    function (response) {
                        if (response.status) {
                            location.reload();
                        }
                    }, 'json');
        },
        remove:function (el) {
            $.post('/admin/page/removeKeyword/', {keyword_id:$(el).parent().data('id'), id:<?=$model->id?>},
                    function (response) {
                        location.reload();
                    }, 'json');
        }
    }
</script>