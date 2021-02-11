<?php session_start(); ?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apmokėjimas</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="loader"></div>
    <img class="insideLoader" src="img/p.png">

    <div class="underLoader">
        <h2 class="underLoaderBox"> Esate peradresuojamas į „Paysera“, palaukite.
            <?php
                $pateiktaBlogaInfo = "<script>klaida('Klaida! Pateikti nepilni arba netinkami duomenys. Peradresuojama.'); setTimeout(peradresuoti, 3000);</script>";
                $id = $_GET["id"] or die($pateiktaBlogaInfo);

                include "dbconnect.php";

                $dbconnect -> query("UPDATE `orders` SET `order_status` = 'apmokėtas' WHERE `orders`.`order_id` = '".$_GET["id"]."'")
                or die("Toks užsakymas neegzistuoja.");

                $REZ = $dbconnect -> query("SELECT `order_products` FROM `orders` WHERE `order_id` = '$id'");
                $products = $REZ -> fetch_assoc();
                $products = $products['order_products'];
                $products = explode("\r\n",$products);
                for ($i=0; $i<count($products); $i++) {
                    $oneProduct = explode("|",$products[$i]);
                    // echo $oneProduct[0] . " " . @$oneProduct[1] . "<br>";
                    $REZ = $dbconnect -> query("SELECT `inventory_quantity` FROM `inventory465` WHERE `pro_id` = '$oneProduct[0]'");
                    if ($REZ->num_rows > 0) {
                        $quantity = $REZ -> fetch_assoc();
                        $quantity = $quantity['inventory_quantity'];
                        $new_quantity = $quantity + @$oneProduct[1];
                        $dbconnect -> query("UPDATE `inventory465` SET `inventory_quantity` = '".$new_quantity."' WHERE `inventory465`.`pro_id` = ".$oneProduct[0].";");
                    }
                    else {
                        $dbconnect -> query("INSERT INTO `inventory465` (`pro_id`, `inventory_quantity`) VALUES ('".$oneProduct[0]."', '".@$oneProduct[1]."')");
                    }
                }

                echo "<script>window.location.href = 'uzsakymoinfo.php?id=".$_GET["id"]."';</script>";
            ?>
        </h2>
    </div>
</body>
</html>