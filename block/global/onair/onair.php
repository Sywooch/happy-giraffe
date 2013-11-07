

<div class="b-onair tabs">
	<div class="b-onair_tab clearfix">
		<ul class="b-onair_tab-ul">
			<li class="b-onair_tab-li active">
				<a href="javascript:void(0);" onclick="setTab(this, 1);" class="b-onair_tab-a">Прямой эфир</a>
			</li>
			<li class="b-onair_tab-li">
				<a href="javascript:void(0);" onclick="setTab(this, 2);" class="b-onair_tab-a"><span class="icon-status "></span> Друзья</a>
			</li>
		</ul>
	</div>
	<div class="b-onair_cont tab-box tab-box-1" style="display:block;">
		<div class="scroll">
			<div class="scroll_scroller">
				<div class="b-onair_hold">
					<ul class="b-onair_news-hold">
						<li class="b-onair_news b-onair_news__new">
							<div class="clearfix">
								<span class="ico-status ico-status__online"></span>
								<a href="" class="ava-name">Света</a>
								<span class="font-smallest color-gray">1 мин. назад</span>
							</div>
							<a href="" class="b-onair_news-t">Леденцы от кашля детям - делаем сами!</a>
							<a href="" class="b-onair_news-receptacle">Дети старше года</a>
						</li>
						<li class="b-onair_news">
							<div class="clearfix">
								<span class="ico-status ico-status__online"></span>
								<a href="" class="ava-name">Света</a>
								<span class="font-smallest color-gray">1 мин. назад</span>
							</div>
							<div class="clearfix">
								<a href="" class="b-onair_news-t">Как сохранить страсть</a>
							</div>
							<a href="" class="b-onair_news-receptacle">Дети старше года</a>
						</li>
						<li class="b-onair_news">
							<div class="clearfix">
								<span class="ico-status ico-status__online"></span>
								<a href="" class="ava-name">Елизаветушка</a>
								<span class="font-smallest color-gray">1 мин. назад</span>
							</div>
							<div class="clearfix">
								<a href="" class="b-onair_news-t">Как сохранить страсть</a>
							</div>
							<a href="" class="b-onair_news-receptacle">Дети старше года</a>
						</li>
						<li class="b-onair_news">
							<div class="clearfix">
								<span class="ico-status ico-status__online"></span>
								<a href="" class="ava-name">Света</a>
								<span class="font-smallest color-gray">1 мин. назад</span>
							</div>
							<div class="clearfix">
								<a href="" class="b-onair_news-t">Как сохранить страсть</a>
							</div>
							<a href="" class="b-onair_news-receptacle">Дети старше года</a>
						</li>
						<li class="b-onair_news">
							<div class="clearfix">
								<span class="ico-status ico-status__online"></span>
								<a href="" class="ava-name">Никодим</a>
								<span class="font-smallest color-gray">10 сен 2013</span>
							</div>
							<div class="clearfix">
								<a href="" class="b-onair_news-t">Как сохранить страсть</a>
							</div>
							<a href="" class="b-onair_news-receptacle">Дети старше года</a>
						</li>
						<li class="b-onair_news">
							<div class="clearfix">
								<span class="ico-status ico-status__online"></span>
								<a href="" class="ava-name">Никодим</a>
								<span class="font-smallest color-gray">10 сен 2013</span>
							</div>
							<div class="clearfix">
								<a href="" class="b-onair_news-t">Как сохранить страсть</a>
							</div>
							<a href="" class="b-onair_news-receptacle">Дети старше года</a>
						</li>
						
					</ul>
				</div>
			</div>
			<div class="scroll_bar-hold">
	            <div class="scroll_bar">
	            	<div class="scroll_bar-in"></div>
	            </div>
	        </div>
        </div>
	</div>
	<div class="b-onair_cont tab-box tab-box-2">
		<div class="scroll">
			<div class="scroll_scroller">
				<div class="b-onair_hold">
					<ul class="b-onair_-hold">
						<li class="b-onair_news b-onair_news__new">
							<div class="clearfix">
								<span class="ico-status ico-status__online"></span>
								<a href="" class="ava-name">Света</a>
								<span class="font-smallest color-gray">1 мин. назад</span>
							</div>
							<a href="" class="b-onair_news-t">Леденцы от кашля детям - делаем сами!</a>
							<a href="" class="b-onair_news-receptacle">Дети старше года</a>
						</li>
						
					</ul>
				</div>
			</div>
			<div class="scroll_bar-hold">
	            <div class="scroll_bar">
	            	<div class="scroll_bar-in"></div>
	            </div>
	        </div>
        </div>
	</div>
	<div class="b-onair_bottom">
		<a href="" class="font-small">Весь прямой эфир </a>
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