<?php session_start(); ?>
<!DOCTYPE html>
<html lang="lt">

<head>
    <title>Informacija apie užsakymą</title>
    <?php
        // funkcija, leidžianti failų kelius automatiškai performatuoti taip, kad jie būtų pradedami nuo root direktorijos (nenaudojant šios funkcijos, atsirastų klaidų dėl to, kaip veikia PHP paths)
        function rootInclude($path) {
            include ($_SERVER["DOCUMENT_ROOT"] . '/' . $path);
        }
        rootInclude('head.php');
    ?>
</head>

<body>
    <!--//////////////////////////////////////////////////////////////////////////// NAVBAR-->
    <?php
        rootInclude('navbar.php');
    ?>

    <div class="text-center">
        <?php
            $pateiktaBlogaInfo = "Klaida! Pateikti nepilni arba netinkami duomenys.";
            if(isset($_GET["id"])) {
                echo "Jūsų krepšelio/užsakymo unikalus identifikacinis numeris: <b>" . $_GET["id"] . "</b><br>";

                include "dbconnect.php";

                $REZ = $dbconnect -> query("SELECT `order_status` FROM `orders` WHERE `order_id` = '".$_GET["id"]."'")
                or die("Klaida siunčiant užklausą.");
                $order_status = $REZ -> fetch_assoc();
                $order_status = $order_status['order_status'];

                echo "Statusas: <b>" . $order_status . "</b><br>";

                if ($order_status == "neapmokėtas") {
                    echo '<a href="apmoketi.php?id='.$_GET["id"].'" class="myButton1">Apmokėti (sistema jus nukreips į „Paysera“ mokėjimo platformą)</a><br>';
                }
                elseif ($order_status == "išsaugotas") {
                    echo '<a href="uzsakymas.php" class="myButton1">Tęsti užsakymą</a><br>';
                }
                else echo '<a href="parduotuve.php" class="myButton1">Grįžti į parduotuvę</a><br>';
            }
            else {
                die($pateiktaBlogaInfo);
            }
        ?>
    </div>
        
    <!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
    <?php rootInclude('footer.php');?>

</body>
</html>