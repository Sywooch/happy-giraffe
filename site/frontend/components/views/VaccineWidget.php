<?php
/** @var $data VaccineData
 * @var $date int
 * @var $baby Baby
 */

if (!empty($baby))
    $baby_id = $baby->id;
else
    $baby_id = '';
?>
<table>
    <thead>
    <tr>
        <th>Рекомендуемая дата</th>
        <th>Возраст</th>
        <th>Наименование прививки</th>
        <th>Прививка</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($data->vaccineDates as $day): ?>
        <tr>
            <?php if (count($day->recommendDate) == 1):?>
                <td><?php echo $day->recommendDate[0]['year'].'<br>'.$day->recommendDate[0]['month'].'<br>'.$day->recommendDate[0]['day'] ?></td>
            <?php else: ?>
                <?php if (isset($day->recommendDate[0])):?>
                <td><?php echo $day->recommendDate[1]['year'].'<br>'.$day->recommendDate[1]['month'].'<br>'.$day->recommendDate[0]['day'].'-'.$day->recommendDate[1]['day'] ?></td>
                <?php else: ?>
                    <td><?php //echo var_dump($day->recommendDate) ?></td>
                <?php endif ?>
            <?php endif ?>
            <td><?php echo $day->age ?></td>
            <td><?php echo $day->GetText() ?></td>
            <td><?php echo CHtml::link($day->vaccine->name, '#') ?></td>
        </tr>
<?php if (!empty($baby_id)):?>
            <tr>
                <td></td>
                <td colspan="3" class="<?php echo 'vc-'.$day->id.$baby_id ?>">
                    <?php $user_vote = $day->GetUserVote($baby) ?>
                    <?php echo CHtml::link('Отказываемся','#',array('rel'=> $day->id,'baby'=> $baby_id,
                            'class'=>($user_vote == VaccineDate::VOTE_DECLINE)?'decline active':'decline')) ?>
                    <span class="count"><?php echo $day->vote_decline ?></span>
                    <?php echo $day->DeclinePercent() ?>%<br>
                    <?php echo CHtml::link('Собираемся делать','#',array('rel'=> $day->id,'baby'=> $baby_id,
                            'class'=>($user_vote == VaccineDate::VOTE_AGREE)?'active agree':'agree')) ?>
                    <span class="count"><?php echo $day->vote_agree ?></span>
                    <?php echo $day->AgreePercent() ?>%<br>
                    <?php echo CHtml::link('Уже сделали','#',array('rel'=> $day->id,'baby'=> $baby_id,
                            'class'=>($user_vote == VaccineDate::VOTE_DID)?'active did':'did')) ?>
                    <span class="count"><?php echo $day->vote_did ?></span>
                    <?php echo $day->DidPercent() ?>%<br><br><br>
                </td>
            </tr>

<?php endif ?>    <?php endforeach; ?>
    </tbody>
</table>