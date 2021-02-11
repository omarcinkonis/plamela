<?php
    $pastas = $_POST['Pastas'];
    $tema = $_POST['Tema'];
    $zinute = $_POST['Zinute'];

    // žinutė
    $msg = "Kliento paštas: " . $pastas . "\n\nKliento žinutė: " . $zinute;

    // siųsti laišką
    @mail("osmundas.m@gmail.com", $tema, $msg);

    echo "<script>window.location.href = 'index.php';</script>"
?>