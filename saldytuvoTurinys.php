<?php
    // GET metodu pasiimamos vartotojo pasirinktos kategorijos (perduodamos kaip mygtuko numeris, atskirtos kableliais, string formatas)
    $catString = $_GET["categories"];
    
    // Jei niekas negauta, rodomas pradinis tekstas
    if (strlen($catString) == 0) {
        die('<h3 class="card-title text-danger font-weight-bold">Plamela</h5>
        <h4 class="card-subtitle mb-2 text-muted font-weight-bold">Virtualus šaldytuvas</h6>
        <br>
        <p class="card-text text-muted">Pasirinkite norimas kategorijas ir galėsite matyti savo turimus produktus</p>');
    }

    // string formato kategorijų sąrašas išskaidomas į masyvą
    $catIDS = explode(",", $catString);

    // apibrėžiamos kategorijos (ta pačia tvarka, kaip ir .js faile)
    $catIndex = ["'Duonos gaminiai'","'Mėsa ir žuvis'","'Pieno produktai ir kiaušiniai'","'Daržovės ir vaisiai'","'Šaldytas maistas'"];

    // ID iššifruojami, suformatuojama WHERE sąlyga, kuri bus naudojama vėliau
    $where = 'pro_category = ' . $catIndex[$catIDS[0]];
    if (count($catIDS) > 1) {
        for ($i = 0;  $i < count($catIDS); $i++) {
            $where = $where . ' OR pro_category = ' . $catIndex[$catIDS[$i]];
        }
    }

    // echo $where;

    // Info prisijungimui prie duomenų bazės
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "plamela";

    // Prisijungiama. Duomenų bazė bus pasiekiama per kintamąjį $dbconnect
    $dbconnect = mysqli_connect($hostname,$username,$password,$db);
    if ($dbconnect->connect_error) {
        die("Database connection failed: " . $dbconnect->connect_error);
    }
    
    // Siunčiama užklausa - pasiimami visi produktai, atitinkantys vartotojo pasirinktas kategorijas. Rezultatas išsaugomas $REZ
    $REZ = $dbconnect -> query("SELECT `pro_name`, `inventory_quantity` FROM `inventory465` JOIN `products` USING (pro_id) WHERE " . $where )
    or die("mysql_error");

    if($REZ->num_rows == 0) {
        die("Savo pasirinktose kategorijose neturite nei vieno Jums priklausančio produkto.");
    }
    
    // Užklausos rezultatas išskaidomas - priskiriamas dvimačio masyvo $inventorius reikšmėms. 1 indeksas nurodo eilutę, 2 indeksas nurodo stulpelį
    $inventorius = [];
    for ($i = 0;  $i < $REZ->num_rows; $i++) {
        $inventorius[$i] = $REZ -> fetch_assoc();
    }

    // Kiekvienam inventoriuje esančiam produktui išvedamas output
    for ($i = 0;  $i < count($inventorius); $i++) {
        echo $inventorius[$i]['pro_name'] . " " . $inventorius[$i]['inventory_quantity'] . "<br>";
    }

    $dbconnect->close();
?>