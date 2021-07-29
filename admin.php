<?php
session_start();
require_once("./inc/pdo.php");
require_once("./inc/func.php");
if(isset($_GET['sort'])){
    $order = " ORDER BY ".$_GET['sort'];
} else {
    $order = "";
}
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
}
$query = $pdo->prepare("SELECT * FROM user".$order);
$query->execute();
$allUsers = $query->fetchAll();


include_once("./inc/header.php");
//debug($allUsers);
$i = 0;
?>
<table id="allUsers">
    <thead>
        <th><a href="?sort=id">id</a></th>
        <th><a href="?sort=name">name</a></th>
        <th><a href="?sort=email">email</a></th>
        <th><a href="?sort=role">role</a></th>
        <th><a href="?sort=created_at">created_at</a></th>
        <th>show</th>
        <th>update</th>
        <th>delete</th>
    </thead>
    <?php while ($i < count($allUsers)) : ?>
        <tr>
            <td><?= $allUsers[$i]['id']; ?>
            <td><?= $allUsers[$i]['name']; ?>
            <td><?= $allUsers[$i]['email']; ?>
            <td><?= $allUsers[$i]['role']; ?>
            <td><?= $allUsers[$i]['created_at']; ?>
            <td><a href="./back/show.php?id=<?= $allUsers[$i]['id']; ?>"><button>show</button></a>
            <td><a href="./back/update.php?id=<?= $allUsers[$i]['id']; ?>"><button>update</button></a>
            <td><a href="./back/delete.php?id=<?= $allUsers[$i]['id']; ?>"><button>delete</button></a>
        </tr>
    <?php
        $i++;
    endwhile;

    include_once("./inc/footer.php");
