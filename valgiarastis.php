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
        changeActive('Valgiaraštis');

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
        // $REZ = $dbconnect -> query("SELECT `rec_id`, `rec_name`, `rec_img` FROM `recipes` WHERE `rec_id` = $recipe")
		// or die(mysql_error());

		// $REZ = $dbconnect -> query("SELECT `rec_id`, `rec_name`, `rec_img` FROM `valgiarastis`)
		// or die(mysql_error());
		
        
    ?>

	<?php 
		$weekdays = array('pirmadienis','antradienis', 'trečiadienis', 'ketvirtadienis', 'penktadienis', 'šeštadienis', 'sekmadienis');
	  for ($i=0; $i < 7; $i++) { 
		  $weeknumber = (intval(date('w'))+$i);
		  if($weeknumber > 7) $weeknumber -=7;
		echo '<div class="row4">
		<h1>'.$weekdays[$weeknumber-1].'</h1>
			<div class="row mt-4">
				<div class="col-sm"><a class="" href="#.html"><img style="width:91%" src="img/rec1.jpg" >
						<h3>orecchiette with creamy carrot sauce</h3>
					</a></div>
				<div class="col-sm"><a class="" href="#.html"><img style="width:91%" src="img/rec1.jpg">
						<h3>orecchiette with creamy carrot sauce</h3>
					</a></div>
				<div class="col-sm"><a class="" href="#.html"><img style="width:91%" src="img/rec1.jpg">
						<h3>orecchiette with creamy carrot sauce</h3>
					</a></div>
			</div>
		</div>';

	  }
	
	?>

	<!--//////////////////////////////////////////////////////////////////////////// FOOTERIS -->
	<?php rootInclude('footer.php');?>


</body>

</html>