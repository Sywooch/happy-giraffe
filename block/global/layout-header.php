﻿<div class="clearfix layout-header">
	<div class="layout-header-hold">
		<div class="clearfix">
			
			<div class="logo-box">
				<a href="/" class="logo" title="hg.ru – Домашняя страница">Ключевые слова сайта</a>
				<span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
			</div>
			<div class="layout-header-section">
			<?php 
				if(isset($headerSection)) {
					echo $headerSection;
				} else {
					/* размеры изображения 195*115пк */
					echo ('
						<a class="layout-header-section_a" href="">
					      <img alt="" src="/images/" class="layout-header-section_img">
					      <span class="layout-header-section_text">Заглавие шапки</span>
					    </a>
					');
				}
			?>
			</div>
<!--#printenv -->
		</div>

	</div>
	
</div>