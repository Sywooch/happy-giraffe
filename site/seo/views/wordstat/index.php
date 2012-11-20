<div><?= ParsingKeyword::model()->count() ?> слов в очереди на пасинг</div>
<div><?= YandexPopularity::model()->count() ?> всего слов</div>
Введите ключевое слово для парсинга Wordstat <input type="text" size="50">
<a href="javascript:;" onclick="WordStat.addKeyword(this);">спарсить все c этим словом</a><br>
<a href="javascript:;" onclick="WordStat.addCompetitors()">добавить фразы конкурентов</a><br>
Поиск слова <input type="text" size="50">
<a href="javascript:;" onclick="WordStat.searchKeyword(this);">искать</a><br><br>

<textarea name="keywords" id="keywords" cols="120" rows="20"></textarea>
<a href="javascript:;" onclick="WordStat.addKeywords(this);">добавить слова</a><br>
<div id="result">

</div>
