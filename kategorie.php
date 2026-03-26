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
    <h1>Modyfikuj kategorie produktów.</h1><button onclick="window.location.href='index.php'">Powróć na strone główną</button><br><br>
    <section>
        <form action="#" method="post">
            <h2>Dodaj kategorię:</h2><br>
            <label>Nazwa kategorii:</label><br>
            <input type="text" name="kategoria" id="kategoria"><br>
            <input type="submit" value="Utwórz"><br>
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                require "config.php";
                $category = $_POST["kategoria"];

                $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if ($conn->connect_error) {
                    die($conn->connect_error . " Przepraszamy!");
                }

                $stmt = $conn->prepare("INSERT INTO kategorie_produktow (nazwa_kategorii) VALUES (?)");
                $stmt->bind_param("s", $category);
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

    $stmt = $conn->prepare("SELECT nazwa_kategorii FROM kategorie_produktow");
    $stmt->execute();
    $stmt->bind_result($nazwy_kategorii);
    $kategorie = [];
    while ($stmt->fetch()) {
        $kategorie[] = $nazwy_kategorii;
    }
    $stmt->close();

    foreach($kategorie as $kategoria) {
        $stmt = $conn->prepare("SELECT id FROM kategorie_produktow WHERE nazwa_kategorii = '".$kategoria."';");
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        echo "<article>
<h2>Nazwa kategorii: ".$kategoria."</h2><a href='edit.php?type=kategorie&id=".$id."&name=".$kategoria."&table=kategorie_produktow&column=nazwa_kategorii&site=kategorie'><button>EDYTUJ</button></a><a href='drop.php?id=".$id."&name=".$kategoria."&table=kategorie_produktow&site=kategorie'><button>USUŃ</button></a>
</article>";
    }
    ?>
    <footer>
        <p>Copyright &copy; 2026 Kamil Łobaza. Wszelkie prawa zastrzeżone.</p>
    </footer>
</center>
</body>
</html>
