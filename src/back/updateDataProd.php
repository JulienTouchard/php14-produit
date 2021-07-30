<?php
session_start();
// protection de la page
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}
require_once("../inc/pdo.php");
require_once("../inc/func.php");
require('../../vendor/autoload.php');
use \Gumlet\ImageResize;


if (!empty($_POST['submitted'])) {
    // creation du tableau d'erreur
    $errors = [];
    // existance d'une nouvelle image
    $boolImg = false;
    // get id
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header("Location: ./produits.php");
    }
    // traitement du formulaire xss
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
    // valid text
    $errors = validText($errors, $_POST['name'], 'name', 5, 30);
    $errors = validText($errors, $_POST['description'], 'description', 5, 10000);

    // verif image

    if ($_FILES['img']['size'] > 0) {
        $tabTypImg = ["image/jpg", "image/jpeg", "image/png", "image/webp"];

        for ($i = 0; $i < count($tabTypImg); $i++) {
            if ($_FILES['img']['type'] === $tabTypImg[$i]) {
                $boolImg = true;
            }
        }
        $boolImg ?: $errors['img'] = "Le format n'est pas bon";


        if ($_FILES['img']['size'] >= 2000000) {
            $errors['img'] = "Le fichier fait plus de 2 Mo";
        }
    }
    // detecttion du price
    $_POST['price'] = intval($_POST['price']);
    if ($_POST['price'] <= 1) {
        $errors['price'] = "Votre price n'est pas cohérent";
    }
    if (count($errors) === 0) {

        // récup des anciennes données utilisateur
        $query = $pdo->prepare("SELECT * FROM produit WHERE id = :id");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();

        // verification du changement d'image
        if ($boolImg) {
            $imgUrl = "./asset/upload/" . $_FILES['img']['name'];
            $newImgName = explode(".",$_FILES['avatar']['img']);
            $imgUrl = $newImgName[0];
        } else {
            $imgUrl = $result['img'];
        }

        // traitement pdo update
        $sql = "UPDATE produit SET name = :name , price = :price, name = :name, img = :img WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $query->bindValue(':price', $_POST['price'], PDO::PARAM_STR);
        $query->bindValue(':img', $imgUrl, PDO::PARAM_STR);
        $query->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        if ($boolImg) {
            if (!is_dir("../asset/upload")) {
                mkdir("../asset/upload");
            }
            move_uploaded_file($_FILES['img']['tmp_name'], "../asset/upload/" . $_FILES['img']['name']);
            imageManager( 
                $_FILES['img'],
                "../asset/",
                500,
                50,
                "produit",
                new ImageResize("../asset/upload/" . $_FILES['img']['name'])
            );
            // tout c'est bien passé
        }
        header("Location: ./produits.php");
    } else {
        // tout ne s'est pas bien passé
        header("Location: ./updateProd.php?id=$id&errors=" . serialize($errors) . "&data=" . serialize($_POST));
    }
    die;
} else {
    // n'a pas acces à cette page
    header("Location: ../index.php");
}
