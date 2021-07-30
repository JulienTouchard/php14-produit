<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}
require('../inc/func.php');
require('../inc/pdo.php');
require('../../vendor/autoload.php');
use \Gumlet\ImageResize;

if (!empty($_POST['submitted'])) {
    $errors = [];
    // traitement du formulaire
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
    // valid text
    $errors = validText($errors, $_POST['name'], 'name', 5, 30);
    $errors = validText($errors, $_POST['description'], 'description', 5, 10000);

    // verif image
    if ($_FILES['img']['size'] === 0) {
        $errors['img'] = "Image obligatoire";
    } else {
        $tabTypImg = ["image/jpg","image/jpeg","image/png","image/webp"];
        $boolImg = false;
        for ($i=0; $i <count($tabTypImg) ; $i++) { 
            if($_FILES['img']['type'] === $tabTypImg[$i]){
                $boolImg = true;
            }
        }
        $boolImg ? : $errors['img'] = "Le format n'est pas bon";

        if ($_FILES['img']['size'] >= 2000000) {
            $errors['img'] = "Le fichier fait plus de 2 Mo";
        }
    }
    // detecttion du prix
    $_POST['prix'] = intval($_POST['prix']);
    if($_POST['prix'] <= 1 ){
        $errors['prix'] = "Votre prix n'est pas cohérent";
    }
    
    if (count($errors) === 0) {
        // traitement pdo

        $sql = "INSERT INTO produit (name,img,price,description)
        VALUES (:name,:img,:price,:description)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $query->bindValue(':img', "./asset/upload/" . $_FILES['img']['name'], PDO::PARAM_STR);
        $query->bindValue(':price', $_POST['prix'], PDO::PARAM_INT);
        $query->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $query->execute();
        
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
        header("Location: ./produits.php");

    } else {
        // tout ne s'est pas bien passé
        header("Location: ./newProd.php?errors=".serialize($errors)."&data=".serialize($_POST));
    }
    debug($_FILES);
    debug($errors);
    debug($_POST);
    die;
} else {
    // n'a pas acces à cette page
    header("Location: ../index.php");
}
