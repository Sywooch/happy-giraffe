<div><?= ParsingKeyword::model()->count() ?> слов в очереди на пасинг</div>
<div><?= ParsedKeywords::model()->count() ?> слов прошло парсинг</div>
Введите ключевое слово для парсинга Wordstat <input type="text" size="50">
<a href="javascript:;" onclick="WordStat.addKeyword(this);">спарсить все c этим словом</a><br>
<a href="javascript:;" onclick="WordStat.addCompetitors()">добавить фразы конкурентов</a><br>
<a href="javascript:;" onclick="WordStat.clearKeywords()">очистить список</a>