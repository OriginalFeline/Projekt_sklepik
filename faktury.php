
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
    <h1>Modyfikuj faktury.</h1><button onclick="window.location.href='index.php'">Powróć na strone główną</button><button>Dodaj produkty do faktury</button><br><br>
    <section>
        <form action="#" method="post">
            <h2>Dodaj fakturę:</h2><br>
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
            <input type="submit" value="Utwórz"><br>
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                require "config.php";
                $numer_faktury = $_POST["numer_faktury"];
                $data_oplacenia = $_POST["data_oplacenia"];
                $status_2 = $_POST["status_2"];
                $sprzedawca = $_POST["sprzedawca"];
                $nabywca = $_POST["nabywca"];

                $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if ($conn->connect_error) {
                    die($conn->connect_error . " Przepraszamy!");
                }

                $stmt = $conn->prepare("INSERT INTO faktury (numer_faktury, data_oplacenia, status_2, sprzedawca, nabywca) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $numer_faktury, $data_oplacenia, $status_2, $sprzedawca, $nabywca);
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

    $stmt = $conn->prepare("SELECT numer_faktury FROM faktury");
    $stmt->execute();
    $stmt->bind_result($faktura);
    $faktury = [];
    while ($stmt->fetch()) {
        $faktury[] = $faktura;
    }
    $stmt->close();

    foreach($faktury as $faktura) {
        $stmt = $conn->prepare("SELECT id FROM faktury WHERE numer_faktury = '".$faktura."';");
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        echo "<article>
<h2>Numer faktury: ".$faktura."</h2><a href='edit.php?type=faktury&id=".$id."&name=".$faktura."&table=faktury&site=faktury'><button>EDYTUJ</button></a><a href='drop.php?id=".$id."&name=".$faktura."&table=faktury&site=faktury'><button>USUŃ</button></a>
</article>";
    }
    ?>
    <footer>
        <p>Copyright &copy; 2026 Kamil Łobaza. Wszelkie prawa zastrzeżone.</p>
    </footer>
</center>
</body>
</html>