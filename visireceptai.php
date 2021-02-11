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

	<div class="row mx-5 receptai">
        <?php
            ///// Prisijungiama prie duomenų bazės. Duomenų bazė bus pasiekiama per kintamąjį $dbconnect
            include 'dbconnect.php';
            
            // Siunčiama užklausa - pagal rec_id pasiimamas konkretus receptas. Rezultatas išsaugomas $REZ
            $REZ = $dbconnect -> query("SELECT `rec_id`, `rec_name`, `rec_desc`, `rec_ingredients`, `rec_approxPrice`, `rec_img` FROM `recipes`")
            or die(mysql_error());
            
            // Užklausos rezultatas išskaidomas - priskiriamas dvimačio masyvo $recipes reikšmėms. 1 indeksas nurodo eilutę, 2 indeksas nurodo stulpelį
            $recipes = [];
            for ($i = 0;  $i < $REZ->num_rows; $i++) {
                $recipes[$i] = $REZ -> fetch_assoc();
            }

            for ($i = 0;  $i < count($recipes); $i++) {
                echo '<div class="col-lg-3 col-md-4 col-xs-6 my-2">';
                echo '  <a href="receptas.php/?recid=' . $recipes[$i]['rec_id'] . '">';
                echo '      <img style="width:100%" src="rec-img/' . $recipes[$i]['rec_img'] . '">';
                echo '      <h3>' . $recipes[$i]['rec_name'] . '</h3>';
                echo '  </a>';
                echo '</div>';
            }
        ?>
	</div>

	<!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
    <?php rootInclude('footer.php');?>

</body>

</html>