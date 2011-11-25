<?php
	function sor($content)
	{
		switch ($content->article->source_type)
		{
			case 'me';
				return 'Светлана';
				break;
			case 'book';
				return $content->article->book_author . '&nbsp' . $content->article->book_name;
				break;
			case 'internet';
				$link = $content->article->internet_link;
				$html = file_get_contents($link);
				if(preg_match('/<title>(.+)<\/title>/', $html, $matches)) $title = $matches[1];
				else $title = $link;
				$a = parse_url($link);
				$favicon = 'http://www.google.com/s2/favicons?domain=' . $a['host'];
				return CHtml::image($favicon) . '&nbsp' . CHtml::link($title, $link, array('class' => 'link'));
				break;
		}
	}
?>

<div class="breadcrumbs">
	<a href="/">Главная</a> <span class="way">  </span> <a href="/">Форумы</a>  <span class="way">  </span>  <a class="herenow" href="/">Детская комната</a>
</div>

<div class="kon_header">
	<div class="kon_name">
		<div class="kon_title"><?=$content->rubric->community->name?></div>
		<div class="g-button round">
			<div class="fill">
				<a href="" class="left-str">Вступить</a>
			</div>
			<div class="left">
			</div>
			<div class="right">
			</div>
		</div>
	</div>
	<div class="kon_menu">
		<a class="current" href="/">Статьи</a> 
		<a href="/">Видео</a> 
		<a href="/">Конкурсы</a> 
		<a href="/">Участники</a> 
		<a href="/">Правила</a>
	</div>
</div>

<div class="left-inner">

	<div class="add">
		<div class="g-button round">
			<div class="fill">
				<a href="" class="bot-str">Добавить</a>
			</div>
			<div class="left">
			</div>
			<div class="right">
			</div>
		</div>
		<div class="green"></div>
		<ul class="leftadd">
			<li><?php echo CHtml::link('Статью', CController::createUrl('community/add', array('community_id' => $content->rubric->community->id, 'rubric_id' => $content->rubric->id))); ?></li>
			<li><a href="/">Видео</a></li>
		</ul>
	</div>

	<div class="themes">
		<div class="theme-pic">Рубрики</div>
		<ul class="leftlist">
			<?php
				foreach ($content->rubric->community->rubrics as $r)
				{
					echo CHtml::tag('li', array(), CHtml::link($r->name, CController::createUrl('/community/list', array('community_id' => $content->rubric->community->id, 'rubric_id' => $r->id)), $r->id == $content->rubric->id ? array('class' => 'current'):array()));
				}
			?>
		
		</ul>


	</div>

	<div class="leftbanner">
		<a href="/"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/leftban.png"></a>
	</div>

</div>

