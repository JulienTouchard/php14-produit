<?php
session_start();
require_once("../inc/pdo.php");
require_once("../inc/func.php");
if(isset($_GET['sort'])){
    $order = " ORDER BY ".$_GET['sort'];
} else {
    $order = "";
}
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
}
$query = $pdo->prepare("SELECT * FROM produit".$order);
$query->execute();
$allUsers = $query->fetchAll();


include_once("./headerBack.php");
//debug($allUsers);
$i = 0;
?>
<a href="./newProd.php"><button>Nouveau Produit</button></a>
<table id="allUsers">
    <thead>
        <th><a href="?sort=id">id</a></th>
        <th><a href="?sort=name">name</a></th>
        <th><a href="?sort=img">img</a></th>
        <th><a href="?sort=price">price</a></th>
        <th><a href="?sort=description">description</a></th>
        <th>show</th>
        <th>update</th>
        <th>delete</th>
    </thead>
    <?php while ($i < count($allUsers)) : ?>
        <tr>
            <td><?= $allUsers[$i]['id']; ?>
            <td><?= $allUsers[$i]['name']; ?>
            <td><?= $allUsers[$i]['img']; ?>
            <td><?= $allUsers[$i]['price']; ?>
            <td><?= $allUsers[$i]['description']; ?>
            <td><a href="./showProd.php?id=<?= $allUsers[$i]['id']; ?>"><button>show</button></a>
            <td><a href="./updateProd.php?id=<?= $allUsers[$i]['id']; ?>"><button>update</button></a>
            <td><a href="./deleteProd.php?id=<?= $allUsers[$i]['id']; ?>"><button>delete</button></a>
        </tr>
    <?php
        $i++;
    endwhile;

    include_once("./footerBack.php");
