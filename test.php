<?php
    $templatefiles = glob("./seat/*.sst");
    $templatenames = array();
    for ($i = 0; $i < count($templatefiles); ++$i){
        $templatenames[$i] = basename($templatefiles[$i], ".sst");
    }
    
                                for ($i = 0; $i < count($templatenames); ++$i){
                                $val = $i + 1;
                                $name = $templatenames[$i];
                                echo "<option value = '$val'>$name</option>\n";
                            }
?>
