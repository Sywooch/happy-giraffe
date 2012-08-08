<?php echo Proxy::model()->count() ?> проксей в базе
<textarea name="proxy" id="proxy" cols="30" rows="10"></textarea><br>
<a href="javascript:;" onclick="SeoModule.refreshProxy();">обновить прокси</a>
<br><br>
<a href="javascript:;" onclick="SeoModule.stopThreads();">остановить парсинг</a><br>