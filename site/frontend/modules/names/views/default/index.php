<script type="text/javascript">
    var gender;
    var letter;
    var page;

    $(function () {

        $('a.letter-link').click(function () {
            letter = $(this).attr('rel');

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/index") ?>',
                data:{
                    letter:letter,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('a.letter-link').removeClass('active');
                    $(this).addClass('active');
                    $('#result').html(data);
                },
                context:$(this)
            });
            return false;
        });

        $('a.gender-link').click(function () {
            gender = $(this).attr('rel');

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/index") ?>',
                data:{
                    letter:letter,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('a.gender-link').removeClass('active');
                    $(this).addClass('active');
                    $('#result').html(data);
                },
                context:$(this)
            });
            return false;
        });

        $('body').delegate('.pagination a', 'click', function(){
            $.ajax({
                url:$(this).attr('href'),
                data:{
                    letter:letter,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('#result').html(data);
                }
            });

            return false;
        });
    });
</script>
<a class="letter-link" rel="" href="<?php echo $this->createUrl('/names/default/index', array('letter' => '')) ?>">все
    имена</a>
<a class="letter-link" rel="а" href="<?php echo $this->createUrl('/names/default/index', array('letter' => 'а')) ?>">а</a>
<a class="letter-link" rel="б" href="<?php echo $this->createUrl('/names/default/index', array('letter' => 'б')) ?>">б</a>
<a class="letter-link" rel="п" href="<?php echo $this->createUrl('/names/default/index', array('letter' => 'п')) ?>">п</a>
<br>
<a class="gender-link" rel="" href="<?php echo $this->createUrl('/names/default/index', array('gender' => '0')) ?>">all</a>
<a class="gender-link" rel="1" href="<?php echo $this->createUrl('/names/default/index', array('gender' => '1')) ?>">boys</a>
<a class="gender-link" rel="2" href="<?php echo $this->createUrl('/names/default/index', array('gender' => '2')) ?>">girls</a>
<br><br>
<div id="result">
    <?php
    $this->renderPartial('index_data', array(
        'names' => $names,
        'pages' => $pages,
    )); ?>
</div>