<?php
    // Info prisijungimui prie duomenų bazės
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "plamela";

    // Prisijungiama prie duomenų bazės. Duomenų bazė bus pasiekiama per kintamąjį $dbconnect
    $dbconnect = mysqli_connect($hostname,$username,$password,$db);
    if ($dbconnect->connect_error) { // rodyklės PHP naudojamos objektiniam programavimui vietoj taškų: c++ būtų objektas.savybe; php yra objektas->savybe;
        die("Database connection failed: " . $dbconnect->connect_error);
    }
?>