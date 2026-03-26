<?php
session_start();
require 'config.php';
$id = $_GET['id'];
$name = $_GET["name"];
$table = $_GET["table"];
$site = $_GET["site"];

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die ($conn->connect_error." Przepraszamy!");
}

$stmt = $conn->prepare("DELETE FROM ".$table." WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->close();
$conn->close();
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
    document.getElementById("wynik").innerHTML = "Pomyślnie usunięto <?php echo htmlspecialchars($name) ?>! Przekierowanie za 2s";
    setTimeout(function(){window.location.href = "<?php echo htmlspecialchars($site) ?>.php"}, 2000)
</script>
</body>
</html>
