<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Livinternet stats</title>
    <link rel="stylesheet" href="/sort2/css/demo_table.css"/>
    <link rel="stylesheet" href="/sort2/css/demo_page.css"/>
</head>
<body id="dt_example">
<div id="container">
    <h1>Статистика сайта за 2011 го</h1>
    <div id="demo">
        <div class="dataTables_wrapper">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th><h3><?php echo 'Ключевое слово' ?></h3></th>
                    <!--        <td>-->
                    <?php //echo CHtml::link('суммарно, <br>запросов', '#', array('class'=>'active')); ?><!--</td>-->
                    <!--        <td>--><?php //echo CHtml::link('средн., <br>запросов', '#'); ?><!--</td>-->
                    <th><h3><?php echo 'всего'; ?></h3></th>
                    <th><h3><?php echo 'средн' ?></h3></th>
                    <?php foreach (array_reverse(HDate::ruShortMonths()) as $month): ?>
                    <!--            <td>--><?php //echo CHtml::link($month, '#'); ?><!--</td>-->
                    <th><h3><?php echo $month ?></h3></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($keywords as $keyword): ?>
                <tr>
                    <td class="keyword"><?php echo $keyword->name ?></td>
                    <td><?php echo $keyword->GetSummStats() ?></td>
                    <td><?php echo $keyword->GetAverageStats() ?></td>
                    <?php for ($i = 12; $i >= 1; $i--) {
                    $val = $keyword->GetMonthStats($i);
                    echo "<td>" . $val . "</td>";
                } ?>
                </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="/sort2/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#example').dataTable({
            "aoColumnDefs":[
                { "asSorting":[ "desc" ], "aTargets":[ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ] },
                { "asSorting":[ ], "aTargets":[ 1 ] }
            ],
            "aaSorting":[
                [ 2, "desc" ]
            ],
            "sPaginationType":"full_numbers"
        });
    });
</script>