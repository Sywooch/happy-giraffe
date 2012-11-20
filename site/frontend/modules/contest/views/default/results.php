<?php
    if ($this->contest->id == 1) {
        $prizes = array(
            '1' => array(
                'title' => 'Мультиварка',
                'model' => 'Land Life YBW60-100A1',
            ),
            '2' => array(
                'title' => 'Мультиварка',
                'model' => 'BRAND 37501',
            ),
            '3' => array(
                'title' => 'Мультиварка',
                'model' => 'Land Life YBD60-100A',
            ),
            '4' => array(
                'title' => 'Мультиварка',
                'model' => 'Polaris PMC 0506AD',
            ),
            '5' => array(
                'title' => 'Мультиварка',
                'model' => 'SUPRA MCS-4501',
            ),
        );
    } elseif ($this->contest->id == 2) {
        $prizes = array(
            '1' => array(
                'title' => 'Фотоаппарат',
                'model' => 'SONY Cyber-shot DSC-HX10',
            ),
            '2' => array(
                'title' => 'Фоторамка',
                'model' => 'SONY DPF-D830LB 8"',
            ),
            '3' => array(
                'title' => 'Фоторамка',
                'model' => 'SONY DPF-D830LB 8"',
            ),
        );
    }
?>

<?php
    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.img > a',
        'entity' => 'Contest',
        'entity_id' => $this->contest->id,
        'entity_url' => $this->contest->url,
        'query' => array('sort' => 'rate'),
    ));

    Yii::app()->eauth->renderWidget(array(
        'mode' => 'assets',
    ));
?>

<div class="contest-about clearfix">
    <div class="content-title">Победители конкурса</div>
    <?=$this->contest->results_text?>
    <div class="contest-winners">
        <div class="contest-winners_holder">
            <div class="contest-winners_frame clearfix">
                <ul class="contest-winners_list clearfix">
                    <?php foreach ($this->contest->winners as $w): ?>
                        <?php $this->renderPartial('_winner', array('data' => $w, 'prize' => $prizes[$w->place])); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>