<div class="right-inner">
	<div class="entry">

		<div class="entry-header">
			<?php echo CHtml::link($content->name, CController::createUrl('community/view', array('content_id' => $content->id)), array('class' => 'entry-title')); ?>
			<div class="user">
				<a href="" class="avatar"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ava.png"></a>
				<a class="username">Светлана</a>
			</div>
		
			<div class="meta">
				<div class="time"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", strtotime($content->created)); ?></div>
				<div class="seen">Просмотров:&nbsp <?php echo $content->views; ?></div>
				
			</div>
			<div class="clear"></div>
		</div>
	
		<div class="entry-content">
			<?php echo $content->article->text; ?>

			<div class="clear"></div>
		</div>
	
		<div class="entry-footer">
			<div class="source">Источник:&nbsp<?=sor($content)?></div>&nbsp
			<span class="comm">Комментариев: <span>0</span></span>
			<div class="spam">
				<a href="">Нарушение!</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div class="like-block">
		<h1>Вам полезна статья? Отметьте!</h1>
		<div class="like">
			<span>
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/vk_like_button.jpg"/>
			</span>
			<span>
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/vk_like_button.jpg"/>
			</span>
			<span>
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/vk_like_button.jpg"/>
			</span>
			<div class="clear"></div>
		</div>
		<div class="block">
			<div class="rate"><?php echo $content->rating; ?></div>
			рейтинг
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="more">
		<h2>
			Ещё статьи на эту тему
			<a href="" class="g-button blue">
				<span class="fill">Показать</span>
				<span class="left"></span>
				<span class="right"></span>
			</a>
		</h2>
		<div class="block">
			<h3><a href="">из которого изготовлена кроватка.</a></h3>
			<p>Определенные критерии предъявляются к жесткости матраца: не рекомендуется выбиратьслишком жесткий илислишком мягкий матрац. </p>
		</div>
		<div class="block">
			<h3><a href="">из которого изготовлена кроватка.</a></h3>
			<p><img src="http://img.wikimart.ru/img/catalog_model/f115/1147046/0_2287_mid4.jpeg" height="150"/></p>
		</div>
		<div class="block">
			<h3><a href="">из которого изготовлена кроватка.</a></h3>
			<p>Определенные критерии предъявляются к жесткости матраца: не рекомендуется выбиратьслишком жесткий илислишком мягкий матрац. </p>				
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="comments">
		<div class="c-header">
			<div class="left-s">
				<span>Комментарии</span>
				<span class="col">55</span>
			</div>
			<div class="right-s">
				<a href="">Подписаться</a>
				<a href="" class="g-button orange">
					<span class="fill">Добавить комментарий</span>
					<span class="right"></span>
					<span class="left"></span>
				</a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="item">
			<div class="user">
				<a href="" class="avatar"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ava.png"></a>
				<a class="username">Светлана</a>
			</div>
			<div class="text">
				<p>Определенные критерии предъявляются к жесткости матраца: не рекомендуется выбиратьслишком жесткий илислишком мягкий матрац. </p>
				<div class="data">
					08 сентября 2011, 19:30
					<a href="" class="report"></a>
				</div>
			</div>
			<div class="clear"></div>
			<div class="report-block">
				<div class="left-b">
					<h2>Укажите нарушение</h2>
					<p>
						<input type="radio" name="v" id="value1"class="RadioClass"/>
						<label for="value1" class="RadioLabelClass">Спам</label>
					</p>
					<p>
						<input type="radio" name="v" id="value2" class="RadioClass"/>
						<label for="value2" class="RadioLabelClass">Оскорбление пользователей</label>
					</p>
					<p>
						<input type="radio" name="v" id="value3" class="RadioClass"/>
						<label for="value3" class="RadioLabelClass">Разжигание межнациональной розни</label>
					</p>
					<p>
						<input type="radio" name="v" id="value4" class="RadioClass"/>
						<label for="value4" class="RadioLabelClass">Другое</label>
					</p>
				</div>
				<div class="right-b">
					<h3>Опишите нарушение (обязательно)</h3>
					<textarea></textarea>
				</div>
				<div class="clear"></div>
				<div class="button_panel">
					<a href="" class="g-button grey">
						<span class="fill">Отменить</span>
						<span class="right"></span>
						<span class="left"></span>
					</a>
					<div class="g-button red">
						<div class="fill">
							<input type="submit" value="Сообщить о нарушении"/>
						</div>
						<div class="left">
						</div>
						<div class="right">
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="item">
			<div class="user">
				<a href="" class="avatar"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ava.png"></a>
				<a class="username">Светлана</a>
			</div>
			<div class="text">
				<p>Определенные критерии предъявляются к жесткости матраца: не рекомендуется выбиратьслишком жесткий илислишком мягкий матрац. </p>
				<div class="data">
					08 сентября 2011, 19:30
					<a href="" class="report"></a>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
	</div>
	
	
	<div class="paginator">
		<span class="txt">
			Показано: 1-15 из 82
		</span>
		<div class="pages">
			<span class="txt">
				Страниц
			</span>
			<a href="" class="prev"></a>
			<a href="">5</a>
			<a href="">6</a>
			<div class="current">
				<div class="fill">755</div>
				<div class="left"></div>
				<div class="right"></div>
			</div>
			<a href="">8</a>
			<a href="">9</a>
			<a href="" class="next"></a>
		</div>
		<div class="clear"></div>
	</div>

	<div class="new_comment">
		<textarea>
		</textarea>
		<div class="button_panel">
			<a href="" class="g-button grey">
				<span class="fill">Отменить</span>
				<span class="right"></span>
				<span class="left"></span>
			</a>
			<div class="g-button">
				<div class="fill">
					<input type="submit" value="Добавить"/>
				</div>
				<div class="left">
				</div>
				<div class="right">
				</div>
			</div>
		</div>
	</div>
</div>