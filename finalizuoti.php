<?php session_start(); ?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apdorojama užklausa</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <script>
        function klaida(pranesimas) {
            document.getElementsByClassName('underLoaderBox')[0].innerHTML=pranesimas;
        }
        function peradresuoti(link) {
            window.location.href = link;
        }
        function goBack() {
            history.back();
        }

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
    </script>

    <div class="loader"></div>
    <img class="insideLoader" src="img/p.png">

    <div class="underLoader">
        <h2 class="underLoaderBox"> Apdorojama užklausa, palaukite.
            <?php
                if ($_SESSION["visaKaina"] == 0) {
                    die("<script>peradresuoti('uzsakymas.php?e')</script>");
                }

                if ($_SESSION["user_fullName"] == 0) {
                    die("<script>peradresuoti('uzsakymas.php?e2')</script>");
                }

                $pateiktaBlogaInfo = "<script>klaida('Klaida! Pateikti nepilni arba netinkami duomenys. Peradresuojama.'); setTimeout(peradresuoti, 3000);</script>";
                if(isset($_POST["issaugoti"])) {
                    $statusas = "išsaugotas";
                }
                else if (isset($_POST["uzsakyti"])) {
                    $statusas = "neapmokėtas";
                }
                else {
                    die($pateiktaBlogaInfo);
                }

                include 'dbconnect.php';

                // echo $_SESSION["order_products"];

                $dbconnect -> query("INSERT INTO `orders` (`order_id`, `order_price`, `order_date`, `order_status`, `order_deliveryTime`, `order_fullName`, `order_phone`, `order_products`, `order_shippingAddress`, `user_id`) VALUES (NULL, '".$_SESSION["visaKaina"]."', '".date("Y-m-d")."', '".$statusas."', NULL, '".$_SESSION["user_fullName"]."', '".$_SESSION["user_phone"]."', '".$_SESSION["order_products"]."', '".$_SESSION["user_shippingAddress"]."', '".$_SESSION["user_id"]."') ");

                $REZ = $dbconnect -> query("SELECT `order_id` FROM `orders` ORDER BY `order_id` DESC LIMIT 0, 1")
                or die("Klaida siunčiant užklausą.");
                $order_id = $REZ -> fetch_assoc();
                $order_id = $order_id['order_id'];

                echo '<script>setCookie("krepselis", "", 7);</script>';

                echo '<script>peradresuoti("uzsakymoinfo.php?id='.$order_id.'");</script>';
            ?>
        </h2>
    </div>
</body>
</html>