<?php
session_start();
require('../../vendor/autoload.php');
use \Gumlet\ImageResize;

require_once("../inc/pdo.php");
require_once("../inc/func.php");
// protection de la page
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}

if (!empty($_POST['submitted'])) {
    // creation du tableau d'erreur
    $errors = [];
    // existance d'une nouvelle image
    $boolImg = false;
    // get id
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        header("Location: ../admin.php");
    }
    // traitement du formulaire xss
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
    // valid text
    $errors = validText($errors, $_POST['pwd'], 'pwd', 5, 8, false);
    $errors = validText($errors, $_POST['name'], 'name', 5, 10);
    // valid email
    $errors = validEmail($errors, $_POST['email']);

    // verif image

    if ($_FILES['avatar']['size'] > 0) {
        $tabTypImg = ["image/jpg", "image/jpeg", "image/png", "image/webp"];

        for ($i = 0; $i < count($tabTypImg); $i++) {
            if ($_FILES['avatar']['type'] === $tabTypImg[$i]) {
                $boolImg = true;
            }
        }
        $boolImg ? : $errors['avatar'] = "Le format n'est pas bon";


        if ($_FILES['avatar']['size'] >= 2000000) {
            $errors['avatar'] = "Le fichier fait plus de 2 Mo";
        }
    }

    if (count($errors) === 0) {

        // récup des anciennes données utilisateur
        $query = $pdo->prepare("SELECT * FROM user WHERE id = :id");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();

        // verification d'un changement de mot de pass
        if ($_POST['pwd'] === "") {
            $pwd = $result['pwd'];
        } else {
            //hash password
            $pwd = password_hash($_POST['pwd'], PASSWORD_ARGON2I);
        }
        
        // verification du changement d'image
        if ($boolImg) {
            $newImgName = explode(".",$_FILES['avatar']['name']);
            $imgUrl = $newImgName[0];
        } else {
            $imgUrl = $result['avatar'];
        }

        // traitement pdo update
        $sql = "UPDATE user SET email = :email , pwd = :pwd, name = :name, avatar = :avatar WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':pwd', $pwd, PDO::PARAM_STR);
        $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $query->bindValue(':avatar', $imgUrl, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        $query->execute();

        if ($boolImg) {

            move_uploaded_file($_FILES['avatar']['tmp_name'], "../asset/upload/" . $_FILES['avatar']['name']);
            imageManager( 
                $_FILES['avatar'],
                "../asset/",
                300,
                50,
                "avatar",
                new ImageResize("../asset/upload/" . $_FILES['avatar']['name'])
            );
        }
        header("Location: ../admin.php");
    } else {
        // tout ne s'est pas bien passé
        header("Location: ./update.php?id=$id&errors=" . serialize($errors) . "&data=" . serialize($_POST));
    }
    die;
} else {
    // n'a pas acces à cette page
    header("Location: ../index.php");
}
