<div class="comments-gray comments-gray__wide">
	<!-- Заглушка для ввода комментария, при клике в любом месте блока (кроме аватара) работает так же как в нижнем блоке -->
	<!-- А именно  -->
	<!-- 1. добавляется класс .active на .comments-gray_add -->
	<!-- 2. скрывается/удаляется .comments-gray_add-itx -->
	<!-- 3. Инициализируется визвиг -->
	<!-- Верхняя форма отличается только классом .comments-gray_add__top -->
	<div class="comments-gray_add comments-gray_add__top clearfix">
		
		<div class="comments-gray_ava">
			<a href="" class="ava middle female">
				<img src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" alt="">
			</a>
		</div>
		
		<div class="comments-gray_frame">
			<!-- input hidden -->
			<input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Добавьте комментарий">

		</div>
	</div>
	<div class="comments-gray_t">
		<span class="comments-gray_t-tx">Комментарии <span class="color-gray">(28)</span></span>
	</div>
	<div class="comments-gray_hold">
		<div class="comments-gray_i comments-gray_i__self">
			<div class="comments-gray_ava">
				<a href="" class="ava middle male"></a>
			</div>
			<div class="comments-gray_r">
				<div class="comments-gray_date">Сегодня 13:25</div>
				<!-- <div class="comments-gray_control">
					<div class="comments-gray_control-hold">
						<a href="" class="message-ico message-ico__edit powertip" title="Редактировать"></a>
						<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
					</div>
				</div> -->
			</div>
			<div class="comments-gray_frame">
				<div class="comments-gray_header clearfix">
					<a href="" class="comments-gray_author">Ангелина Богоявленская </a>

					<span class="comments-gray_date">Сегодня 13:25</span>
				</div>
				<div class="comments-gray_cont wysiwyg-content">
					<p>	<a href="">Вася Пупкин,</a> Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
					<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
				</div>
				<!-- <div class="comments-gray_bottom">
					
					<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
				</div> -->

                <div class="comments-gray_drive" data-bind="css: {'comments-gray_control__self': ownComment()}, visible: (!editMode() && !removed())">
                    <span class="comments-gray_drive-a" data-bind="visible: (!ownComment() && !$parent.gallery() && !photoUrl()), click: Reply">Ответить</span> 
                    <span class="comments-gray_drive-a" data-bind="visible: canEdit() && !$parent.gallery() && !photoUrl(), click: GoEdit">Редактировать</span> 
                    <span class="comments-gray_drive-a" data-bind="visible: canRemove(), click: Remove">Удалить</span>
                </div>
			</div>
		</div>
		<div class="comments-gray_i">
			<div class="comments-gray_ava">
				<a href="" class="ava middle female">
					<img src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" alt="">
				</a>
			</div>

			<div class="comments-gray_r">
				<div class="comments-gray_date">Сегодня 13:25</div>
				<div class="comments-gray_control">
					<div class="comments-gray_control-hold">
						<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
						<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
					</div>
				</div>
			</div>

			<div class="comments-gray_frame">
				<div class="comments-gray_header clearfix">
					<a href="" class="comments-gray_author">Анг Богоявлен </a>
					<div class="user-actions user-actions__small">
						<!-- 
							Виды иконок друг 
							user-actions_i__friend - друг
							user-actions_i__friend-add - добавить в друзья
							user-actions_i__friend-added - приглашение выслано
							user-actions_i__friend-append - встречное приглашение в друзья, принять
						 -->
						<a href="" class="user-actions_i user-actions_i__friend powertip" title="">
							<span class="user-actions_ico"></span>
							<span class="user-actions_tx">Друг</span>
						</a>
						<a href="" class="user-actions_i user-actions_i__message powertip" title="Написать сообщение">
							<span class="user-actions_ico"></span>
						</a>
					</div>
				</div>
				<div class="comments-gray_cont wysiwyg-content">
					<p>я не нашел, где можно поменять название трека. </p>
				</div>

				<div class="comments-gray_bottom">
					
					<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
					<span class="comments-gray_sepor"></span>
					<a href="" class="comments-gray_quote-ico"> Ответить</a>
				</div>
			</div>

		</div>


		<div class="comments-gray_add active clearfix">

			<div class="comments-gray_ava">
				<a class="ava middle female" href="">
				</a>
			</div>
			
			<div class="comments-gray_frame">
				<!-- input hidden -->
				<input type="text" name="" id="" class="comments-gray_add-itx itx-gray display-n" placeholder="Ваш комментарий">
				
				<script>
				$(document).ready(function () { 
				  $('.wysiwyg-redactor').redactor({
				      autoresize: true,
				      toolbarExternal: '.wysiwyg-toolbar-btn',
				      minHeight: 45,
				      buttons: ['bold', 'italic', 'underline', '|', 'image', 'video', 'smile'],
				      buttonsCustom: {
				          smile: {
				              title: 'smile',
				              callback: function(buttonName, buttonDOM, buttonObject) {
				                  // your code, for example - getting code
				                  var html = this.get();
				              }
				          },
				          h2: {
				              title: 'h2',
				              callback: function(buttonName, buttonDOM, buttonObject) {
				                  // your code, for example - getting code
				                  var html = this.get();
				              }
				          },
				          h3: {
				              title: 'h3',
				              callback: function(buttonName, buttonDOM, buttonObject) {
				                  // your code, for example - getting code
				                  var html = this.get();
				              }
				          }
				      }
				  });
				});
				</script>
				<div class="wysiwyg-h">
					<div class="wysiwyg-toolbar">
						<a href="" class="wysiwyg-toolbar_close ico-close3"></a>
						<div class="wysiwyg-toolbar-btn"></div>
					</div>
					<textarea name="" class="wysiwyg-redactor" ></textarea>
					<div class="redactor-control clearfix">

						<!-- <div class="redactor-control_quote">
							<span class="font-smallest color-gray">Ответ для</span>
							<span class="redactor-control_quote-tx">Вася Пупкин</span>
							<a href="" class="a-pseudo-gray font-small" title="Отменить ответ">Отмена</a>
						</div> -->
						<div class="float-r">
							<div class="redactor-control_key">
								<input type="checkbox" class="redactor-control_key-checkbox" id="redactor-control_key-checkbox" name="">
								<label class="redactor-control_key-label" for="redactor-control_key-checkbox">Enter - отправить</label>
							</div>
							<button class="btn-green">Отправить</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="comments-gray_i comments-gray_i__recovery">
			<div class="comments-gray_ava">
				<a href="" class="ava middle female"></a>
			</div>
			<div class="comments-gray_r">
				<div class="comments-gray_date">Сегодня 13:25</div>
				<div class="comments-gray_control">
					<div class="comments-gray_control-hold">
						<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
						<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
					</div>
				</div>
								
				
			</div>
			<div class="comments-gray_frame">
				<div class="comments-gray_header clearfix">
					<a href="" class="comments-gray_author">Анг Богоявлен </a>
					<div class="user-actions user-actions__small">
						<a href="" class="user-actions_i user-actions_i__friend-add powertip" title="Добавить в друзья">
							<span class="user-actions_ico"></span>
						</a>
						<a href="" class="user-actions_i user-actions_i__message powertip" title="Написать сообщение">
							<span class="user-actions_ico"></span>
						</a>
					</div>
				</div>
				<div class="comments-gray_cont wysiwyg-content">
					<p>Комментарий успешно удален. <a href="" class="comments-gray_a-recovery">Восстановить?</a> </p>
				</div>
				
				<div class="comments-gray_bottom">
						
					<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
					<span class="comments-gray_sepor"></span>
					<a href="" class="comments-gray_quote-ico"> Ответить</a>
				</div>
			</div>
		</div>
		
		<div class="comments-gray_i">
			<div class="comments-gray_ava">
				<a href="" class="ava middle female"></a>
			</div>
			<div class="comments-gray_r">
				<div class="comments-gray_date">Сегодня 13:25</div>
				<div class="comments-gray_control">
					<div class="comments-gray_control-hold">
						<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
						<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
					</div>
				</div>
			</div>
			<div class="comments-gray_frame">
				<div class="comments-gray_header clearfix">
					<a href="" class="comments-gray_author">Анг Богоявлен </a>
					<div class="user-actions user-actions__small">
						<a href="" class="user-actions_i user-actions_i__friend-added powertip" title="Приглашение отправленно">
							<span class="user-actions_ico"></span>
						</a>
						<a href="" class="user-actions_i user-actions_i__message powertip" title="Написать сообщение">
							<span class="user-actions_ico"></span>
						</a>
					</div>
				</div>
				<div class="comments-gray_cont wysiwyg-content">
					<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
					<p>
						<a href="" class="comments-gray_cont-img-w">
							<img src="/images/example/photo-window-2.jpg" alt="">
						</a>
					</p>
					<p>и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
				</div>
				<div class="comments-gray_bottom">
					
					<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
					<span class="comments-gray_sepor"></span>
					<a href="" class="comments-gray_quote-ico"> Ответить</a>
				</div>
			</div>
			
		</div>
	</div>

	<div class="comments-gray_add clearfix">
		
		<div class="comments-gray_ava">
			<a href="" class="ava middle female"></a>
		</div>
		<div class="comments-gray_frame">
			<input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий">
		</div>
	</div>

</div>