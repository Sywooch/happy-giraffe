<?php
/**
 * @var VacancyForm $form
 */
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Заголовок</title>
<?php foreach ($form->attributes as $attr => $val): ?>
<p><?=$attr?>: <?=$val?></p>
<?php endforeach; ?>