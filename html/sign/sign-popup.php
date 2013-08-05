<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu_nologin.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">

		
		<div class="layout-content clearfix">
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<a href="#register-step1" class="fancy" data-theme="transparent" >Регистрация шаг 1</a>
			<br>
			<a href="#register-step2" class="fancy" data-theme="transparent" >Регистрация шаг 2</a>
			<br>
			<a href="#register-step2-social" class="fancy" data-theme="transparent" >Регистрация шаг 2 через соц. сети</a>
			<br>
			<a href="#login" class="fancy" data-theme="transparent" >Логин</a>
			<br>
			<a href="#login-retrieve" class="fancy" data-theme="transparent" >Восстановление пароля</a>
			<br>
			<a href="#login-retrieve-send" class="fancy" data-theme="transparent" >Восстановление пароля, письмо отправлено</a>
			<br>
		</div>  	
		
		<div class="push"></div>
		
	</div>

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>
	
	
<div style="display:none" class="popup-container">
	
 
  	<!-- register-step1 -->
	<div id="register-step1" class="popup-sign">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-830">

				<div class="b-settings-blue">
					<div class="b-sign">
						<div class="b-sign_t">Регистрация на Веселом Жирафе</div>
						<div class="textalign-c margin-b30">
							<span class="i-highlight i-highlight__big font-big">Стань полноправным участником сайта за 1 минуту!</span>
						</div>
						<div class="clearfix">
							<div class="b-sign_left-soc">
								<div class="b-sign_sub-t margin-b30">Через социальные сети</div>
								<div class="clearfix">
									<a class="b-social-big" href="">
										<span class="b-social-big_ico odkl"></span>
									</a>
									<a class="b-social-big" href="">
										<span class="b-social-big_ico vk"></span>
									</a>
									<a class="b-social-big" href="">
										<span class="b-social-big_ico fb"></span>
									</a>
									<a class="b-social-big" href="">
										<span class="b-social-big_ico tw"></span>
									</a>
								</div>
							</div>
							
							<div class="b-sign_right-b">
								<div class="b-sign_sub-t">С помощью электронной почты</div>
								<div class="margin-b30 clearfix">
									<div class="b-sign_itx-hold">
										<input type="text" name="" id="" class="itx-simple" placeholder="Введите ваш e-mail">
									</div>
									<button class="btn-green btn-middle">Ok</button>
								</div>
								<ul class="b-sign_ul">
									<li class="b-sign_li">Мы не любим спам</li>
									<li class="b-sign_li">Мы не передадим ваши контакты третьим лицам</li>
									<li class="b-sign_li">Вы можете изменить настройки электронной почты в любое время</li>
								</ul>
							</div>
						</div>
						<div class="b-sign_bottom">
							Вы уже зарегистрированы?
							<a href="" class="margin-l10">Войти</a>
						</div>
					</div>
					
					
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /register-step1 -->
    
  	<!-- register-step2 -->
	<div id="register-step2" class="popup-sign">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-830">

				<div class="b-settings-blue">
					<div class="b-sign">
						<div class="b-sign_t">Вы уже почти с нами!</div>
						<div class="textalign-c margin-b30">
							<span class="i-highlight i-highlight__big font-big">Осталось ввести еще немного данных</span>
						</div>
						<div class="textalign-c margin-b40">
							<div class="display-ib verticalalign-m">
								<div class="b-sign_label-hold margin-r10">
									<label for="" class="b-sign_label">Ваш e-mail</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple" placeholder="Введите ваш e-mail">
								</div>
								<div class="float-l w-30">
									<div class="b-sign_win"></div>
								</div>
							</div>
						</div>
						<div class="margin-b40 clearfix">
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Имя</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple" placeholder="Введите имя">
								</div>
								<div class="b-sign_win"></div>
							</div>
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Фамилия</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple" placeholder="Введите фамилию">
								</div>
								<div class="b-sign_win"></div>
							</div>
						</div>
						<div class="margin-b30 clearfix">
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Дата рождения</label>
								</div>
								<div class="b-sign_itx-hold">
									<div class="w-75 float-l margin-r5">
										<div class="chzn-itx-simple">
											<select class="chzn">
												<option selected="selected">0</option>
												<option>1</option>
												<option>2</option>
												<option>32</option>						
												<option>32</option>						
												<option>32</option>						
												<option>32</option>						
											</select>
										</div>
									</div>
									<div class="w-100 float-l margin-r5">
										<div class="chzn-itx-simple">
											<select class="chzn">
												<option selected="selected">Января</option>
												<option>Февраля</option>
												<option>Марта</option>
												<option>Апреля</option>						
												<option>Майя</option>						
												<option>Июня</option>						
												<option>Июля</option>						
												<option>Августа</option>						
												<option>Сентября</option>						
												<option>Октября</option>						
												<option>Ноября</option>			
												<option>Декабря</option>			
											</select>
										</div>
									</div>
									<div class="w-85 float-l">
										<div class="chzn-itx-simple">
											<select class="chzn">
												<option selected="selected">1912</option>
												<option>1913</option>
												<option>1914</option>
												<option>1915</option>						
												<option>1916</option>						
												<option>1917</option>						
												<option>1918</option>						
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Пол</label>
								</div>
								<div class="b-sign_itx-hold">
									<div class="b-radio-icons">
										<!-- Данные для примера id="radio2" name="b-radio2" и for="radio2" -->
										<input type="radio" name="b-radio2" id="radio2" class="b-radio-icons_radio" checked="">
										<label for="radio2" class="b-radio-icons_label">
											<span class="ico-male"></span>
										</label>
										<!-- Данные для примера id="radio3" name="b-radio2" и for="radio3" -->
										<input type="radio" name="b-radio2" id="radio3" class="b-radio-icons_radio">
										<label for="radio3" class="b-radio-icons_label">
											<span class="ico-female"></span>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="b-sign_hr margin-b30"></div>
						
						
						<div class="margin-b40 clearfix">
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Пароль</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="password" name="" id="" class="itx-simple">
									<div class="b-sign_itx-desc">Придумайте сложный пароль, от 6 до 12 символов - цифры и английские буквы.</div>
								</div>
								<div class="b-sign_win"></div>
							</div>
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Пароль <br>еще раз</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple error">
									<div class="errorMessage">Введите минимум 6 знаков</div>
								</div>
							</div>
						</div>
						
						<div class="b-sign_bottom">
							<button class="btn-blue btn-h55 b-sign_btn-reg">Регистрация</button>
						</div>
					</div>
					
					
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /register-step2 -->   
	 
  	<!-- register-step2-social -->
	<div id="register-step2-social" class="popup-sign">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-830">

				<div class="b-settings-blue">
					<div class="b-sign">
						<div class="b-sign_t">Вы уже почти с нами!</div>
						<div class="textalign-c margin-b30">
							<span class="i-highlight i-highlight__big font-big">Осталось ввести еще немного данных</span>
						</div>
						<div class="textalign-c margin-b40">
							<div class="display-ib verticalalign-m margin-r20">
								<div class="ava"></div>
							</div>
							<div class="display-ib verticalalign-m">
								<div class="b-sign_label-hold margin-r10">
									<label for="" class="b-sign_label">Ваш e-mail</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple" placeholder="Введите ваш e-mail">
								</div>
								<div class="float-l w-30">
									<div class="b-sign_win"></div>
								</div>
							</div>
						</div>
						<div class="margin-b40 clearfix">
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Имя</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple" placeholder="Введите имя">
								</div>
								<div class="b-sign_win"></div>
							</div>
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Фамилия</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple" placeholder="Введите фамилию">
								</div>
								<div class="b-sign_win"></div>
							</div>
						</div>
						<div class="margin-b30 clearfix">
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Дата рождения</label>
								</div>
								<div class="b-sign_itx-hold">
									<div class="w-75 float-l margin-r5">
										<div class="chzn-itx-simple">
											<select class="chzn">
												<option selected="selected">0</option>
												<option>1</option>
												<option>2</option>
												<option>32</option>						
												<option>32</option>						
												<option>32</option>						
												<option>32</option>						
											</select>
										</div>
									</div>
									<div class="w-100 float-l margin-r5">
										<div class="chzn-itx-simple">
											<select class="chzn">
												<option selected="selected">Января</option>
												<option>Февраля</option>
												<option>Марта</option>
												<option>Апреля</option>						
												<option>Майя</option>						
												<option>Июня</option>						
												<option>Июля</option>						
												<option>Августа</option>						
												<option>Сентября</option>						
												<option>Октября</option>						
												<option>Ноября</option>			
												<option>Декабря</option>			
											</select>
										</div>
									</div>
									<div class="w-85 float-l">
										<div class="chzn-itx-simple">
											<select class="chzn">
												<option selected="selected">1912</option>
												<option>1913</option>
												<option>1914</option>
												<option>1915</option>						
												<option>1916</option>						
												<option>1917</option>						
												<option>1918</option>						
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Пол</label>
								</div>
								<div class="b-sign_itx-hold">
									<div class="b-radio-icons">
										<!-- Данные для примера id="radio4" name="b-radio2" и for="radio4" -->
										<input type="radio" name="b-radio2" id="radio4" class="b-radio-icons_radio" checked="">
										<label for="radio4" class="b-radio-icons_label">
											<span class="ico-male"></span>
										</label>
										<!-- Данные для примера id="radio5" name="b-radio2" и for="radio5" -->
										<input type="radio" name="b-radio2" id="radio5" class="b-radio-icons_radio">
										<label for="radio5" class="b-radio-icons_label">
											<span class="ico-female"></span>
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="b-sign_hr margin-b30"></div>
						
						
						<div class="margin-b40 clearfix">
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Пароль</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="password" name="" id="" class="itx-simple">
									<div class="b-sign_itx-desc">Придумайте сложный пароль, от 6 до 12 символов - цифры и английские буквы.</div>
								</div>
								<div class="b-sign_win"></div>
							</div>
							<div class="float-l w-50p">
								<div class="b-sign_label-hold">
									<label for="" class="b-sign_label">Пароль <br>еще раз</label>
								</div>
								<div class="b-sign_itx-hold">
									<input type="text" name="" id="" class="itx-simple error">
									<div class="errorMessage">Введите минимум 6 знаков</div>
								</div>
							</div>
						</div>
						
						<div class="b-sign_bottom">
							<button class="btn-blue btn-h55 b-sign_btn-reg">Регистрация</button>
						</div>
					</div>
					
					
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /register-step2-social -->
  
   
  	<!-- login -->
	<div id="login" class="popup-sign">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-830">

				<div class="b-settings-blue">
					<div class="b-sign">
						<div class="b-sign_t">
							<span class="ico-lock-big"></span>
							Вход на сайт
						</div>
						
						<div class="clearfix">
							<div class="b-sign_left-soc">
								<div class="b-sign_sub-t margin-b30">Через социальные сети</div>
								<div class="clearfix">
									<a class="b-social-big" href="">
										<span class="b-social-big_ico odkl"></span>
									</a>
									<a class="b-social-big" href="">
										<span class="b-social-big_ico vk"></span>
									</a>
									<a class="b-social-big" href="">
										<span class="b-social-big_ico fb"></span>
									</a>
									<a class="b-social-big" href="">
										<span class="b-social-big_ico tw"></span>
									</a>
								</div>
							</div>
							
							<div class="b-sign_right-b">
								<div class="margin-b20 margin-t40 clearfix">
									<div class="b-sign_label-hold">
										<label for="" class="b-sign_label">E-mail</label>
									</div>
									<div class="b-sign_itx-hold">
										<input type="text" name="" id="" class="itx-simple" >
									</div>
									<div class="b-sign_win"></div>
								</div>
								<div class="margin-b20 clearfix">
									<div class="b-sign_label-hold">
										<label for="" class="b-sign_label">Пароль</label>
									</div>
									<div class="b-sign_itx-hold">
										<input type="text" name="" id="" class="itx-simple error" >
										<div class="errorMessage">Введите минимум 6 знаков</div>
									</div>
								</div>
								<div class="margin-b20 clearfix">
									<div class="b-sign_label-hold">
										<label for="" class="b-sign_label"></label>
									</div>
									<div class="b-sign_itx-hold">
										<a href="" class="display-ib margin-t15">Забыли пароль?</a>
										<button class="float-r btn-blue btn-h46">Войти</button>
									</div>
								</div>
							</div>
						</div>
						<div class="b-sign_bottom">
							Вы еще не зарегистрированы?
							<a href="" class="margin-l10">Регистрация</a>
						</div>
					</div>
					
					
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /login --> 
	  
  	<!-- login-retrieve -->
	<div id="login-retrieve" class="popup-sign">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-830">

				<div class="b-settings-blue">
					<div class="b-sign">
						<div class="b-sign_t">
							<span class="ico-lock-big"></span>
							Забыли пароль?
						</div>
						
						<div class="b-sign_retrieve clearfix">
							<div class="b-sign_retrieve-hold">
								<div class="margin-b20 clearfix">
									Пожалуйста введите ваш e-mail адрес. <br> Вам будет выслано письмо с вашим паролем.
								</div>
								<div class="margin-b20 clearfix">
									<div class="b-sign_label-hold">
										<label for="" class="b-sign_label">E-mail</label>
									</div>
									<div class="b-sign_itx-hold w-300">
										<input type="text" name="" id="" class="itx-simple error" value="werwwer.er">
										<div class="errorMessage">Введите минимум 6 знаков</div>
									</div>
								</div>
							</div>
							<button class="float-r btn-blue btn-h46">Отправить</button>
						</div>
						
						
					</div>
					
					
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /login-retrieve -->
    	  
  	<!-- login-retrieve-send -->
	<div id="login-retrieve-send" class="popup-sign">
		<a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="clearfix">
			<div class="w-830">

				<div class="b-settings-blue">
					<div class="b-sign">
						<div class="b-sign_t">
							<span class="ico-lock-big"></span>
							Забыли пароль?
						</div>
						
						<div class="b-sign_retrieve clearfix">
							<div class="b-sign_retrieve-hold">
								<div class="margin-b20 clearfix">
									Пожалуйста введите ваш e-mail адрес. <br> Вам будет выслано письмо с вашим паролем.
								</div>
								<div class="margin-b20 clearfix">
									<div class="b-sign_label-hold">
										<label for="" class="b-sign_label">E-mail</label>
									</div>
									<div class="b-sign_itx-hold w-300">
										<input type="text" name="" id="" class="itx-simple" value="werwer@wer.er">
									</div>
									<div class="b-sign_win"></div>
								</div>
								<div class="b-sign_retrieve-send">
									<div class="clearfix">
										<span class="i-highlight">На ваш e-mail адрес было выслано письмо с вашим паролем.</span>
									</div>
									<div class="clearfix">
										<span class="i-highlight">Также проверьте, пожалуйста, папку «Спам».</span>
									</div>
								</div>
							</div>
							<button class="float-r btn-blue btn-h46">Вход на сайт</button>
						</div>
						
						
					</div>
					
					
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- /login-retrieve-send -->
    
  
</div>
</body>
</html>