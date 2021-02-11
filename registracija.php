<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <script>
        function klaida(pranesimas) {
            document.getElementsByClassName('underLoaderBox')[0].innerHTML=pranesimas;
        }
        function peradresuoti() {
            window.location.href = 'index.php';
        }
        function goBack() {
            history.back();
        }
    </script>

    <div class="loader"></div>
    <img class="insideLoader" src="img/p.png">

    <div class="underLoader">
        <h2 class="underLoaderBox"> Vyksta registracija, palaukite.
            <?php
                $pateiktaBlogaInfo = "<script>klaida('Klaida! Pateikti nepilni arba netinkami duomenys. Peradresuojama.'); setTimeout(peradresuoti, 3000);</script>";
                $slapyvardis = $_POST['Slapyvardis'] or exit($pateiktaBlogaInfo);
                $pastas = $_POST['Pastas'] or exit($pateiktaBlogaInfo);
                $slaptazodis = $_POST['Slaptazodis'] or exit($pateiktaBlogaInfo);
                $vardas = $_POST['Vardas'] or exit($pateiktaBlogaInfo);
                $adresas = $_POST['Adresas'] or exit($pateiktaBlogaInfo);
                $numeris = $_POST['Numeris'] or exit($pateiktaBlogaInfo);

                // echo "<p>slapyvardis: " . $slapyvardis . "</p>";
                // echo "<p>pastas: " . $pastas . "</p>";
                // echo "<p>slaptazodis: " . $slaptazodis . "</p>";

                // Info prisijungimui prie duomenų bazės
                $hostname = "localhost";
                $username = "root";
                $password = "";
                $db = "plamela";
                $dbKlaida = "<script>klaida('Nepavyko prisijungti prie duomenų bazės. Pabandykite perkrauti puslapį. Jei problema tęsis, susisiekite su Plamela IT pagalba.');</script>";
                // Prisijungiama. Duomenų bazė bus pasiekiama per kintamąjį $dbconnect
                $dbconnect = mysqli_connect($hostname,$username,$password,$db);
                if ($dbconnect->connect_error) {
                    die($dbKlaida);
                }
                
                // Siunčiama užklausa - tikrinama, ar vartotojo pasirinktas slapyvardis jau yra užimtas
                $REZ = $dbconnect -> query("SELECT `login_username`, `user_email` FROM `login` JOIN `users` USING (user_id) WHERE login_username = '" . $slapyvardis . "' OR user_email = '" . $pastas . "'")
                or die($dbKlaida);

                $registruotasVartotojas = $REZ -> fetch_assoc();
                if ($registruotasVartotojas == false) {
                    // echo "username ir email yra laisvi";
                }
                else {
                    if($registruotasVartotojas['login_username'] == $slapyvardis) { // tikrina, ar prisijungimo vardas jau užimtas
                        die("<script>klaida('Vartotojas su prisijungimo vardu „" . $registruotasVartotojas['login_username'] . "“ jau yra registruotas. Pasirinkite kitą prisijungimo vardą. Peradresuojama atgal.'); setTimeout(goBack, 7000);</script>");
                    }
                    else {
                        // echo " username-ok";
                    }
                    
                    if($registruotasVartotojas['user_email'] == $pastas) { // tikrina, ar el. paštas jau užimtas
                        die("<script>klaida('Vartotojas su elektroniniu paštu „" . $registruotasVartotojas['user_email'] . "“ jau yra registruotas. Pasirinkite kitą elektroninį paštą. Peradresuojama atgal.'); setTimeout(goBack, 7000);</script>");
                    }
                    else {
                        // echo " email-ok";
                    }
                }

                $salt = rand(1000000000,2147483647);
                $salt = md5($salt);
                $pw = md5($slaptazodis.$salt);

                $REZ = $dbconnect -> query("INSERT INTO `login` (`user_id`, `login_username`, `login_password`, `login_salt`) VALUES (NULL, '" . $slapyvardis . "', '" . $pw . "', '" . $salt . "')")
                or die($dbKlaida);
                $REZ = $dbconnect -> query("INSERT INTO `users` (`user_id`, `user_email`, `user_fullName`, `user_shippingAddress`, `user_deliveryTimes`, `user_phone`) VALUES (NULL, '" . $pastas . "', '" . $vardas . "', '" . $adresas . "', '', '" . $numeris . "')")
                or die($dbKlaida);
                
                die("<script>peradresuoti();</script>"); // registracija sėkminga, vartotojas peradresuojamas

                // ateičiai - perduoti duomenis į prisijungimą ir iš karto prijungti vartotoją, jei registracija sėkminga
                // // building array of variables
                // $content = http_build_query(array(
                //     'username' => 'value',
                //     'password' => 'value'
                //     ));
                // // creating the context change POST to GET if that is relevant 
                // $context = stream_context_create(array(
                //     'http' => array(
                //         'method' => 'POST',
                //         'content' => $content, )));

                // $result = file_get_contents('http://www.example.com/page.php', null, $context);
                // //dumping the reuslt
                // var_dump($result);
            ?>
        </h2>
    </div>
</body>
</html>