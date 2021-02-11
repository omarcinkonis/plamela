<?php session_start(); ?>
<!DOCTYPE html>
<html lang="lt">

<head>
    <title>Pagrindinis</title>
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
        changeActive('Pagrindinis');

    ?>

    <div class="container2">
        <img style="float:right; padding:0px;" src="img/main.png">
    </div>


    <div class="container1">
        <img src="img/plamela.png">
        <p>
            Esami pirmieji Lietuvoje, kurie siūlo įsigyti kokybiškus ir natūralius produktus bei galimybę susiplanuoti pasirinkto laikotarpio valgiaraštį viename!
        </p>
    </div>



    <div class="container3">
        <img src="img/main21.png">
    </div>



    <div class="row no-gutters">
        <div class="col no-gutters">
            <div class="leftside d-flex flex-column justify-content-center align-items-center">
                <img style="width:100%;" src="img/rec.jpg">
            </div>
        </div>

        <div class="col no-gutters">
            <div class="rightside d-flex flex-column justify-content-center align-items-center">
                <h1 style="text-align:center;">Daugiau nei 100 mėgstamų receptų!</h1>
                <br>
                <a href="visireceptai.php" class="myButton1">Receptai</a>
            </div>
        </div>
    </div>





    <div class="row no-gutters">
        <div class="col no-gutters">
            <div class="leftside d-flex flex-column justify-content-center align-items-center">
                <h1 style="text-align:center;">Didesnis nei 1000 ekologiškų prekių asortimentas</h1>
                <br>
                <a href="parduotuve.php" class="myButton1">Maisto prekės</a>
            </div>
        </div>

        <div class="col no-gutters">
            <div class="rightside d-flex flex-column justify-content-center align-items-center">
                <img style="width:100%;" src="img/rec2.png">
            </div>
        </div>
    </div>
        
        
        
    <!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
    <?php rootInclude('footer.php');?>

</body>

</html>