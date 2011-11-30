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

<div class="vaccination-table">
	<table>
		<colgroup>
			<col width="140" />
			<col width="170" />
			<col width="240" />
			<col />
		</colgroup>
		<thead>
			<tr>
				<td>Рекомендуемая дата</td>
				<td>Возраст ребенка</td>
				<td>Наименование прививки</td>
				<td>Вакцина</td>
			</tr>
		</thead>
		<tbody>
            <?php foreach ($data->vaccineDates as $day): ?>
			<!-- прививка --->
			<tr>
				<td>
					<div class="date">
                        <?php if (count($day->recommendDate) == 1):?>
                            <div class="y"><?php echo $day->recommendDate[0]['year'] ?></div>
                            <div class="d"><?php echo $day->recommendDate[0]['day'] ?></div>
                            <div class="m"><?php echo $day->recommendDate[0]['month'] ?></div>
                        <?php else: ?>
                            <?php if (isset($day->recommendDate[0])):?>
                            <div class="y"><?php echo $day->recommendDate[1]['year'] ?></div>
                            <div class="d"><?php echo $day->recommendDate[0]['day'].'-'.$day->recommendDate[1]['day'] ?></div>
                            <div class="m"><?php echo $day->recommendDate[1]['month'] ?></div>
                            <?php else: ?>
                                <td><?php //echo var_dump($day->recommendDate) ?></td>
                            <?php endif ?>
                        <?php endif ?>
					</div>
				</td>
                <td><?php echo $day->age ?></td>
                <td><?php echo $day->GetText() ?></td>
                <td><?php echo CHtml::link($day->vaccine->name, '#') ?></td>
			</tr>
        <?php if (!empty($baby_id)):?>
			<tr class="bottom">
				<td colspan="4" class="<?php echo 'vc-'.$day->id.$baby_id ?>">
                    <?php $user_vote = $data->GetUserVote($day->id) ?>

                    <div class="result-box">
                        <?php echo CHtml::link('<span><span>Отказываемся</span></span>','#',
                            array('rel'=> $day->id,'baby'=> $baby_id,
                                'class'=>($user_vote == VaccineDate::VOTE_DECLINE)?'decline btn btn-red-small':'decline btn btn-gray-small')) ?>
						<br/>
						<span class="red"><b><?php echo $day->vote_decline.' ('.$day->DeclinePercent().'%)' ?></b></span>
					</div>

                    <div class="result-box">
                        <?php echo CHtml::link('<span><span>Собираемся делать</span></span>','#',
                            array('rel'=> $day->id,'baby'=> $baby_id,
                                'class'=>($user_vote == VaccineDate::VOTE_AGREE)?'agree btn btn-yellow-small':'agree btn btn-gray-small')) ?>
                        <br/>
                        <span class="orange"><b><?php echo $day->vote_agree.' ('.$day->AgreePercent().'%)' ?></b></span>
					</div>

                    <div class="result-box">
                        <?php echo CHtml::link('<span><span>Уже сделали</span></span>','#',
                            array('rel'=> $day->id,'baby'=> $baby_id,
                                'class'=>($user_vote == VaccineDate::VOTE_DID)?'did btn btn-green-small':'did btn btn-gray-small')) ?>
                        <br/>
                        <span class="green"><b><?php echo $day->vote_did.' ('.$day->DidPercent().'%)' ?></b></span>
					</div>

				</td>
			</tr>
        <?php endif ?>
			<!-- /прививка --->
            <?php endforeach; ?>
		</tbody>

	</table>

	<div class="a-right table-actions">
		<a href="" title="Распечатать"><img src="/images/icon_print.png" /></a>
		<a href="" title="Скачать в формате PDF"><img src="/images/icon_pdf.png" /></a>
	</div>

</div>