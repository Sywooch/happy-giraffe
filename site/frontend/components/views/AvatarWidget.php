<div class="ava<?php if ($user->gender !== null) echo ($user->gender) ? ' male' : ' female'; ?>">
    <a href="<?php echo $this->createUrl('user/profile', array('user_id'=>$user->id)) ?>">
	<?php if ($ava = $user->pic_small->getUrl('ava')) echo CHtml::image($ava); ?>
    </a>
</div>
<?php if($this->withMail) echo $user->getDialogLink(); ?>