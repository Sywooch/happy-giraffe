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
    } elseif ($this->contest->id == 3) {
        $prizes = array(
            '1' => array(
                'title' => 'Full HD-видеокамера',
                'model' => 'Samsung HMX-Q10',
            ),
            '2' => array(
                'title' => 'Настольная игра',
                'model' => '&laquo;Монополия&raquo;',
            ),
            '3' => array(
                'title' => 'Настольная игра',
                'model' => '&laquo;Имаджинариум&raquo;',
            ),
            '4' => array(
                'title' => 'Настольная игра',
                'model' => '&laquo;Элиас&raquo;',
            ),
            '5' => array(
                'title' => 'Настольная игра',
                'model' => '&laquo;Футбол&raquo;',
            ),
        );
    } elseif ($this->contest->id == 4) {
        $prizes = array(
            '1' => array(
                'title' => 'Детский надувной бассейн',
                'model' => 'Intex «Easy Set»',
            ),
            '2' => array(
                'title' => 'Детский надувной бассейн',
                'model' => 'Intex «Easy Setk»',
            ),
            '3' => array(
                'title' => 'Детский надувной бассейн',
                'model' => 'Intex «Жираф»',
            ),
            '4' => array(
                'title' => 'Термометр для воды и воздуха',
                'model' => 'Avent Philips SCH 550',
            ),
            '5' => array(
                'title' => 'Термометр для воды и воздуха',
                'model' => 'Avent Philips SCH 550',
            ),
        );
    } elseif ($this->contest->id == 5) {
        $prizes = array(
            '1' => array(
                'title' => 'Увлажнитель воздуха',
                'model' => 'TIGEX',
            ),
            '2' => array(
                'title' => 'Радионяня',
                'model' => '«Я расту» WT-448',
            ),
            '3' => array(
                'title' => 'Радионяня',
                'model' => '«Я расту» WT-448',
            ),
        );
    } elseif ($this->contest->id == 6) {
        $prizes = array(
            '1' => array(
                'title' => 'Детские электронные весы',
                'model' => 'LAICA PS3003 (Италия)',
            ),
            '2' => array(
                'title' => 'Мини-блендер',
                'model' => 'Philips AVENT SCF 860/22',
            ),
            '3' => array(
                'title' => 'Мини-комбайн',
                'model' => 'Maman ЕС01М',
            ),
            '4' => array(
                'title' => 'Салфетка-игрушка',
                'model' => 'Nuk',
            ),
            '5' => array(
                'title' => 'Салфетка-игрушка',
                'model' => 'Nuk',
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
                        <?php $this->renderPartial('_winner', array('data' => $w, 'prize' => $prizes[$w->place], 'isConsolationPrize' => $this->contest->id == 6 && ($w->place == 4 || $w->place == 5))); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>