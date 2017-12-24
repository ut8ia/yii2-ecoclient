<?php

/* @var $this yii\web\View */

$this->title = 'EсoClient';
use dosamigos\chartjs\ChartJs;

?>
<div class="site-index">

    <div class="jumbotron">

        <h1><?= date('d.m.Y'); ?></h1>
        <p class="lead">Smog microparts, ppm</p>
        <?= ChartJs::widget([
            'type' => 'line',
            'options' => [
                'height' => 200,
                'width' => 400
            ],
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => "2,5 micrometers",
                        'backgroundColor' => "rgba(255,99,132,0.2)",
                        'borderColor' => "rgba(255,99,132,1)",
                        'pointBackgroundColor' => "rgba(255,99,132,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(255,99,132,1)",
                        'data' => $dust25
                    ],
                    [
                        'label' => "10 micrometers",
                        'backgroundColor' => "rgba(179,181,198,0.2)",
                        'borderColor' => "rgba(179,181,198,1)",
                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                        'data' => $dust10
                    ]
                ]
            ]
        ]);
        ?>


        <p class="lead">Air tempertature</p>

        <?= ChartJs::widget([
            'type' => 'line',
            'options' => [
                'height' => 200,
                'width' => 400
            ],
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => "Air tempertature",
                        'backgroundColor' => "rgba(159,200,240,0.2)",
                        'borderColor' => "rgba(159,200,240,1)",
                        'pointBackgroundColor' => "rgba(159,200,240,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(159,200,240,1)",
                        'data' => $temperature
                    ],
                ]
            ]
        ]);
        ?>

        <p class="lead">Air humidity</p>

        <?= ChartJs::widget([
            'type' => 'line',
            'options' => [
                'height' => 200,
                'width' => 400
            ],
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => "Air humidity",
                        'backgroundColor' => "rgba(55,199,132,0.2)",
                        'borderColor' => "rgba(55,199,132,1)",
                        'pointBackgroundColor' => "rgba(55,199,132,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(255,99,132,1)",
                        'data' => $humidity
                    ]
                ]
            ]
        ]);
        ?>
    </div>

</div>
