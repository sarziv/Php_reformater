<?php
//Github: sarziv
$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], 'rb');
fileRestriction($file_handle);
//File restrictions
function fileRestriction ($file_handle){
        $uploadOk = 1;
        //Is file uploaded
        if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
            //Only can upload TXT files
            if ($_FILES["fileToUpload"]["type"] !== "text/plain") {
                echo "It was not text file.\n";
                $uploadOk = 0;
            }
//Capping the size of the file
            if ($_FILES["fileToUpload"]["size"] == 0) {
                echo "File is Empty!\n";
                $uploadOk = 0;
            } elseif ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.\n";
                $uploadOk = 0;
            }

//Errors
            if ($uploadOk == 0) {
                echo "Sorry, your file was not reformated \n";
            } else {
                //Formating Type
                if (isset($_POST['submit'])) {
                    $selected_var = $_POST['Format'];
                    //after submit and if file is valid choose format type from form
                    formatSwitch($selected_var, $file_handle);
                }
            }
        }else {
            echo 'File was not uploaded.';
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
        case "Count_letters":
            mostCommon($file_handle);
            break;
        case "Pick_winner":
            pickWinner($file_handle);
            break;
    }
}
//order ASC
function orderASC ($file_handle) {
    $Numbers = numberExplode($file_handle);
   asort($Numbers);
    echo "This is Ordering by Asc.\n";
        foreach ($Numbers as $number) {
            echo $number . " " ;
        }


}
//order DESC
function orderDESC ($file_handle) {
    $Numbers = numberExplode($file_handle);
    rsort($Numbers);
    echo "This is Ordering by Desc.\n";
        foreach ($Numbers as $number) {
            echo $number . " ";
        }

}
//Split number into two equal groups
function splitTwo($file_handle) {

    $Numbers = numberExplode($file_handle);
    $X  = array();
    $Y = array();

    rsort($Numbers);

    //check if array if empty and push the values
    function check_if_empty($X,$Y,$k,$Numbers)
    {

        if (sizeof($X) || sizeof($Y) == 0) {
            if (empty($X)) {
                array_push($X, $Numbers[$k]);
                $k++;
            } else{
                array_push($Y, $Numbers[$k]);
                $k++;
            }
        }
        return $k;
    }
//add value to a min of the array
    function find_min($X,$Y,$Numbers) {

        for ($k = 0; $k <= sizeof($Numbers)-1; $k++) {

            check_if_empty( $X,$Y,$k,$Numbers);

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
    $Numbers = numberExplode($file_handle);
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
    }
//add value to a min of the array
    function find_min($X,$Y,$Z,$Numbers) {

        for ($k = 0; $k <= sizeof($Numbers)-1; $k++) {

            check_if_empty( $X,$Y,$Z,$Numbers);

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
//most common number from the array
function mostCommon($file_handle) {
    $Numbers = numberExplode($file_handle);
    $counted = array_count_values($Numbers);
    arsort($counted);
   echo 'Most common - > ' . key($counted);
}
//random number from the array
function pickWinner ($file_handle) {
    $Numbers = numberExplode($file_handle);
    $rand_keys = array_rand($Numbers,1);
    echo 'Winner is -> ' . $Numbers[$rand_keys] . "\n";
}
//explode number by separation
function numberExplode($file_handle) {
    while (!feof($file_handle) ) {
        $line_of_text = fgets($file_handle);
    }
    //list of separations
    $delimiters = array(",",".","|",":");
    //replace string for explode
    $ready = str_replace($delimiters, ',', $line_of_text);
    $Numbers = explode(',', $ready);
    //file close after reading
    fclose($file_handle);
    //return the array after reading it from the file
    return $Numbers;
}


?>


<div>
    <button onclick="goBack()">Go Back</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <br>
</div>

