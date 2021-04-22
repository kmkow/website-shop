<?php
session_start();
require "connect.php";
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

if (isset($_POST['nazwa_produktu'])) {
    $jest_ok = true;

    $nazwa_produktu = $_POST['nazwa_produktu'];
    $cena_produktu = $_POST['cena_produktu'];
    $id_kategoria = $_POST['id_kategoria'];
    $opis_produktu = $_POST['opis_produktu'];
    $ilosc_produktu = $_POST['ilosc_produktu'];

    if ((strlen($nazwa_produktu) < 3) || (strlen($nazwa_produktu) > 20)) {
        $jest_ok = false;
        $_SESSION['e_nazwa_produktu'] = "Nazwa musi posiadać od 3 do 20 znaków";
    }

    require "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            $result = $polaczenie->query("SELECT id_produktu FROM produkt WHERE nazwa_produktu='$nazwa_produktu'");
            if (!$result) throw new Exception($polaczenie->error);
            $ile_takich_produktow = $result->num_rows;
            if ($ile_takich_produktow > 0) {
                $wszystko_OK = false;
                $_SESSION['e_nazwa_produktu'] = "Istnieje juz taki produkt";
            }
            if ($jest_ok == true) {

                if (
                    $polaczenie->query("INSERT INTO produkt VALUES(NULL,'$nazwa_produktu','$cena_produktu','$id_kategoria','$opis_produktu')")
                    && $polaczenie->query("INSERT INTO magazyn VALUES((SELECT id_produktu FROM produkt WHERE nazwa_produktu='$nazwa_produktu'),'$ilosc_produktu')")
                ) {
                    $_SESSION['udanedodanieproduktu'] = true;
                }
            }
            $polaczenie->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera!</span>';
        echo '<br/>Informacja:' . $e;
    }
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
    <form method="POST">
        <h2>Dodaj produkt:</h2>
        Nazwa Produktu: <br> <input type="text" name="nazwa_produktu"><br>
        <?php
        if (isset($_SESSION['e_nazwa_produktu'])) {
            echo '<div class="error">' . $_SESSION['e_nazwa_produktu'] . '</div>';
            unset($_SESSION['e_nazwa_produktu']);
        }
        ?>
        Cena Produktu: <br> <input type="text" name="cena_produktu"><br>
        Kategoria Produktu: <br> <input type="text" name="id_kategoria"><br>
        Opis: <br> <textarea rows="4" cols="50" type="text" name="opis_produktu"> </textarea><br>
        Ilość: <br> <input type="text" name="ilosc_produktu"><br><br>
        <input type="submit" value="Dodaj Produkt">
    </form>

    <!--usuń produkt-->
    <h2>Usuń produkt</h2>
    <form method="POST">
        Nazwa produktu do usuniecia: <br /> <input type="text" name="nazwa_produktu_do_us"><br /><br />
        <input type="submit" value="Potwierdź usunięcie">
    </form>
    <br />
    <!--zmień ilość w magazynie-->
    <h2>Zmień ilość w magazynie:</h2>
    <form method="POST">
        Nazwa Produktu: <br /> <input type="text" name="nazwa_produktu_ilosc"><br />
        Nowa ilość produktu: <br /><input type="number" min="0" name="nowa_ilosc_produktu"><br />
        <input type="submit" value="Potwierdz nową ilość produktu">
    </form>
    <br />
    <br />
    <!-- zmień status zamówienia -->
    <form method="POST">
        <h2>Zmień status zamówienia</h2>
        Id zamowienia: <br /><input type="number" min="1" name="idzam" /><br />
        Nowy status: <br /><input type="number" min="1" max="3" name="nowystat" /><br />
        <button type="submit" name="zmienstatus">Zmień status zamówienia</button>
    </form>
    <br /><br />
    <!-- pokaz szczegoly zamowienia -->
    <form method="POST">
        <h2>Pokaz szczegóły zamówienia</h2>
        Id zamowienia: <br /><input type="number" min="1" name="idzam1" /><br />
        <button type="submit" name="pokazszczegoly">Pokaż szczegóły zamówienia</button>
    </form>
    <?php 
        if(isset($_POST['pokazszczegoly'])){
            $idzam1=$_POST['idzam1'];
            $szczegoly=$polaczenie->query("SELECT * FROM zamowienia z INNER JOIN szczegoly_zamowienia s ON z.id_zamowienia=s.id_zamowienia INNER JOIN produkt p ON s.id_produktu=p.id_produktu INNER JOIN adresy_klientow a ON z.id_klienta=a.id_klienta" );
            
                while($szcz=$szczegoly->fetch_assoc()){
                    echo "<hr>".$szcz['id_produktu']." | ".$szcz['nazwa_produktu']." | "."Ilość produktu: ".$szcz['ilosc_zamawianego_produktu']." | "; //dziala
                    //.$szcz['imie']." | ". $szcz['nazwisko']. ' | '.$szcz['nrtel'].' | '.$szcz['adres']. ' | '.$szcz['miasto'].' | '.$szcz['kod_pocztowy']. ' | Łączna cena: '.$szcz['laczna_cena']." zł";
                }
            
        }
    ?>


    <br /><br />
    <?php
   
    $produkty = $polaczenie->query("SELECT nazwa_produktu, cena_produktu, opis_produktu, ilosc_w_magazynie FROM produkt p INNER JOIN magazyn m ON m.id_produktu=p.id_produktu");

    if ($produkty->num_rows > 0) {
        // wyprowadzenie
        echo "<h2>Produkty: </h2>";
        while ($row = $produkty->fetch_assoc()) {

            echo  "<hr>" . $row["nazwa_produktu"] . " | " . $row["cena_produktu"] . " zł" . " | " . $row["opis_produktu"] . " |  Ilość w Magazynie: " . $row["ilosc_w_magazynie"]  . "<br>";
        }
    } else {
        echo "Nie ma produktow";
    }
    echo "<br/><br/><br/><br/><h2>Zamówienia: </h2>";
    $zamowienia = $polaczenie->query("SELECT * FROM zamowienia z INNER JOIN status_zamowienia s ON z.status_zamowienia=s.id_statusu");
    if ($zamowienia->num_rows > 0) {
        while ($zamowienie = $zamowienia->fetch_assoc()) {
            echo "<hr>" . $zamowienie["id_zamowienia"] . " | " . $zamowienie['id_klienta'] . " | " . $zamowienie['laczna_cena'] . " | " . $zamowienie['data_zlozenia_zamowienia'] . " | Status: " . $zamowienie['status_zamowienia'].". ". $zamowienie['nazwa_statusu'] . "<br/>";
        }
    } else {
        echo "Nie ma zamowień";
    }
    //usuwanie produktów
    if (isset($_POST['nazwa_produktu_do_us'])) {
        $nazwa_produktu_do_us = $_POST['nazwa_produktu_do_us'];
        $usuniecie = $polaczenie->query(" DELETE FROM magazyn WHERE id_produktu = (SELECT p.id_produktu FROM produkt p INNER JOIN magazyn m ON p.id_produktu=m.id_produktu WHERE nazwa_produktu='$nazwa_produktu_do_us') ");
        $usuniecie1 = $polaczenie->query(" DELETE FROM produkt WHERE nazwa_produktu='$nazwa_produktu_do_us'");

        if ($usuniecie && $usuniecie1) {
            echo "Usunięto";
        } else {
            echo "Błąd. " . $polaczenie->error;
        }
    }
    //zmiana ilośći produktu
    if (isset($_POST['nazwa_produktu_ilosc'])) {
        $nazwa_produktu_ilosc = $_POST['nazwa_produktu_ilosc'];
        $nowa_ilosc_produktu = $_POST['nowa_ilosc_produktu'];

        $nowa_ilosc = $polaczenie->query("UPDATE magazyn m INNER JOIN produkt p ON m.id_produktu = p.id_produktu SET ilosc_w_magazynie=$nowa_ilosc_produktu WHERE nazwa_produktu='$nazwa_produktu_ilosc'");

        if ($nowa_ilosc) {
            echo "Wczytano nową ilość";
        } else {
            echo "Błąd. " . $polaczenie->error;
        }
    }
    //zmiana statusu zamówienia
    if (isset($_POST['zmienstatus'])) {
        $idzam = $_POST['idzam'];
        $nowystat = $_POST['nowystat'];
        $polaczenie->query("UPDATE zamowienia set status_zamowienia='$nowystat' WHERE id_zamowienia='$idzam'");
    }



    $polaczenie->close();
    ?>


    <footer>Pojekt Sklep internetowy by: Konrad Kowalczyk</footer>
</body>

</html>