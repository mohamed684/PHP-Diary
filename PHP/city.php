<?php 

require __DIR__ . '/inc/functions.php';

$city = null;
$fileName = null;
$cityInfo = [];

if(!empty($_GET['city'])) {
    $city = $_GET['city'];
}

if(!empty($city)) {
    $cities = json_decode(
        file_get_contents(__DIR__ . '/../data/index.json'),
        true
    );
    
    foreach($cities as $currentCity) {
        if($currentCity['city'] === $city) {
            $fileName = $currentCity['filename'];
            $cityInfo = $currentCity;
            break;
        }
    }
}

if(!empty($fileName)) {
    $results = json_decode(
        file_get_contents('compress.bzip2://' . __DIR__ . '/../data/' . $fileName),
        true
    )['results'];

    $units = [
        'pm25' => null,
        'pm10' => null
    ];

    foreach($results as $result) {
        if(!empty($units['pm25']) && !empty($units['pm10'])) break;
        if($result['parameter'] == 'pm25') {
            $units['pm25'] = $result['unit'];
        }
        if($result['parameter'] == 'pm10') {
            $units['pm10'] = $result['unit'];
        }
    }


    $stats = [];

    foreach($results as $result) {
        if($result['parameter'] !== 'pm25' && $result['parameter'] !== 'pm10') continue;
        if($result['value'] < 0) continue;

        $month = substr($result['date']['local'], 0, 7);

        if(!isset($stats[$month])) {
            $stats[$month] = [
                'pm25' => [],
                'pm10' => []
            ];
        }
        
        $stats[$month][$result['parameter']][] = $result['value'];
        
    }
}

?>

<?php include __DIR__ . '/views/header.inc.php'; ?>

<?php if(empty($city)): ?>
    <div class="notice">
        Couldn't Load the City Data
    </div>
<?php else: ?>
    
    <h1>
        <?= $cityInfo['city'] ?>
        <?= $cityInfo['flag'] ?>
    </h1>
    <?php if(!empty($stats)): ?>
        <canvas id="aqi-chart" style="width: 300px; height: 300px;"></canvas>
        <?php
            $labels = array_keys($stats);
            sort($labels);

            $pm25 = [];
            $pm10 = [];

            foreach($labels as $label) {
                $measurements = $stats[$label];
                if(count($measurements['pm25']) > 0 ) {
                    $pm25[] = array_sum($measurements['pm25']) / count($measurements['pm25']);
                } else {
                    $pm25[] = 0;
                }
                if(count($measurements['pm10']) > 0 ) {
                    $pm10[] = array_sum($measurements['pm10']) / count($measurements['pm10']);
                } else {
                    $pm10[] = 0;
                }
            }
        ?>
        <script src="scripts/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('aqi-chart');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: 
                        {
                            labels: <?php echo json_encode($labels) ?>,
                            datasets: [
                                {
                                    label: <?php echo json_encode("AQI, PM2.5, {$units['pm25']}") ?>,
                                    data: <?php echo json_encode($pm25) ?>,
                                    fill: false,
                                    borderColor: 'rgb(75, 192, 192)',
                                    tension: 0.1
                                },
                                {
                                    label: <?php echo json_encode("AQI, PM10, {$units['pm10']}") ?>,
                                    data: <?php echo json_encode($pm10) ?>,
                                    fill: false,
                                    borderColor: 'rgb(255, 0, 0)',
                                    tension: 0.1
                                }
                        ]
                        },
                });
            })

        </script>

        
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>PM 2.5 concentration</th>
                    <th>PM 10 concentration</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($stats as $month => $measurements): ?>
                    <tr>
                        <th><?= e($month) ?></th>
                        <td>
                            <?php if(count($measurements['pm25']) > 0): ?>
                                <?= e(round(array_sum($measurements['pm25']) / count($measurements['pm25']), 2)) ?>
                                <?= $units['pm25'] ?>
                            <?php else: ?>
                                <i>No Data Available</i>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if(count($measurements['pm10']) > 0): ?>
                                <?= e(round(array_sum($measurements['pm10']) / count($measurements['pm10']), 2)) ?>
                                <?= $units['pm10'] ?>
                            <?php else: ?>
                                <i>No Data Available</i>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    <?php endif ?>

<?php endif ?>

<?php include __DIR__ . '/views/footer.inc.php'; ?>