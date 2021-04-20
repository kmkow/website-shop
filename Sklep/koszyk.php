<?php
session_start();
require "connect.php";
$status = "";
if (isset($_POST['action']) && $_POST['action'] == "usun") {
    if (!empty($_SESSION["koszyk"])) {
        foreach ($_SESSION["koszyk"] as $key => $value) {
            if ($_POST["id_produktu"] == $key) {
                unset($_SESSION["koszyk"][$key]);
                $status = "<div class='box' style='color:red;'>Produkt został usunięty z koszyka</div>";
            }
            if (empty($_SESSION["koszyk"])) unset($_SESSION["koszyk"]);
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION["koszyk"] as &$value) {
        if ($value['id_produktu'] === $_POST["id_produktu"]) {
            $value['quantity'] = $_POST["quantity"];
            break;
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
    <h2>Twój koszyk: </h2>
    <a href="sklep2.php">Powrót do sklepu</a><br/>

    <form method="POST">
        <input type="hidden" name="action" value="wyczysc" />
        <button type="submit" class="wycz">Wyczyść koszyk</button>
    </form>
    <div class="cart">
        <?php
        if (isset($_SESSION["koszyk"])) {
            $total_price = 0;
        ?>
            <table class="table">
                <tbody>
                    <tr>

                        <td>Nazwa produktu:</td>
                        <td>Ilość: </td>
                        <td>Cena produktu:</td>
                        <td>Łącznie:</td>
                    </tr>
                    <?php
                    foreach ($_SESSION["koszyk"] as $produkt) {
                    ?>
                        <tr>

                            <td><?php echo $produkt["nazwa_produktu"]; ?><br />
                                <form method='post' action=''>
                                    <input type='hidden' name='id_produktu' value="<?php echo $produkt["id_produktu"]; ?>" />
                                    <input type='hidden' name='action' value="usun" />
                                    <button type='submit' class='usun'>Usuń z koszyka</button>
                                </form>
                            </td>
                            <td>
                                <form method='post' action=''>
                                    <input type='hidden' name='id_produktu' value="<?php echo $produkt["id_produktu"]; ?>" />
                                    <input type='hidden' name='action' value="change" />
                                    <select name='quantity' class='quantity' onChange="this.form.submit()">
                                        <option <?php if ($produkt["quantity"] == 1) echo "selected"; ?> value="1">1</option>
                                        <option <?php if ($produkt["quantity"] == 2) echo "selected"; ?> value="2">2</option>
                                        <option <?php if ($produkt["quantity"] == 3) echo "selected"; ?> value="3">3</option>
                                        <option <?php if ($produkt["quantity"] == 4) echo "selected"; ?> value="4">4</option>
                                        <option <?php if ($produkt["quantity"] == 5) echo "selected"; ?> value="5">5</option>
                                        <option <?php if ($produkt["quantity"] == 6) echo "selected"; ?> value="6">6</option>
                                        <option <?php if ($produkt["quantity"] == 7) echo "selected"; ?> value="7">7</option>
                                        <option <?php if ($produkt["quantity"] == 8) echo "selected"; ?> value="8">8</option>
                                        <option <?php if ($produkt["quantity"] == 9) echo "selected"; ?> value="9">9</option>
                                        <option <?php if ($produkt["quantity"] == 10) echo "selected"; ?> value="10">10</option>
                                    </select>
                                </form>
                            </td>
                            <td><?php echo  $produkt["cena_produktu"] . " PLN"; ?></td>
                            <td><?php echo  $produkt["cena_produktu"] * $produkt["quantity"] . " PLN"; ?></td>
                        </tr>
                    <?php
                        $total_price += ($produkt["cena_produktu"] * $produkt["quantity"]);
                    }
                    ?>
                    <tr>
                        <td colspan="5" align="right">
                            <strong>Łączna cena: <?php echo $total_price . "PLN"; ?></strong>
                            <form method="POST" action="zamowienie.php">
                    <input type="submit" value="Potwierdz i złóż zamówienie"/>
                </form>
                        </td>
                    </tr>
                </tbody>
                
            </table>
        <?php
        } else {
            echo "<h3>Koszyk jest pusty</h3>";
        }
        ?>
    </div>

    <div style="clear:both;"></div>

    <div class="message_box" style="margin:10px 0px;">
        <?php echo $status; ?>
    </div>
    <footer>Pojekt Sklep internetowy by: Konrad Kowalczyk</footer>
</body>

</html>