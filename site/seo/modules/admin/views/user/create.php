<h1>Create User</h1>
<?php if (!empty($password)) echo 'Password: '.$password ?><br>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>