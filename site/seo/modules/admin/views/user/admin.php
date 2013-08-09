<h1>Manage Users</h1>

 <?php echo CHtml::link('создать', array('User/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
		    'name'=>'id',
		    'value'=>'$data->id',
            'filter'=>false
		),
		'email',
		'name',
		'owner_id',
        array(
            'name'=>'related_user_id',
            'value'=>'$data->related_user_id',
            'filter'=>false
        ),
        'role',
        'active',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
));
?>
<style type="text/css">
    input[type=text]{
        max-width: 100px !important;
    }
</style>