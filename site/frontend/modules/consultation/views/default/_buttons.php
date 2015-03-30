<?php if (Yii::app()->user->checkAccess('answerQuestions', array('consultation' => $this->consultation))): ?>
    <a class="margin-t3 display-b" href="<?=$this->createUrl('answer', array('slug' => $this->consultation->slug, 'questionId' => $data->id))?>"><?=($data->answer === null) ? 'Ответить' : 'Редактировать ответ' ?></a>
<?php endif; ?>
<?php if (Yii::app()->user->checkAccess('removeQuestions', array('consultation' => $this->consultation))): ?>
    <a class="margin-t3 display-b" onclick="var self = this; $.post('/api/consultation/remove/', JSON.stringify({ questionId: '<?=$data->id?>' }), function() {$(self).text('Удалено')})">Удалить</a>
<?php endif; ?>