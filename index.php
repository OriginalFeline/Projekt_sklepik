<?php
session_start();
require "config.php";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

if (isset($_COOKIE["user_id"]) && isset($_COOKIE["user_name"]) && isset($_COOKIE["user_surname"])) {
    $_SESSION["user_id"] = $_COOKIE["user_id"];
    $_SESSION["user_name"] = $_COOKIE["user_name"];
    $_SESSION["user_surname"] = $_COOKIE["user_surname"];
    echo "<p style='color:green;'>Zalogowano pomyślnie! Przekierowanie w ciągu 2 sekund...</p>";
    echo "<script>setTimeout(function(){ window.location = 'dashboard.php'; }, 2000);</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baza Sklepik</title>
    <link rel="icon" href="icon.jpg">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="container">
    <form action="#" method="post">
        <h2>Logowanie do bazy:</h2>
        <label for="name">Imie:</label><br>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="surname">Nazwisko:</label><br>
        <input type="text" id="surname" name="surname" required>
        <br><br>
        <label for="password">Hasło:</label><br>
        <input type="password" id="password" name="password" required>
        <br><br>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT id, imie, nazwisko, haslo FROM pracownicy WHERE imie = ? AND nazwisko = ?");
        $stmt->bind_param("ss", $name, $surname);
        $stmt->execute();
        $stmt->bind_result($db_id, $db_name, $db_surname, $db_password);
        $stmt->fetch();
        $stmt->close();

        if ($db_name && $db_surname && $db_password && password_verify($password, $db_password)) {
            $_SESSION["user_id"] = $db_id;
            $_SESSION["user_name"] = $db_name;
            $_SESSION["user_surname"] = $db_surname;

            setcookie("user_id", $db_id, time() + (86400 * 30), "/");
            setcookie("user_name", $db_name, time() + (86400 * 30), "/");
            setcookie("user_surname", $db_surname, time() + (86400 * 30), "/");

            $conn->close();

            echo "<p style='color:green;'>Zalogowano pomyślnie! Przekierowanie w ciągu 2 sekund...</p>";
            echo "<script>setTimeout(function(){ window.location = 'dashboard.php'; }, 2000);</script>";
            exit();
        } else {
            echo "<p style='color:red;'>Nieprawidłowe dane logowania. Spróbuj ponownie.</p>";
        }} else {
            echo "<p></p>";
        }
        ?>
        <input type="submit" value="Zaloguj">
    </form>
</div>
    <footer>
        <p>Copyright &copy; 2026 Kamil Łobaza. Wszelkie prawa zastrzeżone.</p>      
    </footer>
</body>
</html>