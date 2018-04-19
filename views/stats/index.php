<?php
/* @var $this yii\web\View */
?>
<h1>Статистика тэгов по дням</h1>

<p>
    <?= \dosamigos\chartjs\ChartJs::widget([
        'type' => 'line',
        'options' => [
            'height' => 300,
            'width' => 600
        ],
        'data' => [
            'labels' => $days,
            'datasets' => $datasets
        ]
    ]);
    ?>
</p>
