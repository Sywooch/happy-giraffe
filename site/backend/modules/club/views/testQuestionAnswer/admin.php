<h1>Manage Test Question Answers</h1>

 <?php echo CHtml::link('создать', array('TestQuestionAnswer/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'test-question-answer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'test_question_id',
		//'number',
		//'points',
		'text',
		//'islast',
		/*
		'next_question_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
)); ?>
