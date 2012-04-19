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
                <td><?php echo $day->vaccine->title ?></td>
			</tr>
        <?php if (!empty($baby_id)):?>
			<tr class="bottom">
				<td colspan="4" class="vc-vote">
                    <?php $w = $this->widget('VoteWidget', array(
                        'model'=>$day,
                        'template'=>
                            '<div class="result-box red">
                                <a href="#" vote="0" class="decline btn btn-gray-small{active0}"><span><span>Отказываемся</span></span></a>
                                <br/>
                                <span class="red"><b><span class="votes_decline">{vote0}</span> (<span class="decline_percent">{vote_percent0}</span>%)</b></span>
                            </div>

                            <div class="result-box yellow">
                                <a href="#" vote="1" class="agree btn btn-gray-small{active1}"><span><span>Собираемся делать</span></span></a>
                                <br/>
                                <span class="orange"><b><span class="votes_agree">{vote1}</span> (<span class="agree_percent">{vote_percent1}</span>%)</b></span>
                            </div>

                            <div class="result-box green">
                                <a href="#" vote="2" class="did btn btn-gray-small{active2}"><span><span>Уже сделали</span></span></a>
                                <br/>
                                <span class="green"><b><span class="votes_did">{vote2}</span> (<span class="did_percent">{vote_percent2}</span>%)</b></span>
                            </div>',
                        'links' => array('a.decline','a.agree', 'a.did'),
                        'result'=>array(
                            0=>array('.votes_decline','.decline_percent'),
                            1=>array('.votes_agree','.agree_percent'),
                            2=>array('.votes_did','.did_percent')
                        ),
                        'main_selector'=>'.vc-vote',
                        'depends'=>array(
                            'baby_id'=>$baby_id
                        ),
                        'all_votes'=>$data->user_votes
                    )); ?>


				</td>
			</tr>
        <?php endif ?>
			<!-- /прививка --->
            <?php endforeach; ?>
		</tbody>

	</table>

	<div class="a-right table-actions" style="display: none;">
		<a href="" title="Распечатать"><img src="/images/icon_print.png" /></a>
		<a href="" title="Скачать в формате PDF"><img src="/images/icon_pdf.png" /></a>
	</div>

</div>
<script type="text/javascript">
    <?php echo isset($w)?$w->js:''; ?>
</script>