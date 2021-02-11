<?php session_start(); ?>
<!DOCTYPE html>
<html lang="lt">

<head>
    <!--//////////////////////////////////////////////////////////////////////////// HEAD-->
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
        // changeActive() funkciją privaloma rašyti čia, nes kai path nustatomas nuo direktorijos, neišeina perduoti kintamųjų į kviečiamą failą
        // įtraukiame navigaciją
        rootInclude('navbar.php');
        
        function changeActive($navItem) {
            echo "<script>changeActive('" . $navItem . "');</script>";
        }

        // nustatome aktyvų elementą (šį kintamąjį pasiims navbar.php ir įdės į funkciją)
        changeActive('Maisto prekės');

    ?>

    <!--//////////////////////////////////////////////////////////////////////////// PARDUOTUVE-->
    <!--https://codepen.io/malachi358/details/BzwNgg-->
    <div class="container-fluid">
        <?php
            if(isset($_GET['raktazodis'])) {
                echo "<div class='text-center mt-2'> Rodomi rezultatai pagal paieškos raktažodį: „" . $_GET['raktazodis'] . "“</div>";
            }
        ?>

        <!-- Product Grid -->
        <div class="row product-grid">
            <?php
                ///// Prisijungiama prie duomenų bazės. Duomenų bazė bus pasiekiama per kintamąjį $dbconnect
                include 'dbconnect.php';
                
                // Siunčiama užklausa - jei nieko neieškoma, pasiimami visi produktai, jei ieškoma, pasiimami produktai pagal raktažodį
                if(isset($_GET['raktazodis'])) {
                    $REZ = $dbconnect -> query("SELECT `pro_id`, `pro_name`, `pro_price`, `pro_unitSize`, `pro_img` FROM `products` WHERE `pro_name` LIKE '%".$_GET['raktazodis']."%';")
                    or die(mysql_error());
                }
                else {
                    $REZ = $dbconnect -> query("SELECT `pro_id`, `pro_name`, `pro_price`, `pro_unitSize`, `pro_img` FROM `products`")
                    or die(mysql_error());
                }
                              
                // Užklausos rezultatas išskaidomas - priskiriamas dvimačio masyvo $products reikšmėms. 1 indeksas nurodo eilutę, 2 indeksas nurodo stulpelį
                $products = [];
                for ($i = 0;  $i < $REZ->num_rows; $i++) {
                    $products[$i] = $REZ -> fetch_assoc();
                }

                for ($i = 0;  $i < count($products); $i++) {
                    echo '<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 grid-item">'; // JS: var ID = object.id;
                    echo '    <img src="img/prekes/' . $products[$i]['pro_img'] . '" alt="" />';
                    echo '    <h1 class="product-title">' . $products[$i]['pro_name'] . '</h1>';
                    echo '    <h3 class="product-price">' . $products[$i]['pro_price'] . '€/' . $products[$i]['pro_unitSize'] . '</h3>';
                    echo '    <div class="row mx-4">';
                    echo '        <div class="quantity col-6 noPad">';
                    echo '            <fieldset data-quantity></fieldset>';
                    echo '        </div>';
                    echo '        <button class="add-to-cart-button col-6 noPad" onclick="cart.addItem(this.parentNode, ' . $products[$i]['pro_id'] . ', \'' . $products[$i]['pro_name'] . '\', ' . $products[$i]['pro_price'] . ', \'' . $products[$i]['pro_unitSize'] . '\')">Į krepšelį</button>';
                    echo '    </div>';
                    echo '</div>';
                }
            ?>

            <div class="succes-message">Produktas įdėtas į krepšelį</div>
        </div>

    </div>

    <script type="module">
        import QuantityInput from '../quantity.js';

        (function(){
            let quantities = document.querySelectorAll('[data-quantity]');

            if (quantities instanceof Node) quantities = [quantities];
            if (quantities instanceof NodeList) quantities = [].slice.call(quantities);
            if (quantities instanceof Array) {
                quantities.forEach(div => (div.quantity = new QuantityInput(div, 'Mažinti kiekį', 'Didinti kiekį')));
            }
        })();
    </script>

    <!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
    <?php rootInclude('footer.php');?>

</body>

</html>