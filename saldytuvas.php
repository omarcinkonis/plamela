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
        changeActive('Virtualus šaldytuvas');

    ?>
    
    <div class="row noPad noMrg">
        <div style="margin-left: 5%;">
            <canvas id="saldytuvas" width="584" height="900"></canvas>
            <script src="saldytuvas.js"></script>
        </div>

        <div class="col-lg col-md-12 mx-auto text-center">
            <div class="card ml-5 mr-5" style="margin-top: 30%;">
                <div class="card-body" id="fridgeContent">
                    <h3 class="card-title text-danger font-weight-bold">Plamela</h5>
                    <h4 class="card-subtitle mb-2 text-muted font-weight-bold">Virtualus šaldytuvas</h6>
                    <br>
                    <p class="card-text text-muted">Pasirinkite norimas kategorijas ir galėsite matyti savo turimus produktus</p>
                </div>
            </div>
        </div>
        
    </div>

    <?php rootInclude('footer.php');?>

</body>

</html>