<a href="javascript:;" id="parse-queries" onclick="SeoModule.parseQueries();">спарсить фразы по которым заходили</a>
<div id="result"></div>
<a href="javascript:;" onclick="SeoModule.parseSearch();">парсить позиции!</a><br><br>

Со скольки кликов парсим запросы
<input type="text" value="<?=Config::getAttribute('minClicks'); ?>">
<a href="javascript:;" onclick="SeoModule.setConfigAttribute('minClicks', $(this).prev().val());">OK</a>