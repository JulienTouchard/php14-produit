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
    header("Location: ../produits.php");
}
$query = $pdo->prepare("SELECT * FROM produit WHERE id = $id");
$query->execute();
$user = $query->fetch();

// afficher les données d'un utilisateur
include_once("./headerBack.php");
?>

<div class="card">
    <div class="headerImg">
        <img src=".<?= $user['img']; ?>" alt="">
    </div>
    <div class="cardTitle">
        <?= $user['name']; ?>
    </div>
    <div class="cardText">
        <?= $user['price']; ?>
    </div>
    <div class="cardText">
        <?= $user['description']; ?>
    </div>
</div>

<?php
include_once("./footerBack.php");