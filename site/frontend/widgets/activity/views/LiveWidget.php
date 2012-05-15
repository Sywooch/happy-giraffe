<h1>Прямой эфир</h1>

<ul id="contents_live">
    <?php foreach ($live as $l): ?>
        <?php $this->render('_live_entry', array('data' => $l)); ?>
    <?php endforeach; ?>
</ul>