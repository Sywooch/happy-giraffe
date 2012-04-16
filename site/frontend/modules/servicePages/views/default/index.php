<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
This is the view content for action "<?php echo $this->action->id; ?>".
The action belongs to the controller "<?php echo get_class($this); ?>"
in the "<?php echo $this->module->id; ?>" module.
</p>
<p>
You may customize this page by editing <tt><?php echo __FILE__; ?></tt>
</p>

<form id="maternity-form">
    <table>
        <tr>
            <td>ПДР</td>
            <td><select id="day" name="day">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
            </select></td>
            <td><select id="month" name="month">
                <!--<option value="">-</option>-->
                <option value="0">Январь</option>
                <option value="1">Февраль</option>
                <option value="2">Март</option>
                <option value="3">Апрель</option>
                <option value="4">Май</option>
                <option value="5">Июнь</option>
                <option value="6">Июль</option>
                <option value="7">Август</option>
                <option value="8">Сентябрь</option>
                <option value="9">Октябрь</option>
                <option value="10">Ноябрь</option>
                <option value="11">Декабрь</option>
            </select></td>
            <td><select id="year" name="year">
                <!--<option value="">-</option>-->
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
            </select></td>
        </tr>
        <tr>
            <td>беременность</td>
            <td colspan="3"><select id="mult-pregnancy" name="mult-pregnancy">
                <option value="0">одноплодная</option>
                <option value="1">многоплодная</option>
            </select></td>
        </tr>
        <tr>
            <td>ост. отпуска дней</td>
            <td colspan="3"><input type="text" name="vacation" id="vacation" size="3"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3"><input type="submit" name="submit" id="submit" value="Рассчитать"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" id="result"></td>
        </tr>
    </table>
</form>

<script>
    $(function(){

        $('#maternity-form').bind('submit', function(event){
            maternityLeaveCount();
            event.preventDefault();
        })

        $('#maternity-form input, #maternity-form select').bind('change', function(event){
            maternityLeaveCount();
            event.preventDefault();
        })

    })

    function maternityLeaveCount(validate){
        var birth = new Date($('#year').val(), $('#month').val(), $('#day').val());

        var offset = (parseInt($('#mult-pregnancy').val())>0) ? 84 : 70 ;
        var vacation = (isNaN(parseInt($('#vacation').val()))) ? 0 : parseInt($('#vacation').val());

        var result = new Date( birth.getTime() - (86400000*(offset+vacation)));
        $('#result').text(result.toLocaleDateString());
    }


</script>