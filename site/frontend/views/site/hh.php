<table>
    <thead>
        <tr>
            <td>ФИО</td>
            <td>Возраст</td>
            <td>Оклад</td>
            <td>Город</td>
            <td>Контакты</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $r): ?>
            <?php foreach ($r as $cell): ?>
                <td>
                    <?=$cell?>
                </td>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>