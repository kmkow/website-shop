<?php
session_start();
require "connect.php";
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
if ($polaczenie->connect_error) {
    die("Connection failed: " . $polaczenie->connect_error);
}
if ($polaczenie->connect_errno != 0) {
    throw new Exception(mysqli_connect_errno());
}

?>
<!DOCTYPE html>
<html lang="pl-PL">

<head>
    <meta charset="UTF-8">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
    <script>
        var koszyk=[];
        var do_koszyka;
        function dod_d_k(do_koszyka){
            koszyk.push(do_koszyka);
        }
function ile_w_koszyku(){
    document.getElementById("ilwkosz").innerHTML = koszyk.length;
    setTimeout("ile_w_koszyku",2000);
}
    </script>


    <a href="koszyk.php">Przejdź do koszyka </a><p id="ilwkosz"><script>ile_w_koszyku();</script></p>
    
    <?php
    
    $produkty = $polaczenie->query("SELECT p.id_produktu, nazwa_produktu, cena_produktu, opis_produktu, ilosc_w_magazynie FROM produkt p INNER JOIN magazyn m ON m.id_produktu=p.id_produktu");

    if ($produkty->num_rows > 0) {
        // wyprowadzenie
        while ($row = $produkty->fetch_assoc()) {
            if ($row["ilosc_w_magazynie"] > 0) {
                $id_do_sc = $row['id_produktu'];
                echo
                    '<div class="produkt">' . "<h3>" . $row["nazwa_produktu"] . " - " . $row["cena_produktu"] . " PLN" . "</h3>" . "<br/>"
                        . $row["opis_produktu"]
                        . "<br/><br/><br/>Ilość w Magazynie: " . $row["ilosc_w_magazynie"]
                        . "<br/><br/><br/>"
                        .'<input type="button" onclick="dod_d_k('.$id_do_sc.');" value="dodaj do koszyka"/>'
                        . "</div>" . "<br/>";
            }
        }
    } else {
        echo "Nie ma produktow";
    }
    $polaczenie->close();
    ?>
    <script>dod_d_k(3);</script>
    <form><input type="button" onclick="dod_d_k(3);" value="dodaj do koszyka"/></form>



    <footer>Pojekt Sklep internetowy by: Konrad Kowalczyk</footer>
</body>

</html>