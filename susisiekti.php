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
        changeActive('Pagrindinis');

    ?>

    <div class="ml-5 my-5">
        <h2>Susisiekti:</h2>
        <form action="siustiLaiska.php" method="post">
            Jūsų el. paštas
            <br>
            <input type="text" class="form-control" name="Pastas" style="width:20%" pattern="[A-Za-z0-9.]+@[a-z0-9.-]+\.[a-z]{2,}" title="Paštas privalo būti užrašytas taisyklingai." required="required">
            <br>

            Tema
            <br>
            <input type="text" class="form-control" name="Tema" style="width:20%" title="Dėl ko mums rašote?" required="required">
            <br>

            Jūsų žinutė
            <br>
            <textarea id="instructions" name="Zinute" rows="10" style="width:80%" title="Ką norite mums parašyti?" required="required"></textarea>
            <br>
            <input type="submit" name="Submit" value="Siųsti laišką">
        </form>
    </div>
    


    <!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
    <?php rootInclude('footer.php');?>

</body>

</html>