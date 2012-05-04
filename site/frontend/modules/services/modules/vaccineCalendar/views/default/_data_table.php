<?php if ($date !== null)
    $this->widget('site.frontend.widgets.vaccineWidget.VaccineWidget', array(
        'date' => $date,
        'baby_id' => $baby_id
    ));
?>