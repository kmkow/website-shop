<?php
session_start();
require "connect.php";
$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

$status = "";
if (isset($_POST['id_produktu']) && $_POST['id_produktu'] != "") {
    $id_produktu = $_POST['id_produktu'];
    $result = mysqli_query(
        $polaczenie,
        "SELECT * FROM produkt WHERE id_produktu='$id_produktu'"
    );
    $row = mysqli_fetch_assoc($result);
    $nazwa_produktu = $row['nazwa_produktu'];
    $id_produktu = $row['id_produktu'];
    $cena_produktu = $row['cena_produktu'];


    $koszykT = array(
        $id_produktu => array(
            'nazwa_produktu' => $nazwa_produktu,
            'id_produktu' => $id_produktu,
            'cena_produktu' => $cena_produktu,
            'quantity' => 1,

        )
    );

    if (empty($_SESSION["koszyk"])) {
        $_SESSION["koszyk"] = $koszykT;
        $status = "<div class='box'>Produkt został dodany do koszyka</div>";
    } else {
        $array_keys = array_keys($_SESSION["koszyk"]);
        if (in_array($id_produktu, $array_keys)) {
            $status = "<div class='box' style='color:red;'>
 Produkt już jest w koszyku</div>";
        } else {
            $_SESSION["koszyk"] = array_merge(
                $_SESSION["koszyk"],
                $koszykT
            );
            $status = "<div class='box'>Produkt został dodany do koszyka</div>";
        }
    }
}
if (isset($_POST['action']) && $_POST['action'] == "wyczysc") {
    $_SESSION["koszyk"] = array();
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
    <div class="parent">
        <div class="kategorie1">
            <h3>Wybierz kategorie:</h3>
            <form method="POST">
            <hr><label><input type="checkbox" name="formDoor[]" value="0" checked>Wszystkie przedmioty </label><hr><br/>

            <?php
                $licznik=1;
                $kategorie=$polaczenie->query("SELECT * FROM kategorie");
                if($kategorie->num_rows>0){
                    while($kategoria=$kategorie->fetch_assoc()){
                        echo '<hr><label><input type="checkbox" name="formDoor[]" value="'.$licznik.'">'.$kategoria['nazwa_kategorii'].'</label><hr><br/>';
                        $licznik++;
                    }
                }
            ?>
            <input type="submit" name="formSubmit" value="Potwierdź kategorie"/>
            </form>
            <?php //wybierz kategorie
                if(!isset($_POST['formDoor'])){
                    $_POST['formDoor']=0;
                    
                }
            ?>
        </div>



        <div class="items"> <?php


    $mquery="SELECT * FROM produkt p INNER JOIN magazyn m ON p.id_produktu=m.id_produktu INNER JOIN kategorie k ON k.id_kategoria=p.id_kategoria";

                            $result = mysqli_query($polaczenie, $mquery);
                            while ($row = mysqli_fetch_assoc($result)) {

                                $malo_w_magazynie="";
                                if($row['ilosc_w_magazynie']<10){
                                    $malo_w_magazynie="Ilość w magazynie: ".$row['ilosc_w_magazynie'];
                                }
                                if ($row['ilosc_w_magazynie'] > 0){
                                    
                                    echo "<div class='produkt'>
    <form method='post' action=''>
    <input type='hidden' name='id_produktu' value=" . $row['id_produktu'] . " />
    <div class='nazwa_produktu'><h3>" . $row['nazwa_produktu'] . "</h3></div><br/>
    <div class='opis_p'>" . $row['opis_produktu'] . "</div><br/>
    <div class='cena_produktu'>" . $row['cena_produktu'] . " zł</div><br/>".$malo_w_magazynie."<br/>
    <button type='submit' class='doddokoszyka'>Dodaj do koszyka</button>
    </form>
    </div>";
                                }
                            }
                            mysqli_close($polaczenie);
                            ?>

            <div style="clear:both;"></div>

            <div class="message_box" style="margin:10px 0px;">
                <?php echo $status; ?>
            </div>
        </div>



        <div class="nagl"> </div>


        <div class="kosz">
            <?php
            if (!empty($_SESSION["koszyk"])) {
                $cart_count = count(array_keys($_SESSION["koszyk"]));
            ?>
                <div class="cart_div">
                    <a href="koszyk.php"> <br/><img src="cart-icon.png" width="25px" height="25px"/>Koszyk (<span>
                            <?php echo $cart_count; ?>)</span></a>
                   <br/> <form method="POST">
                        <input type="hidden" name="action" value="wyczysc" /><br/>
                        <button type="submit" class="wycz">Wyczyść koszyk</button>
                    </form>
                </div>
            <?php
            }
            ?>
        </div>




        <div class="logo">
            <h1>SKLEP INTERNETOWY </h1>
            <h4>Konrad Kowalczyk 36334 ID-2/III </h4>
            <i>"Sklep bo sprzedajesz? -Nie, bo lubie sklepać"</i> - Sklep 
        </div>
    </div>









    <footer>Pojekt Sklep internetowy by: Konrad Kowalczyk</footer>
</body>

</html>