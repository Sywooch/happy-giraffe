<!DOCTYPE html>
<!--[if lt IE 8]>      <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html class=""> <!--<![endif]-->
<head>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
	
</head>
<body class="body-gray">

	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/top-line-menu.php'; ?>
	
<div class="layout-container">
	<div class="layout-wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/header-new.php'; ?>
		
		<div class="layout-content clearfix">
		
		<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/club-top.php'; ?>

		<div class="content-cols clearfix">
			<div class="col-gray padding-20">
					
				<div id="calories-calculator">
					
					<div class="title">
						<span>Узнайте!</span>
						<h2>Сколько калорий<br/>в Ваших продуктах</h2>
						<h1>Счетчик калорий</h1>
					</div>
					
					<div class="calculator">
						
						<table>
							<thead>
								<tr>
									<td class="col-1">Продукт</td>
									<td class="col-2">Кол-во</td>
									<td class="col-3">Ед. изм.</td>
									<td class="col-4"><span class="calories-icon orange">Б</span>Белки, <span>г.</span></td>
									<td class="col-5"><span class="calories-icon green">Ж</span>Жиры, <span>г.</span></td>
									<td class="col-6"><span class="calories-icon yellow">У</span>Углеводы, <span>г.</span></td>
									<td class="col-7"><span class="calories-icon blue">К</span>Калории, <span>ккал.</span></td>
									<td class="col-8">&nbsp;</td>
								</tr>
								
							</thead>
							<tbody>
								<tr>
									<td class="col-1"><input type="text" value="" placeholder="Введите название продукта" /></td>
									<td class="col-2"><input type="text" value="" placeholder="0" /></td>
									<td class="col-3"><span class="chzn-gray"><select class="chzn"><option>1</option><option>2</option></select></span></td>
									<td class="col-4"><div class="value">&nbsp;</div></td>
									<td class="col-5"><div class="value">&nbsp;</div></td>
									<td class="col-6"><div class="value">&nbsp;</div></td>
									<td class="col-7"><div class="value">&nbsp;</div></td>
									<!-- Подсказки tooltip заменить новыми powertip -->
									<td class="col-8"><a href="" class="remove powertip" title="Удалить"></a></td>
								</tr>
								<tr>
									<td class="col-1"><input type="text" value="Кофе растворимый" placeholder="Введите название продукта" /></td>
									<td class="col-2"><input type="text" value="2" placeholder="0" /></td>
									<!-- Селекты chzn-v2 заменить на chzn-gray -->
									<td class="col-3"><span class="chzn-gray"><select class="chzn"><option>грамм</option><option>ст. ложки</option><option>шт.</option></select></span></td>
									<td class="col-4"><div class="value">2,0</div></td>
									<td class="col-5"><div class="value">0,5</div></td>
									<td class="col-6"><div class="value">0,1</div></td>
									<td class="col-7"><div class="value">2,1</div></td>
									<td class="col-8"><a href="" class="remove powertip" title="Удалить"></a></td>
								</tr>
								<tr>
									<td class="col-1"><input type="text" value="Кофе растворимый" placeholder="Введите название продукта" /></td>
									<td class="col-2"><input type="text" value="2" placeholder="0" /></td>
									<td class="col-3"><span class="chzn-gray"><select class="chzn"><option>ст. ложки</option><option>шт.</option><option>грамм</option></select></span></td>
									<td class="col-4"><div class="value">2,0</div></td>
									<td class="col-5"><div class="value">0,5</div></td>
									<td class="col-6"><div class="value">0,1</div></td>
									<td class="col-7"><div class="value">2,1</div></td>
									<td class="col-8"><a href="" class="remove powertip" title="Удалить"></a></td>
								</tr>
								<tr>
									<td class="col-1"><input type="text" value="Кофе растворимый" placeholder="Введите название продукта" /></td>
									<td class="col-2"><input type="text" value="2" placeholder="0" /></td>
									<td class="col-3"><span class="chzn-gray"><select class="chzn"><option>шт.</option><option>ст. ложки</option><option>грамм</option></select></span></td>
									<td class="col-4"><div class="value">2,0</div></td>
									<td class="col-5"><div class="value">0,5</div></td>
									<td class="col-6"><div class="value">0,1</div></td>
									<td class="col-7"><div class="value">2,1</div></td>
									<td class="col-8"><a href="" class="remove powertip" title="Удалить"></a></td>
								</tr>
								<!-- Изменены 3 последние строки таблицы -->
								<tr>
									<td class="padding-t10"></td>
								</tr>
								<tr class="summary">
									<td class="col-1" rowspan="2">
										<!-- Была кнопка btn btn-green-medium  -->
										<a href="" class="btn-green btn-medium font-middle">Добавить новый продукт</a> <br>
										Вы можете добавлять любое количество продуктов. Просто нажмите на кнопку “Добавить новый продукт"
									</td>
									<td class="col-23" colspan="2">Итого:</td>
									<td class="col-4">902,0</td>
									<td class="col-5">76,55</td>
									<td class="col-6">750,1</td>
									<td class="col-7">900,1</td>
									<td class="col-8">&nbsp;</td>
								</tr>
								<tr class="summary">
									<td class="col-23" colspan="2">Итого на 100г.:</td>
									<td class="col-4">902,0</td>
									<td class="col-5">76,55</td>
									<td class="col-6">750,1</td>
									<td class="col-7">900,1</td>
									<td class="col-8">&nbsp;</td>
								</tr>
								
							</tbody>
						</table>
						
					</div>
					
					<div class="wysiwyg-content">

				        <h2>Сервис «Счетчик калорий»</h2>

				        <p>Калория – это то количество тепла, которое необходимо,  чтобы нагреть один грамм воды с 19,5 градусов до 20,5, то есть это – энергия. Собственно, мы и едим для того, чтобы иметь энергию, которая нужна нам для жизни.</p>
				        <p>Но вот беда: если съесть меньше, организм начинает расходовать собственные запасы, а если съесть больше – откладывать «жирок», который, конечно же, округляет тело именно в тех местах, где меньше всего нужно. А как удержаться в золотой середине?</p>
				        <p>Над этим вопросом работают лучшие диетологи мира, предлагая одну диету за другой и всё совершенствуя счетчик калорий, без которого трудно удержаться в границах дозволенного. Раньше эти расчёты передавались из рук в руки по большому секрету.</p>

				        <p>А вы не увлекаетесь подсчетом съеденных калорий? О! Это так интересно! Особенно тем, кто хочет немного похудеть или держать свой вес под контролем. Только оказывается, сложное это дело и кропотливое. Даже если скачать из Интернета подробную таблицу по калорийности продуктов, всё равно приходится пересчитывать с калькулятором, сколько же белков, углеводов, жиров, а также калорий содержит определенный продукт. А ведь приём пищи состоит не из одного продукта! Один-два дня проходят в расчетах и всё – надоело. Результат равен нулю и благое начинание окончилось ничем. Жаль, но ничего не поделаешь.</p>
				        <div class="brushed">
				        <p>Разве что – воспользоваться нашим специальным сервисом «Счетчик калорий онлайн». Он очень удобен тем, что сделан просто. В специальную графу вводим название продукта (выбираем из списка), его количество и единицы измерения. Через секунду счетчик калорий покажет, сколько белков, жиров, углеводов и калорий содержится в том количестве продукта, которое у вас есть. Но это ещё не всё!</p>
				        </div>
				        <p>Вы можете составить целый список продуктов, из которых будет состоять ваш завтрак, обед, ужин или просто перекус, и увидеть итоговые показатели питательности и калорийности. В случае перебора можно подкорректировать – убрать лишние калории или жиры, сократив количество соответствующих продуктов.</p>
				        <p>Наш счетчик калорий онлайн – один из самых полных в Интернете, но при этом самый удобный и простой для пользования. Попробуйте им воспользоваться однажды, и вы поймёте, какое это интересное и захватывающее дело – отслеживать, как меняется ваша фигура и вес в зависимости от съедаемой пищи и физической активности.</p>

				    </div>
					
				</div>
				
			</div>
		</div>
		</div>
		
		<a href="#layout" id="btn-up-page"></a>
		<div class="footer-push"></div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/footer.php'; ?>
</div>

<div class="display-n">
	
</div>
</body>
</html>