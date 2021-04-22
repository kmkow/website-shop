<?php
session_start();
require "connect.php";
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
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
    <h3>Wprowadz swoje dane</h3>
    Imie: <br /><input type="text" name="imie"><br />
    Nazwisko: <br /><input type="text" name="nazwisko" /><br />
    E-mail: <br /><input type="email" name="email" /><br />
    Nr Telefonu: </br> <input type="text" name="nrtel" /><br />
    Adres: <br /> <input type="text" name="adres" /><br />
    Kod pocztowy: <br /> <input type="text" name="postcode" /><br />
    Miasto: <br /> <input type="text" name="miasto" /><br />
    <br /><button type="submit" name="wyslij">Złóż zamówienie</button>
  </form>
  <?php
  $total_price = 0;
  $data = date("Y-m-d");

  if (isset($_POST['wyslij'])) {


    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $nrtel = $_POST['nrtel'];
    $adres = $_POST['adres'];
    $pkod = $_POST['postcode'];
    $miasto = $_POST['miasto'];
    $email = $_POST['email'];


    $polaczenie->query("INSERT INTO `klienci` VALUES(NULL,'$email')");
    $polaczenie->query("INSERT INTO `adresy_klientow` VALUES((SELECT id_klienta FROM klienci where email_klienta='$email'),'$imie','$nazwisko','$nrtel','$adres','$pkod','$miasto')");

    foreach ($_SESSION["koszyk"] as $produkt) {
      $total_price += ($produkt["cena_produktu"] * $produkt["quantity"]);
    }
    $polaczenie->query("INSERT INTO `zamowienia` Values(NULL,(SELECT id_klienta FROM klienci where email_klienta='$email'),'$total_price','$data',1)");


    //insert dane z koszyka do bazy danych
    foreach ($_SESSION["koszyk"] as $produkt) {
      $id = $produkt['id_produktu'];
      $ilosc = $produkt['quantity'];
      $nowa_ilosc_produktu = 0;
      $polaczenie->query("INSERT INTO `szczegoly_zamowienia` VALUES((SELECT id_zamowienia FROM zamowienia WHERE data_zlozenia_zamowienia='$data'),'$id','$ilosc')");

      //update magazyn - produkty
      $prd = $polaczenie->query("SELECT ilosc_w_magazynie FROM `magazyn` WHERE id_produktu='$id'");
      if ($prd->num_rows > 0) {
        while ($row = $prd->fetch_assoc()) {
          $ilosc_w_M = $row['ilosc_w_magazynie'];
          $nowa_ilosc_produktu = $ilosc_w_M - $ilosc;
          $polaczenie->query("UPDATE `magazyn`  SET ilosc_w_magazynie=$nowa_ilosc_produktu WHERE id_produktu='$id'");
        }
      }
    }
    

    

    //na końcu, wyczyszczenie koszyka
    $_SESSION["koszyk"] = array();


    echo "Dziękujemy za złożenie zamówienia";
    echo '<br/><br/><a href="sklep2.php">Powrót do sklepu</a>';


    echo $polaczenie->error;
  }

  ?>
 <?php
  echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
  ?>


  <footer>Pojekt Sklep internetowy by: Konrad Kowalczyk</footer>
</body>

</html>