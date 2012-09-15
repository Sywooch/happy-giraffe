<?php
/* @var $this Controller
 * @var $models ELLink[]
 */
?><div class="seo-table">

    <div class="table-title">Ожидают проверки</div>

    <div class="table-box table-grey">
        <table>
            <colgroup>
                <col>
                <col width="350">
                <col width="250">
            </colgroup>
            <thead>
            <tr>
                <th>Внешний сайт - адрес страницы</th>
                <th>Наш сайт - адрес статьи / сервиса</th>
                <th class="ac">Наличие ссылки</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($models as $model): ?>
            <tr>
                <td style="vertical-align: top;"><a href="<?=$model->url?>" target="_blank"><?=$model->getUrlWithEmphasizedHost() ?></a></td>
                <td><a href="<?=$model->our_link?>" target="_blank"><?=$model->our_link?></a><br><?=$model->getPageTitle() ?></td>
                <td class="ac">
                    <a href="javascript:;" class="btn-g small" onclick="ExtLinks.Checked(this, <?=$model->id?>, 1)">Ссылка есть</a>
                    &nbsp;
                    <a href="javascript:;" class="btn-g orange small" onclick="ExtLinks.Checked(this, <?=$model->id?>, 0)">Ссылка удалена</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>