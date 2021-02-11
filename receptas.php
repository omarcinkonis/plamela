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
        changeActive('Receptai');

    ?>
	
	<!--//////////////////////////////////////////////////////////////////////////// RECEPTAS -->
    <?php
        $recipe = $_GET["recid"];

        // Info prisijungimui prie duomenų bazės
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $db = "plamela";

        // Prisijungiama. Duomenų bazė bus pasiekiama per kintamąjį $dbconnect
        $dbconnect = mysqli_connect($hostname,$username,$password,$db);
        if ($dbconnect->connect_error) { // rodyklės PHP naudojamos objektiniam programavimui vietoj taškų: c++ būtų objektas.savybe; php yra objektas->savybe;
            die("Database connection failed: " . $dbconnect->connect_error);
        }
        
        // Siunčiama užklausa - pagal rec_id pasiimamas konkretus receptas. Rezultatas išsaugomas $REZ
        $REZ = $dbconnect -> query("SELECT `rec_id`, `rec_name`, `rec_desc`, `rec_ingredients`, `rec_approxPrice`, `rec_calories`, `rec_img` FROM `recipes` WHERE `rec_id` = $recipe")
        or die(mysql_error());
        
        // Užklausos rezultatas išskaidomas - priskiriamas dvimačio masyvo $recipes reikšmėms. 1 indeksas nurodo eilutę, 2 indeksas nurodo stulpelį
        $recipes = [];
        for ($i = 0;  $i < $REZ->num_rows; $i++) {
            $recipes[$i] = $REZ -> fetch_assoc();
        }
    ?>

    <div class="row noPad noMrg">
        <div class="col-md noPad noMrg"><img style="width:100%" src="../rec-img/<?php echo $recipes[0]['rec_img']; ?>"></div>

        <div class="col-md">
            <div class="receptas">
                <h2><?php echo $recipes[0]['rec_name']; ?></h2><hr>

                <div class="icons1">
                    <div class="icons">
                        <img src="../img/dollar.svg">
                        <p>Kaina: <?php echo $recipes[0]['rec_approxPrice']; ?>€</p>
                    </div>
                    <div class="icons">
                        <img src="../img/clock.svg">
                        <p> 15 min.</p>
                    </div>
                    <div class="icons">
                        <img src="../img/kcal.svg">
                        <p><?php echo $recipes[0]['rec_calories']; ?> porcijoje</p>
                    </div>
                    <div class="icons">
                        Porcijų skaičius:
                        <input id="porcijos" type="number" style="width:20%" min="1" title="Porcijų skaičius" required="required" onchange="perskaiciuoti(this.value)">
                    </div>
                </div>

                <h3>Ingredientai:</h3>
                <p>
                    <?php
                        $ingredients = explode("\r\n", $recipes[0]['rec_ingredients']);
                                
                        for ($i = 0;  $i < count($ingredients); $i++) {
                            $namecountval = explode(" | ", $ingredients[$i]);
                            echo $namecountval[0] . " <span class='kiekis'>" . $namecountval[1] . "</span> " . $namecountval[2] . " ";
                            echo '<br>';
                        }
                    ?>
                </p>

                <h3>Gaminimo eiga:</h3>
                <p>
                    <?php echo $recipes[0]['rec_desc']; ?>
                </p>
                
                <div class="recbutton d-none"><a href="parduotuve.html" class="myButton1">Pridėti trūkstamus produktus į krepšelį</a></div>
            </div>
        </div>
    </div>

    <script>      
        document.getElementById('porcijos').value = '1'; // default value nustato į 1
        let naujiKiekiai = document.getElementsByClassName("kiekis");
        let stabilusKiekiai = [];  
        
        for (var i=0; i<naujiKiekiai.length; i++) {
            stabilusKiekiai[i] = naujiKiekiai[i].innerHTML;
            console.log (stabilusKiekiai[i]);
        }

        function perskaiciuoti (userInput) {
            let naujiKiekiai = document.getElementsByClassName("kiekis");
            for (var i=0; i<naujiKiekiai.length; i++) {
                if(naujiKiekiai[i].innerHTML > 0) {
                    naujiKiekiai[i].innerHTML = stabilusKiekiai[i] * userInput;
                }
            }
        }

    </script>

    <!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
    <?php rootInclude('footer.php');?>
   
</body>

</html>