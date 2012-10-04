<div class="linking-filter tabs">
    <div class="nav">
        <a href="javascript:;" class="toggle" onclick="ShowHide(this, 'linking_settings', 'Показать', 'Свернуть')">Показать</a>
        <ul>
            <li<?php if (SeoUserAttributes::getAttribute('se_tab') == 1) echo ' class="active"'?>><a href="javascript:void(0)" onclick="setTab(this, 1);"><i class="icon-yandex"></i> Яндекс</a></li>
            <li<?php if (SeoUserAttributes::getAttribute('se_tab') == 2) echo ' class="active"'?>><a href="javascript:void(0)" onclick="setTab(this, 2);"><i class="icon-google"></i> Google</a></li>
        </ul>
    </div>
    <div id="linking_settings" class="content" style="display:none;">
        <div class="tab-box tab-box-1"<?php if (SeoUserAttributes::getAttribute('se_tab') == 1) echo ' style="display:block;"'?>>

            <form action="">
                <input type="hidden" name="se_tab" value="1">
                <table class="table-1">
                <tbody>
                <tr>
                    <td class="col-1"><input type="text" name="min_yandex_position" value="<?=SeoUserAttributes::getAttribute('min_yandex_position') ?>"> - Позиции - </td>
                    <td class="col-2"><input type="text" name="max_yandex_position" value="<?=SeoUserAttributes::getAttribute('max_yandex_position') ?>"></td>
                    <td class="col-3" rowspan="2">
                        Тип подбора<br>
                        <input type="radio" name="yandex_sort" value="1" id="yandex_sort_2"<?php if (SeoUserAttributes::getAttribute('yandex_sort') == 1) echo ' checked' ?>>
                        <label for="yandex_sort_2">По позициям</label><br>
                        <input type="radio" name="yandex_sort" value="2" id="yandex_sort_1"<?php if (SeoUserAttributes::getAttribute('yandex_sort') == 2) echo ' checked' ?>>
                        <label for="yandex_sort_1">По частоте</label>
                    </td>
                    <td class="col-4" rowspan="2">
                        <input type="checkbox" onchange="CheckboxNext(this)"<?php if (SeoUserAttributes::getAttribute('yandex_traffic') == 1) echo ' checked' ?>>
                        <input type="hidden" name="yandex_traffic" value="<?=SeoUserAttributes::getAttribute('yandex_traffic') ?>">
                        <br><label>Только<br>с трафиком</label>
                    </td>
                    <td class="col-5" rowspan="2"><button class="btn-g" onclick="SaveSettings(this, true);return false;">Ok</button></td>
                </tr>
                <tr>
                    <td class="col-1">Минимальная частота</td>
                    <td class="col-2"><input type="text" name="wordstat_min" value="<?=SeoUserAttributes::getAttribute('wordstat_min') ?>"></td>
                </tr>

                </tbody>
            </table>

            </form>

        </div>

        <div class="tab-box tab-box-2"<?php if (SeoUserAttributes::getAttribute('se_tab') == 2) echo ' style="display:block;"'?>>

            <form action="">

                <input type="hidden" name="se_tab" value="2">

                <table class="table-2">
                    <tbody>
                    <tr>
                        <td class="col-1">Минимальная частота <input type="text" name="wordstat_min" value="<?=SeoUserAttributes::getAttribute('wordstat_min') ?>"></td>
                        <td class="col-2">Трафик из Google &nbsp;&nbsp;&nbsp;&nbsp; &gt; <input type="text" name="google_visits_min" value="<?=SeoUserAttributes::getAttribute('google_visits_min') ?>"></td>
                        <td class="col-3"><button class="btn-g" onclick="SaveSettings(this, true);return false">Ok</button></td>
                    </tr>

                    </tbody>
                </table>

            </form>

        </div>

    </div>
</div>