<?php session_start(); ?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prisijungimas</title>
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
        <h2 class="underLoaderBox"> Vyksta prisijungimas, palaukite.
            <?php
                $pateiktaBlogaInfo = "<script>klaida('Klaida! Pateikti nepilni arba netinkami duomenys. Peradresuojama.'); setTimeout(peradresuoti, 3000);</script>";
                $slapyvardis = $_POST['Slapyvardis'] or exit($pateiktaBlogaInfo);
                $slaptazodis = $_POST['Slaptazodis'] or exit($pateiktaBlogaInfo);

                // echo "<p>slapyvardis: " . $slapyvardis . "</p>";
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
                $REZ = $dbconnect -> query("SELECT `user_id`, `login_password`, `login_salt` FROM `login` WHERE login_username = '" . $slapyvardis . "'")
                or die($dbKlaida);

                $registruotasVartotojas = $REZ -> fetch_assoc();
                if ($registruotasVartotojas == false) {
                    die("<script>klaida('Vartotojas su prisijungimo vardu „" . $slapyvardis . "“ Nėra registruotas. Peradresuojama atgal.'); setTimeout(goBack, 3000);</script>");
                }
                else {
                    $pw = md5($slaptazodis.$registruotasVartotojas['login_salt']);
                    if ($pw === $registruotasVartotojas['login_password']) {

                        $_SESSION["user_id"] = $registruotasVartotojas['user_id'];
                        $_SESSION["username"] = $slapyvardis;

                        $REZ = $dbconnect -> query("SELECT * FROM `users` WHERE `user_id` = '" . $_SESSION["user_id"] . "'")
                        or die($dbKlaida);

                        $registruotasVartotojas = $REZ -> fetch_assoc();

                        $_SESSION["user_fullName"] = $registruotasVartotojas["user_fullName"];
                        $_SESSION["user_phone"] = $registruotasVartotojas["user_phone"];
                        $_SESSION["user_shippingAddress"] = $registruotasVartotojas["user_shippingAddress"];


                        // norint padaryti rimtesnį prisijungimą: https://code.tutsplus.com/tutorials/how-to-use-sessions-and-session-variables-in-php--cms-31839
                        echo "<script>peradresuoti()</script>";
                    }
                    else {
                        die ("<script>klaida('Slaptažodis neteisingas. Peradresuojama atgal.'); setTimeout(goBack, 3000);</script>");
                    }
                }

            ?>
        </h2>
    </div>
</body>
</html>