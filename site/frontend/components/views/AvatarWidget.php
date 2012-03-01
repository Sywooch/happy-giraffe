<a class="ava<?php if ($user->gender !== null) echo ($user->gender) ? ' male' : ' female'; ?>"
   href="<?php echo Yii::app()->createUrl('user/profile', array('user_id'=>$user->id)) ?>">
        <?php echo CHtml::image($user->getAva()); ?>
</a>
<?php if($this->withMail) echo $user->getDialogLink(); ?>