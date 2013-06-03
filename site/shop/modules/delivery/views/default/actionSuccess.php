ПОЗДРАВЛЯЮ!<br></br>

Заказ № <?php echo $model->order_id ?><br></br>

Доставляется с помощью: <?php echo $this->module->components[$model->delivery_name]['show_name'];?><br></br>

Стоимость доставки: <?php echo $model->delivery_cost; ?><br></br>

<?php echo $formDelivery;?>