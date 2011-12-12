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
</style>
<script type="text/javascript">
    $(function () {
        //blood refresh
        $('body').delegate('#blood-refresh-prev-month', 'click', function () {
            var month = $('#blood_refr_review_month').val();
            var year = $('#blood_refr_review_year').val();
            month--;
            if (month == 0) {
                month = 12;
                year--;
                $('#blood_refr_review_year').val(year);
            }
            $('#blood_refr_review_month').val(month);
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/babySex/default/bloodUpdate") ?>",
                data:$("#blood-refresh-form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#blood-update-result").html(data);
                }
            });
        });

        $('body').delegate('#blood-refresh-next-month', 'click', function () {
            var month = $('#blood_refr_review_month').val();
            var year = $('#blood_refr_review_year').val();
            month++;
            if (month == 13) {
                month = 1;
                year++;
                $('#blood_refr_review_year').val(year);
            }
            $('#blood_refr_review_month').val(month);
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/babySex/default/bloodUpdate") ?>",
                data:$("#blood-refresh-form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#blood-update-result").html(data);
                }
            });
        });

        //blood link
        $('#blood-group-link').click(function () {
            var mg = parseInt($('#mother_blood_group').val());
            var fg = parseInt($('#father_blood_group').val());
            var sum = mg + fg;
            console.log(sum);
            if (sum % 2 == 0) {
                $('#blood-group-result').html('Девочка');
            } else {
                $('#blood-group-result').html('Мальчик');
            }
        });

        //japan calendar
        $('body').delegate('#japan-prev-month', 'click', function () {
            var month = $('#japan_review_month').val();
            month--;
            if (month == 0) {
                month = 12;
            }
            $('#japan_review_month').val(month);
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/babySex/default/japan") ?>",
                data:$("#japan-form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#japan-result").html(data);
                }
            });
        });

        $('body').delegate('#japan-next-month', 'click', function () {
            var month = $('#japan_review_month').val();
            month++;
            if (month == 13) {
                month = 1;
            }
            $('#japan_review_month').val(month);
            $.ajax({
                url:"<?php echo Yii::app()->createUrl("/babySex/default/japan") ?>",
                data:$("#japan-form").serialize(),
                type:"POST",
                success:function (data) {
                    $("#japan-result").html(data);
                }
            });
        });

        $('body').delegate('#japan-submit', 'click', function(){
            $("#japan_review_month").val($("#japan-conception-m").val());
            $.ajax({
                url: "<?php echo Yii::app()->createUrl("/babySex/default/japan") ?>",
                data: jQuery(this).parents("form").serialize(),
                type: "POST",
                success: function(data) {
                    $("#japan-result").html(data);
                }
            });
        })
    });
</script>
<?php //$this->renderPartial('blood_refresh'); ?>
<br>
<?php //$this->renderPartial('blood_group'); ?>
<br>
<?php //$this->renderPartial('china'); ?>
<br>
<?php $this->renderPartial('japan'); ?>
