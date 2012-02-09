<div class="like-block clearfix">

    <div class="tip">
        <div class="container">
            <i class="icon-question"></i>

            <div class="text">
                <big>Рейтинг статьи</big>

                <p>Как правило, кроватку новорождому приобретают незадолго до его появления на свет. При этом многие
                    молодые родители обращают внимание главным образом на ее внешний вид.</p>

                <p>Как правило, кроватку новорождому приобретают незадолго до его появления на свет. При этом многие
                    молодые родители обращают внимание главным образом на ее внешний вид.</p>
            </div>
        </div>
    </div>

    <div class="clearfix">
        <div class="rating">
            <span><?php echo Rating::countByEntity($this->model) ?></span><br/>рейтинг
        </div>
        <div class="title">Вам полезна статья? Отметь!</div>
    </div>

    <table class="like-buttons">
        <tr>
            <td rowspan="2" width="220">
                <div class="hg-like">
                    <button class="btn btn-green-smedium"><span><span>+2</span></span></button>
                    <div class="count">2 563</div>
                </div>
            </td>
            <td height="52">кнопка</td>
            <td height="52">кнопка</td>
            <td height="52">кнопка</td>
        </tr>
        <tr>
            <td style="padding-top:15px;">кнопка</td>
            <td style="padding-top:15px;">кнопка</td>
            <td style="padding-top:15px;">кнопка</td>
        </tr>

    </table>

</div>
<?php
foreach ($this->providers as $provider => $options)
{
    if($provider == 'yh')
    $this->render('_' . $provider, array(
        'options' => $options,
    ));
}
?>