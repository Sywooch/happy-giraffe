<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	<script type="text/javascript" src="/javascripts/im.js"></script>

</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>

	
<div class="layout-container">
<div class="layout-container_hold">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div class="layout-content">	
			<a href="#message-fast" data-theme="transparent" class="fancy">Быстрое сообщение</a>
			<br>
			<a href="#message-fast2" data-theme="transparent" class="fancy">Быстрое сообщение отправляется</a>
			<br>
			<a href="#message-fast3" data-theme="transparent" class="fancy">Быстрое сообщение Нельзя писать без аватара</a>
		</div>	
		
	</div>
</div>
</div>

<div class="display-n">
<script>

$(document).ready(function () { 
  $('#redactor').redactor({
      focus: true,
      toolbarExternal: '#redactor-control-b_toolbar',
      buttons: ['image', 'video', 'smile'],
      buttonsCustom: {
          smile: {
              title: 'smile',
              callback: function(buttonName, buttonDOM, buttonObject) {
                  // your code, for example - getting code
                  var html = this.get();
              }
          }
      }
  });


  $('#redactor2').redactor({
      focus: true,
      toolbarExternal: '#redactor-control-b_toolbar2',
      buttons: ['image', 'video', 'smile'],
      buttonsCustom: {
          smile: {
              title: 'smile',
              callback: function(buttonName, buttonDOM, buttonObject) {
                  // your code, for example - getting code
                  var html = this.get();
              }
          }
      }
  });


  $('#redactor3').redactor({
      focus: true,
      toolbarExternal: '#redactor-control-b_toolbar3',
      buttons: ['image', 'video', 'smile'],
      buttonsCustom: {
          smile: {
              title: 'smile',
              callback: function(buttonName, buttonDOM, buttonObject) {
                  // your code, for example - getting code
                  var html = this.get();
              }
          }
      }
  });


});
</script>	

	<div id="message-fast" class="message-fast">
		<a class="message-fast_close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="message-fast_top clearfix">
			<div class="message-fast_t">
				Написать сообщение
			</div>
			<div class="message-fast_user-hold clearfix">
				<a href="" class="float-r font-small margin-t5">В диалоги</a>
				<div class="message-fast_user">
					<span class="message-fast_user-tx">Кому:</span>
					<a class="ava small female" href="">
						<span class="icon-status status-online"></span>
						<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
					</a>
					<a href="" class="message-fast_user-name">Арина Поплавская</a>
				</div>
			</div>
		</div>
		<div class="message-fast_bottom">
			<div class="redactor-control-b wysiwyg-blue">
				<textarea cols="40" id="redactor" name="redactor" class="redactor" rows="1" autofocus></textarea>
				<div class="redactor-control-b_toolbar" id="redactor-control-b_toolbar"></div>
				<div  class="redactor-control-b_control">
					<div class="redactor-control-b_key">
						<input type="checkbox" name="" id="redactor-control-b_key-checkbox" class="redactor-control-b_key-checkbox">
						<label for="redactor-control-b_key-checkbox" class="redactor-control-b_key-label">Enter - отправить</label>
					</div>
					<button class="btn-green">Отправить</button>
				</div>
			</div>
		</div>
	</div>
	
	
	<div id="message-fast2" class="message-fast">
		<a class="message-fast_close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="message-fast_top clearfix">
			<div class="message-fast_t">
				Написать сообщение
			</div>
			<div class="message-fast_user-hold clearfix">
				<a href="" class="float-r">В диалоги</a>
				<div class="message-fast_user">
					<span class="message-fast_user-tx">Кому:</span>
					<a class="ava small female" href="">
						<span class="icon-status status-online"></span>
						<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
					</a>
					<a href="" class="">Арина Поплавская</a>
				</div>
			</div>
		</div>
		<div class="message-fast_bottom">
			<div class="redactor-control-b wysiwyg-blue">
				<textarea cols="40" id="redactor2" name="redactor" class="redactor" rows="1" autofocus></textarea>
				<div class="redactor-control-b_toolbar" id="redactor-control-b_toolbar2" ></div>
				<div class="redactor-control-b_control">
					<div class="redactor-control-b_key">
						<input type="checkbox" name="" id="redactor-control-b_key-checkbox" class="redactor-control-b_key-checkbox">
						<label for="redactor-control-b_key-checkbox" class="redactor-control-b_key-label">Enter - отправить</label>
					</div>
					<button class="btn-green">Отправить</button>
				</div>
			</div>
		</div>
		<div class="message-fast_act">
			<div class="message-fast_act-tx">Сообщение отправлено</div>
		</div>
	</div>
	
	
	<div id="message-fast3" class="message-fast">
		<a class="message-fast_close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
		<div class="message-fast_top clearfix">
			<div class="message-fast_t">
				Написать сообщение
			</div>
			<div class="message-fast_user-hold clearfix">
				<a href="" class="float-r">В диалоги</a>
				<div class="message-fast_user">
					<span class="message-fast_user-tx">Кому:</span>
					<a class="ava small female" href="">
						<span class="icon-status status-online"></span>
						<img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg">
					</a>
					<a href="" class="">Арина Поплавская</a>
				</div>
			</div>
		</div>
		<div class="message-fast_bottom">
			<div class="redactor-control-b wysiwyg-blue">
				<textarea cols="40" id="redactor3" name="redactor" class="redactor" rows="1" autofocus></textarea>
				<div class="redactor-control-b_toolbar" id="redactor-control-b_toolbar3"></div>
				<div class="redactor-control-b_control">
					<div class="redactor-control-b_key">
						<input type="checkbox" name="" id="redactor-control-b_key-checkbox" class="redactor-control-b_key-checkbox">
						<label for="redactor-control-b_key-checkbox" class="redactor-control-b_key-label">Enter - отправить</label>
					</div>
					<button class="btn-green">Отправить</button>
				</div>
			</div>
		</div>
		<div class="cap-empty">
			<div class="cap-empty_hold">
				<div class="cap-empty_gray margin-b5">Для того, чтобы начать пользоваться сервисом, <br>необходимо загрузить главное фото</div>
				<a class="btn-green" href="">Загрузить  фото</a>
			</div>
		</div>
	</div>
	
</div>


</body>
</html>
