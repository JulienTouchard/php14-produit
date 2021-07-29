<?php
session_start();
require_once("../inc/pdo.php");
require_once("../inc/func.php");
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    header("Location: ../admin.php");
}
$query = $pdo->prepare("DELETE FROM user WHERE id = $id");
$query->execute();
$user = $query->fetch();
header("Location: ../admin.php");