<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Доступ</b>',
); ?>
<?php $form = $this->beginWidget('CActiveForm'); ?>
	<div class="profile-form-in">

		<div class="access-list">
	
			<ul>
				<li>
					<p class="line-title">Мою анкету могут смотреть:</p>
					<div class="radiogroup">
						<?php echo $form->radioButtonList($this->user, 'profile_access', $this->user->accessLabels); ?>
					</div>
				</li>
				<li>
					<p class="line-title">В мою гостевую книгу могут писать:</p>
					<div class="radiogroup">
                        <?php echo $form->radioButtonList($this->user, 'guestbook_access', $this->user->accessLabels); ?>
					</div>
				</li>
				<li>
					<p class="line-title">Диалоги со мной могут начинать:</p>
					<div class="radiogroup">
                        <?php echo $form->radioButtonList($this->user, 'im_access', $this->user->accessLabels); ?>
					</div>
				</li>
		
			</ul>
		</div>

	</div>
</div>
<div class="bottom">
	<button class="btn btn-green-medium btn-arrow-right"><span><span>Сохранить<img src="/images/arrow_r.png" /></span></span></button>
</div>
<?php $this->endWidget(); ?>