<!-- 
	При расскрытии списка комментариев нужно добавить класс .scroll__on к .scroll
	Так же .comments-gray_hold__scroll к .comments-gray_hold
	и обновить кастомный скролл (baron) 
 -->


	<div class="comments-gray">
		<div class="comments-gray_t">
			<span class="comments-gray_t-tx">Комментарии <span class="color-gray">(28)</span></span>
			<a href="" class="a-pseudo font-small">Скрыть все</a>
		</div>

		<div class="scroll">
			<div class="comments-gray_hold comments-gray_hold__scroll scroll_scroller">
				<div class="comments-gray_i comments-gray_i__self">
					<div class="comments-gray_ava">
						<a href="" class="ava middle male"></a>
					</div>
					<div class="comments-gray_r">
						<div class="comments-gray_date">Сегодня 13:25</div>
						<div class="comments-gray_control">
							<div class="comments-gray_control-hold">
								<a href="" class="message-ico message-ico__edit powertip" title="Редактировать"></a>
								<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
							</div>
						</div>
						
					</div>
					<div class="comments-gray_frame">
						<div class="comments-gray_header clearfix">
							<a href="" class="comments-gray_author">Ангелина Богоявленская </a>
							<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
						</div>
						<div class="comments-gray_cont wysiwyg-content">
							<p>	<a href="">Вася Пупкин,</a> Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
							<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
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
						  $('.wysiwyg-redactor1').redactor({
						      autoresize: true,
						      toolbarExternal: '.wysiwyg-toolbar-btn1',
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
								<div class="wysiwyg-toolbar-btn1"></div>
							</div>
							<textarea name="" class="wysiwyg-redactor1" ></textarea>
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
				<div class="comments-gray_i comments-gray_i__pink">
					<div class="comments-gray_ava">
						<a href="" class="ava middle female"></a>
					</div>

					<div class="comments-gray_r">
						<div class="comments-gray_date">Сегодня 13:25</div>
											
						<div class="comments-gray_control">
							<div class="comments-gray_control-hold">
								<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
								<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
								<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
							</div>
						</div>
						
					</div>

					<div class="comments-gray_frame">
						<div class="comments-gray_header clearfix">
							<a href="" class="comments-gray_author">Анг Богоявлен </a>
							<span class="comments-gray_spec">ветеринар</span>
							<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
						</div>
						<div class="comments-gray_cont wysiwyg-content">
							<p>я не нашел, где можно поменять название трека. </p>
							<p>
								<a href="" class="comments-gray_cont-img-w">
									<img src="/images/example/photo-window-2.jpg" alt="">
								</a>
							</p>
						</div>
					</div>

				</div>
				
				<div class="comments-gray_i comments-gray_i__recovery">
					<div class="comments-gray_ava">
						<a href="" class="ava middle female"></a>
					</div>
					<div class="comments-gray_r">
						<div class="comments-gray_date">Сегодня 13:25</div>
						
						<!-- В удаленном сообщении не должно быть кнопок управления -->				
						<!-- <div class="comments-gray_control">
							<div class="comments-gray_control-hold">
								<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
								<a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
								<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
							</div>
						</div> -->
						
					</div>
					<div class="comments-gray_frame">
						<div class="comments-gray_header clearfix">
							<a href="" class="comments-gray_author">Анг Богоявлен </a>
							<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
						</div>
						<div class="comments-gray_cont wysiwyg-content">
							<p>Комментарий успешно удален. <a href="" class="comments-gray_a-recovery">Восстановить?</a> </p>
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
								<a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
								<a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
							</div>
						</div>
						
					</div>
					<div class="comments-gray_frame">
						<div class="comments-gray_header clearfix">
							<a href="" class="comments-gray_author">Анг Богоявлен </a>
							<a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
						</div>
						<div class="comments-gray_cont wysiwyg-content">
							<p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
								<p>
									<a href="" class="comments-gray_cont-img-w">
										<img src="/images/example/photo-window-1.jpg" alt="">
									</a>
								</p>
							<p>и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
						</div>
					</div>
					
				</div>
			</div>
			<div class="scroll_bar-hold">
	            <div class="scroll_bar">
	            	<div class="scroll_bar-in"></div>
	            </div>
	        </div>
		</div>
		
		<div class="comments-gray_add clearfix">
			
			<div class="comments-gray_ava">
				<a href="" class="ava middle female"></a>
			</div>
			
			<div class="comments-gray_frame">
				<!-- input hidden -->
				<input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Добавьте комментарий">
	
			</div>
		</div>
		<div class="textalign-c margin-t10">
			<a href="" class="a-pseudo font-small">Скрыть все</a>
		</div>
	</div>
<script>
/* Кастомный скролл */
window.onload = function() {
  /* custom scroll */
  var scroll = $('.scroll').baron({
    scroller: '.scroll_scroller',
    container: '.scroll_cont',
    track: '.scroll_bar-hold',
    barOnCls: 'scroll__on',
    bar: '.scroll_bar'
  });
  
}
</script>