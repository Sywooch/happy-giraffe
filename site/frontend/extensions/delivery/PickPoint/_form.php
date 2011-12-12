<br>
<label class="indent">
	Выберите адрес постамата доставки:<br />
	<!-- это пустой контейнер для вывода пользователю названия точки и ее адреса -->
	<div id="address"></div>
	<script type="text/javascript">
		var options = new Object();
		options.city = "<?php echo $orderCity; ?>";
		options.notLink = true;
	</script>
	<a href="javascript:void(0);" onclick="PickPoint.open(my_function, options);return false">Выбрать</a>

	<!-- в это поле поместится ID постамата или пункта выдачи -->
	<input type="hidden" name="pickpoint_id" id="pickpoint_id" value="" /><br /><br />
</label>
<script type="text/javascript">  
    function my_function(result){
		// устанавливаем в скрытое поле ID терминала
		document.getElementById('pickpoint_id').value=result['id'];
			
		// показываем пользователю название точки и адрес доствки			
		document.getElementById('address').innerHTML=result['name']+'<br />'+result['address'];
			
		var res = result['address'].split(",");					
		document.getElementById('EPickPoint_pickpoint_address').value = result['address'];		    
		document.getElementById('EPickPoint_pickpoint_city').value = res[2];
		document.getElementById('EPickPoint_pickpoint_id').value = result['id'];
    }
    
</script>