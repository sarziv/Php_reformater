<?php

$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], 'rb');

fileRestriction();

//Formating Type
if(isset($_POST['submit'])){
    $selected_var = $_POST['Format'];
    formatSwitch($selected_var,$file_handle);
}

//File restrictions
function fileRestriction (){
    $uploadOk = 1;
//Capping the size of the file
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.\n";
        $uploadOk = 0;
    }

//Only can upload TXT files
    if ($_FILES["fileToUpload"]["type"] !== "text/plain") {
        echo "It was not text file.\n";
        $uploadOk = 0;
    }
//Error if uploadOk is 0
    if ($uploadOk == 0) {
        echo "Sorry, your file was not reformated \n";
    }
}
//Switch for formating type
function formatSwitch($switchcase,$file_handle)
{
    switch ($switchcase) {
        case "Order_Asc":
           orderASC($file_handle);
            break;
        case "Order_Desc":
            orderDESC($file_handle);
            break;
        case "Spit_two_equal":
            splitTwo($file_handle);
            break;
        case "Spit_three_equal":
            splitThree($file_handle);
            break;
    }
}
//order ASC
function orderASC ($file_handle) {
    while (!feof($file_handle) ) {
        $line_of_text = fgets($file_handle);
        $parts = explode(',', $line_of_text);
    }
   asort($parts);
    echo "This is Ordering by Asc.\n";
        foreach ($parts as $part) {
            echo $part . " " ;
        }


}
//order DESC
function orderDESC ($file_handle) {
    while (!feof($file_handle) ) {
        $line_of_text = fgets($file_handle);
        $parts = explode(',', $line_of_text);
    }
    rsort($parts);
    echo "This is Ordering by Desc.\n";
        foreach ($parts as $part) {
            echo $part . " ";
        }

}
//Split number into two equal groups
function splitTwo($file_handle) {

    while (!feof($file_handle) ) {
        $line_of_text = fgets($file_handle);
        $Numbers = explode(',', $line_of_text);
    }
    $X  = array();
    $Y = array();

    rsort($Numbers);

    //check if array if empty and push the values
    function check_if_empty($X,$Y,$Numbers)
    {
        $k = 0;
        if (sizeof($X) || sizeof($Y) == 0) {
            if (empty($X)) {
                array_push($X, $Numbers[$k]);
                $k++;
            } else{
                array_push($Y, $Numbers[$k]);
                $k++;
            }
        }
    }
//add value to a min of the array
    function find_min($X,$Y,$Numbers) {

        for ($k = 0; $k <= sizeof($Numbers)-1; $k++) {

            check_if_empty( $X,$Y,$Numbers);

            if((array_sum($X) == array_sum($Y)))
            {
                array_push($X, $Numbers[$k]);
            }elseif(array_sum($X) <= array_sum($Y)){
                array_push($X, $Numbers[$k]);
            }else{
                array_push($Y, $Numbers[$k]);
            }
        }
        draw_result($X,$Y);
    }

    function draw_result($X,$Y)
    {
        $endline = "\n";
        $eqSign = " = ";
        $Xstring= join(',', $X);
        $Ystring= join(',', $Y);

        echo "reFormated into Two groups\n";
        echo "Group A\n";
        echo $Xstring.$eqSign.array_sum($X).$endline;
        echo "Group B\n";
        echo $Ystring.$eqSign.array_sum($Y).$endline;
    }

    find_min($X,$Y,$Numbers);
}
//Split number into three equal groups
function splitThree ($file_handle) {

    while (!feof($file_handle) ) {
        $line_of_text = fgets($file_handle);
        $Numbers = explode(',', $line_of_text);
    }
    $X  = array();
    $Y = array();
    $Z = array();

    rsort($Numbers);

    //check if array if empty and push the values
    function check_if_empty($X,$Y,$Z,$k,$Numbers)
    {
        if (sizeof($X) || sizeof($Y) || sizeof($Z) == 0) {
            if (empty($X)) {
                array_push($X, $Numbers[$k]);
                $k++;
            } elseif (empty($Y)) {
                array_push($Y, $Numbers[$k]);
                $k++;
            } else {
                array_push($Z, $Numbers[$k]);
                $k++;
            }
        }
        return $k;
    }
//add value to a min of the array
    function find_min($X,$Y,$Z,$Numbers) {

        for ($k = 0; $k <= sizeof($Numbers)-1; $k++) {

            check_if_empty( $X,$Y,$Z,$k,$Numbers);

            if((array_sum($X) == array_sum($Y)) && (array_sum($Y) == array_sum($Z)))
            {
                array_push($Z, $Numbers[$k]);
            }
            elseif ((array_sum($X) <= array_sum($Y)) && (array_sum($X) <= array_sum($Z))) {
                array_push($X, $Numbers[$k]);
            }
            elseif ((array_sum($Y) <= array_sum($X)) && (array_sum($Y) <= array_sum($Z))) {
                array_push($Y, $Numbers[$k]);
            }
            else {
                array_push($Z, $Numbers[$k]);
            }
        }
        draw_result($X,$Y,$Z);
    }

    function draw_result($X,$Y,$Z)
    {
        $endline = "\n";
        $eqSign = " = ";
        $Xstring= join(',', $X);
        $Ystring= join(',', $Y);
        $Zstring= join(',', $Z);

        echo "reFormated into Three groups\n";
        echo "Group A\n";
        echo $Xstring.$eqSign.array_sum($X).$endline;
        echo "Group B\n";
        echo $Ystring.$eqSign.array_sum($Y).$endline;
        echo "Group C\n";
        echo $Zstring.$eqSign.array_sum($Z).$endline;
    }

    find_min($X,$Y,$Z,$Numbers);

}

//TODO Most comman
//TODO Pick a winner

?>