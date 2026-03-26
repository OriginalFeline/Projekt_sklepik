<?php
session_start();
require 'config.php';
$type = $_GET['type'];

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die ($conn->connect_error." Przepraszamy!");
}

if ($type == 'kategorie'){
    $name = $_GET["name"];
    $table = $_GET["table"];
    $site = $_GET["site"];
    $column = $_GET["column"] || $columns = $_GET["columns"] ?? [];
    $id = $_GET["id"];
    $nazwa = $_POST["nazwa"];
$stmt = $conn->prepare("UPDATE $table SET $column = '$nazwa' WHERE id = '$id' ");
$stmt->execute();
$stmt->close();
$conn->close();
}

if($type == "pracownicy"){
    $name = $_GET["name"];
    $table = $_GET["table"];
    $site = $_GET["site"];
    $columns = $_GET["columns"] ?? [];
    $id = $_GET["id"];
    $pesel = $_POST["pesel"];
    $imie = $_POST["imie"];
    $nazwisko = $_POST["nazwisko"];
    $data_urodzenia = $_POST["data_urodzenia"];
    $adres_zamieszkania = $_POST["adres_zamieszkania"];
    $numer_domu = $_POST["numer_domu"];
    $miasto = $_POST["miasto"];
    $kod_pocztowy = $_POST["kod_pocztowy"];
    $haslo = $_POST["haslo"];
    $haslo = password_hash($_POST["haslo"], PASSWORD_DEFAULT);
    $data_wypowiedzenia = $_POST["data_wypowiedzenia"];
    $stmt = $conn->prepare("UPDATE ".$table." SET PESEL = '".$pesel."', imie = '".$imie."', nazwisko = '".$nazwisko."', data_urodzenia = '".$data_urodzenia."', adres_zamieszkania = '".$adres_zamieszkania."', numer_domu = '".$numer_domu."', miasto = '".$miasto."', kod_pocztowy = '".$kod_pocztowy."', haslo = '".$haslo."', data_wypowiedzenia = '".$data_wypowiedzenia."' WHERE id = '$id'");
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

if($type == "faktury"){
    $name = $_GET["name"];
    $table = $_GET["table"];
    $site = $_GET["site"];
    $id = $_GET["id"];
    $numer_faktury = $_POST["numer_faktury"];
    $data_oplacenia = $_POST["data_oplacenia"];
    $status_2 = $_POST["status_2"];
    $sprzedawca = $_POST["sprzedawca"];
    $nabywca = $_POST["nabywca"];
    $stmt = $conn->prepare("UPDATE ".$table." SET numer_faktury = '".$numer_faktury."', data_oplacenia = '".$data_oplacenia."', status_2 = '".$status_2."', sprzedawca = '".$sprzedawca."', nabywca = '".$nabywca."' WHERE id = '$id'");
    $stmt->execute();
    $stmt->close();
    $conn->close();
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
<p id="wynik" style="color: green;"></p>
<script>
    document.getElementById("wynik").innerHTML = "Pomyślnie zmodyfikowano <?php echo htmlspecialchars($name) ?>! Przekierowanie za 2s";
    setTimeout(function(){window.location.href = "<?php echo htmlspecialchars($site) ?>.php"}, 2000)
</script>
</body>
</html>
