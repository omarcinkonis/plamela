<?php session_start(); ?>
<!DOCTYPE html>
<html lang="lt">

<head>
    <title>Užsakymas</title>
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

    <div class="my-3 ml-5">
        <a class="yellow" href = 'parduotuve.php'><- Atgal į parduotuvę</a>
    </div>
    <div class="d-none text-center mt-1">
        <span class="text-center">Norite peržiūrėti kitą krepšelį? Įveskite krepšelio kodą: </span>
        <input type="text" onkeypress="krauti(event, this.value)"></input><br><br>
    </div>

    <script>
        function krauti(evt,input) {
        if (evt.key === 'Enter') {
            if (input !== "") {
                window.location.href = "/uzsakymas.php?krepselis=" + input;
            }
        }
    }
    </script>

    <div class="mx-5">
        <table id="suvestine" style="width:100%">
            <tr>
                <th colspan="6" class="text-center">Jūsų krepšelio suvestinė</th>
            </tr>
            <tr>
                <td><b>Eiliškumas</b></td>
                <td><b>Pavadinimas</b></td>
                <td><b>Kiekis</b></td>
                <td><b>Vienetas</b></td>
                <td><b>Kaina</b></td>
                <td><b>Galutinė kaina</b></td>
            </tr>
            <?php
                $krepselis = json_decode( $_COOKIE['krepselis'], true );
                include 'dbconnect.php';
                
                $visaKaina = 0;
                $order_products ="";
                if (isset($krepselis['itemCount'])) {
                    for ($i=0; $i<$krepselis['itemCount']; $i++) {
                        $id = $i + 1;
                        $REZ = $dbconnect -> query("SELECT `pro_id`, `pro_name`, `pro_price`, `pro_unitSize`, `pro_img` FROM `products` WHERE `pro_id` = '" . $krepselis['item'][$i]["id"] . "'")
                        or die("Klaida - krepšelyje rastas neegzistuojantis sistemoje produktas.");
                        
                        $product = $REZ -> fetch_assoc();

                        //echo "ID: " . $krepselis['item'][$i]["id"] . ", kiekis: " . $krepselis['item'][$i]["count"] . "<br>";
                        echo '<tr>
                        <td>' . $id . '</td>
                        <td>' . $product["pro_name"] . '</td>
                        <td>' . $krepselis['item'][$i]["count"] . '</td>
                        <td>' . $product["pro_unitSize"] . '</td>
                        <td>' . $product["pro_price"] . '€/' . $product["pro_unitSize"] . '</td>
                        <td>' . $krepselis['item'][$i]["count"] * $product["pro_price"] . '€</td>
                        </tr>';
                        $visaKaina = $visaKaina + $krepselis['item'][$i]["count"] * $product["pro_price"];
                        $order_products = $order_products . $product["pro_id"] . "|" . $krepselis['item'][$i]["count"] . "\r\n";
                    }
                }
                echo '<tr><td colspan="5"><b class="float-right mr-1">Užsakymo kaina:</b></td><td><b>' . $visaKaina . '€</b></td></tr>';
                //echo $order_products;
                $_SESSION["visaKaina"] = $visaKaina;
                $_SESSION["order_products"] = $order_products;
            ?>
        </table>
    </div>

    <div class="container">
        <form class="row" action="finalizuoti.php" method="post">
            <input type="submit" name="issaugoti" class="btnUzsakymas col-md-4 col-sm-12 mx-5 my-3 btn btn-primary btn-block" value="Išsaugoti krepšelį ateičiai">
            <input type="submit" name="uzsakyti" class="btnUzsakymas col-md-4 col-sm-12 mx-5 my-3 btn btn-primary btn-block" value="Užsakyti prekes ir apmokėti užsakymą">
        <form>
    </div>
        
    <!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
    <?php rootInclude('footer.php');?>

</body>

</html>

<?php
    if(isset($_GET['e'])) {
        echo "<script>alert('Norėdami užsakyti prekes, eikite į puslapį „Maisto prekės“ ir pridėkite prekių į krepšelį.')</script>";
    }
    if(isset($_GET['e2'])) {
        echo "<script>alert('Norėdami pirkti prekes, prisijunkite.')</script>";
    }
?>