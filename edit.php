<?php
session_start();
require 'config.php';
$type = $_GET["type"];
$site = $_GET["site"];

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die ($conn->connect_error." Przepraszamy!");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baza sklepik</title>
    <link rel="icon" href="icon.jpg">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<center>
<a href="<?php echo htmlspecialchars($site)?>.php"><button>Wróć <-</button></a>
    <?php
    if($type == "kategorie"){
        $name = $_GET["name"];
        $table = $_GET["table"];
        $id = $_GET["id"];
    echo "
    <form action='edit_complete.php?type=kategorie&id=".$id."&name=".$name."&table=kategorie_produktow&column=nazwa_kategorii&site=kategorie' method='post'>
        <h2>Edytuj nazwę kategorii ".$name.": </h2><br><br>
        <label>Nazwa kategorii:</label><br>
        <input type='text' name='nazwa'><br><br>
        <input type='submit' value='Edytuj'>
    </form>
    ";}
    if ($type == "pracownicy"){
        $name = $_GET["name"];
        $table = $_GET["table"];
        $id = $_GET["id"];
        echo "<form action='edit_complete.php?type=pracownicy&id=".$id."&name=".$name."&table=pracownicy&columns=[PESEL, imie, nazwisko, data_urodzenia, adres_zamieszkania, numer_domu, miasto, kod_pocztowy, data_wypowiedzenia, haslo]&site=pracownicy' method='post'>
        <h2>Edytuj pracownika ".$name.": </h2><br><br>
        <label>PESEL:</label><br>
        <input type='text' name='pesel'><br><br>
        <label>Imię:</label><br>
        <input type='text' name='imie'><br><br>
        <label>Nazwisko:</label><br>
        <input type='text' name='nazwisko'><br><br>
        <label>Data urodzenia:</label><br>
        <input type='date' name='data_urodzenia'><br><br>
        <label>Adres zamieszkania:</label><br>
        <input type='text' name='adres_zamieszkania'><br><br>
        <label>Numer domu:</label><br>
        <input type='text' name='numer_domu'><br><br>
        <label>Miasto:</label><br>
        <input type='text' name='miasto'><br><br>
        <label>Kod pocztowy:</label><br>
        <input type='number' name='kod_pocztowy'><br><br>
        <label>Hasło:</label><br>
        <input type='password' name='haslo'><br><br>
        <label>Data wypowiedzenia</label><br>
        <input type='date' name='data_wypowiedzenia'><br><br>
        <input type='submit' value='Edytuj'>
    </form>";
    }
    if($type == "faktury"){
        $name = $_GET["name"];
        $table = $_GET["table"];
        $id = $_GET["id"];
        echo '<form action="edit_complete.php?type=faktury&id='.$id.'&name='.$name.'&table=faktury&site='.$site.'" method="post">
            <h2>Edytuj fakturę '.$name.':</h2><br>
            <label>Numer faktury:</label><br>
            <input type="text" name="numer_faktury"><br>
            <label>Data opłacenia faktury:</label><br>
            <input type="date" name="data_oplacenia"><br>
            <label>Status:</label><br>
            <input type="text" name="status_2"><br>
            <label>Sprzedawca:</label><br>
            <input type="text" name="sprzedawca"><br>
            <label>Nabywca:</label><br>
            <input type="text" name="nabywca"><br>
            <input type="submit" value="Edytuj"><br>';
    }
    ?>
</center>
</body>
</html>
