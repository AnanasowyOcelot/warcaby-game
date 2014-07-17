<?php

//$area = [[[],[],[],[],[],[],[],[]],
//        [[],[],[],[],[],[],[],[]],
//        [[],[],[],[],[],[],[],[]],
//        [[],[],[],[],[],[],[],[]],
//        [[],[],[],[],[],[],[],[]],
//        [[],[],[],[],[],[],[],[]],
//        [[],[],[],[],[],[],[],[]],
//        [[],[],[],[],[],[],[],[]]];
//
//$nextMove = $_POST['nextMove'];
//
//$createArea = function ($area) {
//    for ($rowNum = 0; $rowNum <= 7; $rowNum++) {
//        for ($cellNum = 0; $cellNum <= 7; $cellNum++) {
//            if ($rowNum == 1 || $rowNum == 2) {
//                $area[$rowNum][$cellNum] = ['x' => $cellNum, 'y'=> $rowNum, 'value'=> 1];
//            } else if ($rowNum == 7 || $rowNum == 6) {
//                $area[$rowNum][$cellNum] = ['x' => $cellNum, 'y'=> $rowNum, 'value'=> 0];
//            } else {
//                $area[$rowNum][$cellNum] = ['x' => $cellNum, 'y'=> $rowNum, 'value'=> ''];
//            }
//        }
//    }
//    return $area;
//};

$conn = mysqli_connect('localhost','root','','warcabs');

mysqli_query($conn, "UPDATE game_area SET `value`='".$_POST['nextMove'][0]['value']."' WHERE `x`='".$_POST['nextMove'][1]['x']."' AND `y`='".$_POST['nextMove'][1]['x']."' ");
mysqli_query($conn, "UPDATE game_area SET `value`='".$_POST['nextMove'][1]['value']."' WHERE `x`='".$_POST['nextMove'][0]['x']."' AND `y`='".$_POST['nextMove'][0]['x']."' ");

$DbGameArea = mysqli_query($conn,"SELECT * FROM game_area ORDER BY `y` ASC, `x` ASC");

mysqli_close($conn);

$newGameArea = array();
while($row = mysqli_fetch_array($DbGameArea)) {
    if($row['y'] == 0){
        $newGameArea[0][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }
    if($row['y'] == 1){
        $newGameArea[1][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }
    if($row['y'] == 2){
        $newGameArea[2][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }
    if($row['y'] == 3){
        $newGameArea[3][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }
    if($row['y'] == 4){
        $newGameArea[4][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }
    if($row['y'] == 5){
        $newGameArea[5][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }
    if($row['y'] == 6){
        $newGameArea[6][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }
    if($row['y'] == 7){
        $newGameArea[7][] = ['x'=> intval($row['x']), 'y'=>intval($row['y']), 'value'=>($row['value'])];
    }

};

echo json_encode($newGameArea);