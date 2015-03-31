<?php if (Yii::app()->user->checkAccess('answerQuestions', array('consultation' => $this->consultation))): ?>
    <a class="margin-t3 display-b" href="<?=$this->createUrl('answer', array('slug' => $this->consultation->slug, 'questionId' => $data->id))?>"><?=($data->answer === null) ? 'Ответить' : 'Редактировать ответ' ?></a>
<?php endif; ?>