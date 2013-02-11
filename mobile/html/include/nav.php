		<div class="logo">
			<a href="" class="logo_a">Веселыйй жираф</a>
		</div>
	<script>

		$(function() {
			var navPush     = $('.nav_t');
				nav 		= $('.nav_hold');
				navDrop     = $('.nav_drop');

			navPush.on('click', function(e) {
				nav.toggleClass('nav_hold__open');
			});

			$('.nav_i').on('click', function(e) {
				e.preventDefault();
				$(this).closest(".nav_li:has(.nav-drop)").toggleClass('nav_li__active');
			});

		});
	</script>
		<div class="nav">
			<span class="nav_t" >Разделы</span>
			<div class="nav_hold">
				<ul class="nav_ul">
					<li class="nav_li nav_li__active">
						<a href="" class="nav_i">
							<i class="nav_ico nav_ico__club"></i>
							Клубы
							<span class="nav_arrow-down"></span>
						</a>
						<div class="nav-drop">
							<ul class="nav-drop_ul">
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Здоровье</a>
								</li>
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Дети </a>
								</li>
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Кулинария </a>
								</li>
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Здоровье</a>
								</li>
							</ul>
						</div>
					</li>
					<li class="nav_li">
						<a href="" class="nav_i">
							<i class="nav_ico nav_ico__blog"></i>
							Блоги
						</a>
					</li>
					<li class="nav_li">
						<a href="" class="nav_i">
							<i class="nav_ico nav_ico__horoscope"></i>
							Гороскопы
						</a>
					</li>
					<li class="nav_li">
						<a href="" class="nav_i">
							<i class="nav_ico nav_ico__cook"></i>
							Рецепты
							<span class="nav_arrow-down"></span>
						</a>
						<div class="nav-drop">
							<ul class="nav-drop_ul">
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Здоровье</a>
								</li>
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Дети </a>
								</li>
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Кулинария </a>
								</li>
								<li class="nav-drop_li">
									<a href="" class="nav-drop_i">Здоровье</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
				<div class="nav-search">
					<div class="nav-search_hold">
						<input type="text" name="" id="" class="nav-search_itx" placeholder="Поиск"/>
						<input type="submit" class="nav-search_btn btn-green" value="Поиск"/>
					</div>
				</div>
			</div>
		</div>
