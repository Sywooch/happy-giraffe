<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Заголовок</title>
<?php for($i = 0; $i < 4; $i++): ?>
<p>Ответ <?=($i + 1)?>:</p>
<p><?=nl2br($answers[$i])?></p>
<?php endfor; ?>
<p>Имя, фамилия: <?=$name?></p>
<p>E-mail: <?=$email?></p>
<p>Ссылка на резюме на HeadHunter: <?=$hhLink?></p>
<p>Ссылка на GitHub: <?=$githubLink?></p>
<p>Skype: <?=$skype?></p>