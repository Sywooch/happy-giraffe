<h1>Единицы измерения</h1>

    <div class="form">
<form id="ingredientUnits" action="<?=CHtml::normalizeUrl(array("cookIngredients/saveUnits", "id" => $model->id))?>">
    <table class="iform units">
        <tr>
            <th>&nbsp;</th>
            <th>ед. изм.</th>
            <th>вес</th>
        </tr>
        <?php
        $units = CookUnit::model()->findAll(array('order' => 'type'));
        $iUnits = $model->getUnits();
        $iUnitsIds = $model->getUnitsIds();

        foreach ($units as $unit) {
            $active = (in_array($unit->id, $iUnitsIds)) ? 'checked="checked"' : '';
            $weight = (in_array($unit->id, $iUnitsIds)) ? $iUnits[$unit->id]['weight'] : '';
            echo '<tr>';
            echo '<td><input name="units[' . $unit->id . '][cb]" type="checkbox" value="' . $unit->id . '" ' . $active . '></td>';
            echo '<td>' . $unit->title . '</td>';
            if ($unit->type == 'qty') {
                echo '<td><input name="units[' . $unit->id . '][weight]" type="text" value="' . $weight . '"></td>';
            } else {
                echo '<td><input name="units[' . $unit->id . '][dummy]" type="hidden" value=""></td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
    <input type="submit" value="сохранить" onclick="Units.save(event);">
</form>
    </div>