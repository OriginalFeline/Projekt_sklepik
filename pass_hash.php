<?php
session_start();
require "config.php";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}


$name = "Admin";
$surname = "Admin";
$password = password_hash("@0102Limak@", PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO pracownicy (imie, nazwisko, haslo) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $surname, $password);
$stmt->execute();
$stmt->close();
$conn->close();

die("Hasło zostało zahashowane i zapisane w bazie danych.");
?>