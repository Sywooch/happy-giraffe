<?php
/* @var $this Controller
 * @var $date int
 */
$user_children = User::GetCurrentUser()->babies;
if (empty($user_children))
    $baby_id = null;
else
    $baby_id = $user_children[0]->id;
?>
<style type="text/css">
    a.active {
        color: red;
    }
    .wid100 {
    width: 100px !important; /* !important обязателен */
    }

</style>

<script type="text/javascript">
    baby_id = <?php echo $baby_id ?>;

    $(function() {
        $('div.tabs-headers li a').click(function(){
            if ($(this).attr('rel') == undefined){
                HideAllTabs();
                $('.tabs .empty-vaccine-date').show();
                baby_id = null;
                cuSelRefresh({refreshEl: "#month-,#day-,#year-",visRows: 5,scrollArrows: true});
            }else{
                HideAllTabs();
                $('.tabs .vaccine-date-'+$(this).attr('rel')).show();
                baby_id = $(this).attr('rel');
                cuSelRefresh({refreshEl: "#month-"+baby_id+",#day-"+baby_id+",#year-"+baby_id,visRows: 5,scrollArrows: true});
            }
            return false;
        });
    });

    function HideAllTabs(){
        $('.tabs li').hide();
    }


    $(function() {
        $('body').delegate('a.decline','click',function(){
            if (!$(this).hasClass('active') && baby_id !== null){
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("/vaccineCalendar/default/vote") ?>",
                    data: {vote:1,id:$(this).attr('rel'),baby_id:baby_id},
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.hasOwnProperty('success') && data.success){
                            $('.vc-'+$(this).attr('rel')+$(this).attr('baby')+' a').removeClass('active');
                            if (!$(this).hasClass("active"))
                                $(this).addClass("active");
                        }
                    },
                    'context': $(this)
                });
            }
            return false;
        });
        $('body').delegate('a.agree','click',function(){
            if (!$(this).hasClass('active') && baby_id !== null){
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("/vaccineCalendar/default/vote") ?>",
                    data: {vote:2,id:$(this).attr('rel'),baby_id:baby_id},
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.hasOwnProperty('success') && data.success){
                            $('.vc-'+$(this).attr('rel')+$(this).attr('baby')+' a').removeClass('active');
                            if (!$(this).hasClass("active"))
                                $(this).addClass("active");
                        }
                    },
                    'context': $(this)
                });
            }
            return false;
        });
        $('body').delegate('a.did','click',function(){
            if (!$(this).hasClass('active') && baby_id !== null){
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("/vaccineCalendar/default/vote") ?>",
                    data: {vote:3,id:$(this).attr('rel'),baby_id:baby_id},
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.hasOwnProperty('success') && data.success){
                            $('.vc-'+$(this).attr('rel')+$(this).attr('baby')+' a').removeClass('active');
                                $(this).addClass("active");
                        }
                    },
                    'context': $(this)
                });
            }
            return false;
        });
    });
</script>

<div class="tabs-headers">
    <ul>
        <?php foreach($user_children as $baby):?>
            <li class="vaccine-date-<?php echo $baby->id ?>"><a href="#" rel="<?php echo $baby->id ?>"><?php echo $baby->name ?></a></li>
        <?php endforeach ?>
        <li class="empty-vaccine-date"><a href="#">Укажите дату рождения</a></li>
    </ul>
</div>
<ul class="tabs">
    <?php foreach($user_children as $baby):?>
        <li class="vaccine-date-<?php echo $baby->id ?>" <?php if ($baby_id != $baby->id) echo 'style="display:none;"'?> >
            <?php $this->renderPartial('_view',array('baby'=>$baby)); ?>
        </li>
    <?php endforeach ?>

    <li class="empty-vaccine-date" <?php if ($baby_id !== null) echo 'style="display:none;"'?> >
        <?php $this->renderPartial('_view',array('baby'=>null)); ?>
    </li>
</ul>