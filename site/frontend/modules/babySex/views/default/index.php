<style type="text/css">
    input {
        border: 1px solid #000;
    }

    table td.boy {
        background: #0babd9;
    }

    table td.girl {
        background: #d921cc;
    }

    table.calendar-table {
        border-collapse: separate;
        border-spacing: 5px;
    }

    .sex-test-table-boy div {
        height: 20px;
        width: 30px;
        background: #0babd9;
        margin-right: 10px;
    }

    .sex-test-table-cur-boy {
        border: 3px solid #000;
    }

    .sex-test-table-girl div {
        height: 20px;
        width: 30px;
        margin-right: 10px;
        background: #d921cc;
    }

    .sex-test-table-cur-girl {
        border: 3px solid #000;
    }
    #china-calendar-result{
        margin: 30px 0;
    }

    #china-calendar-result .boy {
        width: 30px;
        height: 30px;
        float: left;
        background: #0babd9;
        margin: 5px;
    }

    #china-calendar-result .girl {
        width: 30px;
        height: 30px;
        float: left;
        margin: 5px;
        background: #d921cc;
    }

    #japan-result table td {
        width: 30px;
        height: 30px;
    }
</style>

<?php $this->renderPartial('blood_refresh'); ?>
<br>
<?php //$this->renderPartial('blood_group'); ?>
<br>
<?php //$this->renderPartial('china'); ?>
<br>
<?php //$this->renderPartial('japan'); ?>
