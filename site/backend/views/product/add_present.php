<?php
/**
 * @var $model Product
 */
?>
<div class="items_table" id="present_items">
    <table>
        <caption>Выбор товара</caption>
        <thead>
            <tr>
                <th>Название товара</th>
                <th>
                    <select id="change_presents_category">
                        <option value="0">Категория</option>
                        <?php
                        $ct = new CDbCriteria;
                        $ct->order = 'category_lft';
                        $categories = Category::model()->findByPk(1)->descendants()->findAll($ct);
                        foreach($categories as $cat): ?>
                            <option value="<?php echo $cat->primaryKey; ?>"><?php echo str_repeat('&nbsp;&nbsp;', $cat->category_level - 2) . $cat->category_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script type="text/javascript">
    if(typeof init_items_shower != undefined) {
        var init_items_shower;
        $('#present_items').on('click', 'a.show_items', function() {
            var items = $(this).parent().parent().next().toggle();
            return false;
        });
        $('#change_presents_category').change(function() {
            var value = $(this).val();
            if(value == 0)
                return true;
            $.post('/product/getPresents/', {category:value}, function(data) {
                $('#present_items > table > tbody').html(data);
            });
        });
    }
</script>