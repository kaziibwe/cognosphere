<?php
    $conx = mysqli_connect("localhost:3306","alfred","Ka075.","congosphere_company");
    if(!$conx){
        echo 'Connection Failed';
    }

    // $conx='hello';