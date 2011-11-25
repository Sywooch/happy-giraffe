<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Доступ</b>',
); ?>

	<div class="profile-form-in">

		<div class="access-list">
	
			<ul>
				<li>
					<p class="line-title">Мою анкету могут смотреть:</p>
					<div class="radiogroup">
						<label><input type="radio" name="radio" /> все пользователи</label><br/>
						<label><input type="radio" name="radio" /> только друзья</label><br/>
					</div>
					<label><input type="checkbox" />разрешить неавторизованным пользователям просматривать мою страницу</label>
				</li>
				<li>
					<p class="line-title">В мою гостевую книгу могут писать:</p>
					<div class="radiogroup">
						<label><input type="radio" name="radio" /> все пользователи</label><br/>
						<label><input type="radio" name="radio" /> только друзья</label><br/>
					</div>
				</li>
				<li>
					<p class="line-title">Диалоги со мной могут начинать:</p>
					<div class="radiogroup">
						<label><input type="radio" name="radio" /> все пользователи</label><br/>
						<label><input type="radio" name="radio" /> только друзья</label><br/>
					</div>
				</li>
		
			</ul>
		</div>

	</div>
</div>
<div class="bottom">
	<button class="btn btn-green-medium btn-arrow-right"><span><span>Сохранить<img src="/images/arrow_r.png" /></span></span></button>
</div>