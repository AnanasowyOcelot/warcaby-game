<?php


$conn = mysqli_connect('localhost', 'root', '', 'warcabs');

$turaArr = mysqli_query($conn, 'SELECT * FROM tura WHERE 1=1');
$tura = mysqli_fetch_array($turaArr)['tura'];

$getNextTura = function ($tura, $conn) {
    if ($tura == 0) {
        mysqli_query($conn, 'UPDATE tura set tura=1');
    } else if ($tura == 1) {
        mysqli_query($conn, 'UPDATE tura set tura=0');
    };
};

$dIntoArray = function ($conn) {
    $DbGameArea = mysqli_query($conn, "SELECT * FROM game_area ORDER BY `y` ASC, `x` ASC");


    $newGameArea = array();
    while ($row = mysqli_fetch_array($DbGameArea)) {
        if ($row['y'] == 0) {
            $newGameArea[0][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }
        if ($row['y'] == 1) {
            $newGameArea[1][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }
        if ($row['y'] == 2) {
            $newGameArea[2][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }
        if ($row['y'] == 3) {
            $newGameArea[3][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }
        if ($row['y'] == 4) {
            $newGameArea[4][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }
        if ($row['y'] == 5) {
            $newGameArea[5][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }
        if ($row['y'] == 6) {
            $newGameArea[6][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }
        if ($row['y'] == 7) {
            $newGameArea[7][] = ['x' => intval($row['x']), 'y' => intval($row['y']), 'value' => ($row['value'])];
        }

    }
    return $newGameArea;
};

$newGameArea = $dIntoArray($conn);

$nmFrom = $_POST['nextMove'][0];
$nmTo = $_POST['nextMove'][1];

if ($nmFrom['value'] != '' && $nmTo['value'] == '') {
    if ($tura == 0) {
        if (($nmFrom['value'] == 0 &&
            ($nmTo['x'] == $nmFrom['x'] + 1 || $nmTo['x'] == $nmFrom['x'] - 1) &&
            $nmTo['y'] == $nmFrom['y'] - 1)
        ) {

            $newGameArea[$nmTo['y']][$nmTo['x']]['value'] = $nmFrom['value'];
            $newGameArea[$nmFrom['y']][$nmFrom['x']]['value'] = $nmTo['value'];
            $getNextTura($tura, $conn);

        } else if ($nmFrom['value'] == 0 &&
            ($nmTo['x'] == $nmFrom['x'] + 2) && ($nmTo['y'] == $nmFrom['y'] - 2) && $newGameArea[$nmFrom['y'] - 1][$nmFrom['x'] + 1]['value'] == 1
        ) {
            $newGameArea[$nmTo['y']][$nmTo['x']]['value'] = $nmFrom['value'];
            $newGameArea[$nmFrom['y']][$nmFrom['x']]['value'] = $nmTo['value'];
            $newGameArea[$nmFrom['y'] - 1][$nmFrom['x'] + 1]['value'] = '';
            $getNextTura($tura, $conn);

        } else if ($nmFrom['value'] == 0 &&
            ($nmTo['x'] == $nmFrom['x'] - 2) && ($nmTo['y'] == $nmFrom['y'] - 2) && $newGameArea[$nmFrom['y'] - 1][$nmFrom['x'] - 1]['value'] == 1
        ) {
            $newGameArea[$nmTo['y']][$nmTo['x']]['value'] = $nmFrom['value'];
            $newGameArea[$nmFrom['y']][$nmFrom['x']]['value'] = $nmTo['value'];
            $newGameArea[$nmFrom['y'] - 1][$nmFrom['x'] - 1]['value'] = '';
            $getNextTura($tura, $conn);

        }
    } else if ($tura == 1) {
        if ($nmFrom['value'] == 1 &&
            ($nmTo['x'] == $nmFrom['x'] + 1 || $nmTo['x'] == $nmFrom['x'] - 1) &&
            $nmTo['y'] == $nmFrom['y'] + 1
        ) {

            $newGameArea[$nmTo['y']][$nmTo['x']]['value'] = $nmFrom['value'];
            $newGameArea[$nmFrom['y']][$nmFrom['x']]['value'] = $nmTo['value'];
            $getNextTura($tura, $conn);

        } else if ($nmFrom['value'] == 1 &&
            ($nmTo['x'] == $nmFrom['x'] - 2) && ($nmTo['y'] == $nmFrom['y'] + 2) && $newGameArea[$nmFrom['y'] + 1][$nmFrom['x'] - 1]['value'] == 0
        ) {
            $newGameArea[$nmTo['y']][$nmTo['x']]['value'] = $nmFrom['value'];
            $newGameArea[$nmFrom['y']][$nmFrom['x']]['value'] = $nmTo['value'];
            $newGameArea[$nmFrom['y'] + 1][$nmFrom['x'] - 1]['value'] = '';
            $getNextTura($tura, $conn);

        } else if ($nmFrom['value'] == 1 &&
            ($nmTo['x'] == $nmFrom['x'] + 2) && ($nmTo['y'] == $nmFrom['y'] + 2) && $newGameArea[$nmFrom['y'] + 1][$nmFrom['x'] + 1]['value'] == 0
        ) {
            $newGameArea[$nmTo['y']][$nmTo['x']]['value'] = $nmFrom['value'];
            $newGameArea[$nmFrom['y']][$nmFrom['x']]['value'] = $nmTo['value'];
            $newGameArea[$nmFrom['y'] + 1][$nmFrom['x'] + 1]['value'] = '';
            $getNextTura($tura, $conn);
        }
    }

}

mysqli_query($conn, "DELETE FROM `game_area` WHERE 1=1");


$rowNum = 0;
foreach ($newGameArea as $row) {
    $cellNum = 0;
    foreach ($row as $cell) {
        mysqli_query($conn, "INSERT INTO game_area (x, y, value) VALUES('" . $newGameArea[$rowNum][$cellNum]['x'] . "', '" . $newGameArea[$rowNum][$cellNum]['y'] . "', '" . $newGameArea[$rowNum][$cellNum]['value'] . "')");
        $cellNum++;
    }
    $rowNum++;
}

echo json_encode($newGameArea);

mysqli_close($conn);
