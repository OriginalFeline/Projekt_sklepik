<?php
session_start();

if (!isset($_SESSION["user_name"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["user_surname"])) {
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
    <h1>Witaj <?php echo htmlspecialchars($_SESSION["user_name"] . " " . $_SESSION["user_surname"]); ?> w Bazie Sklepiku!</h1><button onclick="window.location.href='logout.php'">Wyloguj się</button><br><br>
        <?php
        if ($_COOKIE["user_name"] == "Admin" && $_COOKIE["user_surname"] == "Admin") {
            echo "<div class='admin'>
                    <h6>Strefa Admina:</h6>
                    <a href='pracownicy.php'><button class='bloki'>Pracownicy</button></a>
                    <a href='kategorie.php'><button class='bloki'>Kategorie</button></a>
                  </div><br><br>";
        }
        ?>
        <a href="faktury.php"><button class="bloki">Faktury</button></a>
        <a href="sprzedaze.php"><button class="bloki">Sprzedaże</button></a>
        <a href="magazyn.php"><button class="bloki">Magazyn</button></a>
        <a href="zamowienia.php"><button class="bloki">Zamówienia</button></a>
    <footer>
        <p>Copyright &copy; 2026 Kamil Łobaza. Wszelkie prawa zastrzeżone.</p>      
    </footer>
</center>
</body>
</html>