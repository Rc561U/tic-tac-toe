<?php
// $arr = array('o', 'null','null',
//              'null','null','x',
//              'null','null','null');

//$arr = $_POST['array'];
// for ($i = 0; $i <= 6; $i+=3){
//     echo $arr[$i]." ".$arr[$i+1]." ".$arr[$i+2];
//     echo "<br>";
// }
$post = json_decode(file_get_contents('php://input'), true);
$jsonData = $post['jsonData'];

$arr = $jsonData['data'];

function getRandomBotChoice(){
    global $arr;
    $tempArr = [];
    for($i = 0; $i < 9; $i++){
      if ($arr[$i] === 'null'){
        array_push($tempArr, $i);
        }
    }
    $randomArrayValue =  $tempArr[array_rand($tempArr)];
    return $randomArrayValue;
    
}   
// echo $arr[getRandomBotChoice()].' '.getRandomBotChoice();

function concat($a,$b,$c){
    global $arr;
    $result = $arr[$a].$arr[$b].$arr[$c]; 
    
    if ($result === "xxx" || $result === "ooo"){
        return $result;
    }
    
    switch ($result){
        case "xxnull":
            return ["x", $c];
            
        case "xnullx":
            return ["x", $b];
            
        case "nullxx":
            return ["x", $a];
            
        case "oonull":
            return ["o", $c];
            
        case "onullo":
            return ["o", $b];
            
        case "nulloo":
            return ["o", $a];
    }
    return 'Nothing'; 
}
//echo "<br>";
// echo concat(0,1,2)[1];
// echo "<br>";

function getBotSelect(){
    global $arr;
    //проверка комбинаций из двух "xx"
    //vertival check
    
    //проверка комбинаций из двух "oo"
    //vertival check
    for ($i = 0; $i < 3; $i++){
        $result = concat($i, $i + 3, $i + 6);
        
        if ($result[0] === 'o'){
            $arr[$result[1]] = 'o';
            return $result[1] ;
        }
    }

    //horizontal check
    for ($i = 0; $i <= 6; $i +=3){
            $result = concat($i, $i + 1, $i + 2);
        
        if ($result[0] === 'o'){
            $arr[$result[1]] = 'o';
            return $result[1] ;
        }
    }
    // diagonal check
    $result = concat(0, 4, 8);
    if ($result[0] === 'o'){
        $arr[$result[1]] = 'o';
        return $result[1];
    }
    // //diagonal check reverse
    $result = concat(2, 4, 6);
    if ($result[0] === 'o'){
        $arr[$result[1]] = 'o';
        return $result[1];
    }
    for ($i = 0; $i < 3; $i++){
        $result = concat($i, $i + 3, $i + 6);
        
        if ($result[0] === 'x'){
            $arr[$result[1]] = 'o';
            return $result[1] ;
        }
    }

    //horizontal check
    for ($i = 0; $i <= 6; $i +=3){
            $result = concat($i, $i + 1, $i + 2);
        
        if ($result[0] === 'x'){
            $arr[$result[1]] = 'o';
            return $result[1] ;
        }
    }
    // diagonal check
    $result = concat(0, 4, 8);
    if ($result[0] === 'x'){
        $arr[$result[1]] = 'o';
        return $result[1] ;
    }
    // //diagonal check reverse
    $result = concat(2, 4, 6);
    if ($result[0] === 'x'){
        $arr[$result[1]] = 'o';
        return $result[1] ;
    }
    // random

    $randomBotCoice = getRandomBotChoice();
    $arr[$randomBotCoice] = 'o';
    return $randomBotCoice;

}

// echo getBotSelect();
// for ($i = 0; $i <= 6; $i+=3){
//     echo "<br>";
//     echo $arr[$i]." ".$arr[$i+1]." ".$arr[$i+2];
    
// }

$resultatus = getBotSelect();

echo json_encode($resultatus);

