<?php

$area = [[[],[],[],[],[],[],[],[]],
    [[],[],[],[],[],[],[],[]],
    [[],[],[],[],[],[],[],[]],
    [[],[],[],[],[],[],[],[]],
    [[],[],[],[],[],[],[],[]],
    [[],[],[],[],[],[],[],[]],
    [[],[],[],[],[],[],[],[]],
    [[],[],[],[],[],[],[],[]]];


$createArea = function ($area) {
    for ($rowNum = 0; $rowNum <= 7; $rowNum++) {
        for ($cellNum = 0; $cellNum <= 7; $cellNum++) {
            if ($rowNum == 0 || $rowNum == 1) {
                $area[$rowNum][$cellNum] = ['x' => $cellNum, 'y'=> $rowNum, 'value'=> 1];
            } else if ($rowNum == 7 || $rowNum == 6) {
                $area[$rowNum][$cellNum] = ['x' => $cellNum, 'y'=> $rowNum, 'value'=> 0];
            } else {
                $area[$rowNum][$cellNum] = ['x' => $cellNum, 'y'=> $rowNum, 'value'=> ''];
            }
        }
    }
    return $area;
};

$newArea = $createArea($area);

$conn = mysqli_connect('localhost','root','','warcabs');

mysqli_query($conn, "DELETE FROM `game_area` WHERE 1=1");

foreach($newArea as $row){
    foreach($row as $cell){
        mysqli_query($conn,"INSERT INTO game_area (x, y, value)
VALUES ('".$cell['x']."', '".$cell['y']."','".$cell['value']."')");
    }
}

mysqli_close($conn);