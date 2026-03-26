<?php
session_start();

if (!isset($_SESSION["user_name"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["user_surname"])) {
    header("Location: index.php");
    exit();
}
if ($_COOKIE["user_name"] != "Admin" && $_COOKIE["user_surname"] != "Admin") {
    header("Location: index.php");
    exit();
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
    <h1>Modyfikuj pracowników:</h1><button onclick="window.location.href='index.php'">Powróć na strone główną</button><br><br>
    <section>
        <form action="#" method="post">
            <h2>Dodaj pracownika:</h2><br>
            <label>PESEL:</label><br>
            <input type="number" name="pesel"><br>
            <label>Imie:</label><br>
            <input type="text" name="imie"><br>
            <label>Nazwisko:</label><br>
            <input type="text" name="nazwisko"><br>
            <label>Data urodzenia:</label><br>
            <input type="date" name="data_urodzenia"><br>
            <label>Adres zamieszkania:</label><br>
            <input type="text" name="adres_zamieszkania"><br>
            <label>Numer domu:</label><br>
            <input type="text" name="numer_domu"><br>
            <label>Miasto:</label><br>
            <input type="text" name="miasto"><br>
            <label>Kod pocztowy:</label><br>
            <input type="number" name="kod_pocztowy"><br>
            <label>Hasło:</label><br>
            <input type="password" name="haslo"><br>
            <input type="submit" value="Dodaj"><br>
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                require "config.php";
                $pesel = $_POST["pesel"];
                $imie = $_POST["imie"];
                $nazwisko = $_POST["nazwisko"];
                $data_urodzenia = $_POST["data_urodzenia"];
                $adres = $_POST["adres_zamieszkania"];
                $numer_domu = $_POST["numer_domu"];
                $miasto = $_POST["miasto"];
                $kod_pocztowy = $_POST["kod_pocztowy"];
                $haslo = $_POST["haslo"];
                $haslo = password_hash($haslo, PASSWORD_DEFAULT);

                $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if ($conn->connect_error) {
                    die($conn->connect_error . " Przepraszamy!");
                }

                $stmt = $conn->prepare("INSERT INTO pracownicy (PESEL, imie, nazwisko, data_urodzenia, adres_zamieszkania, numer_domu, miasto, kod_pocztowy, haslo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssss", $pesel, $imie, $nazwisko, $data_urodzenia, $adres, $numer_domu, $miasto, $kod_pocztowy, $haslo);
                $stmt->execute();
                $stmt->close();
                $conn->close();
            }
            ?>
        </form>
    </section>
    <?php
    require "config.php";

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die($conn->connect_error." Przepraszamy!");
    }

    $stmt = $conn->prepare("SELECT imie, nazwisko FROM pracownicy WHERE imie != 'Admin' AND nazwisko != 'Admin'");
    $stmt->execute();
    $stmt->bind_result($imie , $nazwisko);
    $imienia = [];
    $nazwiska = [];
    while ($stmt->fetch()) {
        $imienia[] = $imie;
        $nazwiska[] = $nazwisko;
    }
    $stmt->close();

    foreach($imienia as $imie2) {
        foreach($nazwiska as $nazwisko2) {
        $stmt = $conn->prepare("SELECT id FROM pracownicy WHERE imie = '".$imie."' AND nazwisko = '".$nazwisko2."';");
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        echo "<article>
<h2>Imię i nazwisko: ".$imie." ".$nazwisko."</h2><a href='edit.php?type=pracownicy&id=".$id."&name=".$imie." ".$nazwisko."&table=pracownicy&columns=[PESEL, imie, nazwisko, data_urodzenia, adres_zamieszkania, numer_domu, miasto, kod_pocztowy, data_wypowiedzenia, haslo]&site=pracownicy'><button>EDYTUJ</button></a><a href='drop.php?id=".$id."&name=".$imie."&table=pracownicy&site=pracownicy'><button>USUŃ</button></a>
</article>";
    }}
    ?>
    <footer>
        <p>Copyright &copy; 2026 Kamil Łobaza. Wszelkie prawa zastrzeżone.</p>
    </footer>
</center>
</body>
</html>
