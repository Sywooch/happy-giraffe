<?php
    foreach ($records as $record)
    {
        echo $record->name; ?> <a href="">Редактировать</a><a href="?r=questionnaire/default/delete&questionnaire_id=<?php echo $record->id; ?>">Удалить</a><br/> <?php
    }
?>
<br/>
<a href="http://www.virtual-giraffe.ru/?r=questionnaire/default/add">Добавить</a>
