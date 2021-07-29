<?php
require('func.php');
require('pdo.php');

if (!empty($_POST['submitted'])) {
    $errors = [];
    // traitement du formulaire
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
    // valid text
    //$errors = validText($errors, $_POST['pwd'], 'pwd', 8, 15);
    // utilisation des regex
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W])[A-Za-z0-9\W]{8,15}$/";
    if(!preg_match($pattern,$_POST['pwd'])){
        $errors['pwd'] = "Votre mot de pass n'est pas conforme";
    }
    $errors = validText($errors, $_POST['name'], 'name', 5, 10);
    // valid email
    $errors = validEmail($errors, $_POST['email']);
    // valid checkbox
    if (empty($_POST['mentions'])) {
        $errors['mentions'] = "Conditions obligatoires";
    }
    // verif image
    if ($_FILES['avatar']['size'] === 0) {
        $errors['avatar'] = "Image obligatoire";
    } else {
        $tabTypImg = ["image/jpg","image/jpeg","image/png","image/webp"];
        $boolImg = false;
        for ($i=0; $i <count($tabTypImg) ; $i++) { 
            if($_FILES['avatar']['type'] === $tabTypImg[$i]){
                $boolImg = true;
            }
        }
        $boolImg ? : $errors['avatar'] = "Le format n'est pas bon";

        /* if ($_FILES['avatar']['type'] === "image/jpg" || $_FILES['avatar']['type'] === "image/jpeg" || $_FILES['avatar']['type'] === "image/png" || $_FILES['avatar']['type'] === "image/webp") {
            //success
            var_dump("success",getimagesize($_FILES['avatar']['tmp_name']));
            // commit        
        } else {
            $errors['avatar'] = "Le format n'est pas bon";
        } */


        if ($_FILES['avatar']['size'] >= 2000000) {
            $errors['avatar'] = "Le fichier fait plus de 2 Mo";
        }
    }
    // detection d'un email dejà présent dans la table
    $query = $pdo->prepare("SELECT email FROM user WHERE email = :email");
    $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    if($result){
        $errors['double'] = "Cet email est déjà enregistré";
    }

    if (count($errors) === 0) {
        //hash password
        $pwd = password_hash($_POST['pwd'],PASSWORD_ARGON2I);
        // traitement pdo
        $sql = "INSERT INTO user (email,pwd,name,avatar,created_at,role)
        VALUES (:email,:pwd,:name,:avatar,NOW(),'ROLE_USER')";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':pwd', $pwd, PDO::PARAM_STR);
        $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $query->bindValue(':avatar', "./asset/upload/" . $_FILES['avatar']['name'], PDO::PARAM_STR);

        $query->execute();
        
        if (!is_dir("../asset/upload")) {
            mkdir("../asset/upload");
        }
        move_uploaded_file($_FILES['avatar']['tmp_name'], "../asset/upload/" . $_FILES['avatar']['name']);
        // tout c'est bien passé
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['avatar'] = "./asset/upload/" . $_FILES['avatar']['name'];
        $_SESSION['role'] = 'ROLE_USER';
        
        header("Location: ../index.php");

    } else {
        // tout ne s'est pas bien passé
        $_POST['pwd'] = "";
        header("Location: ../registration.php?errors=".serialize($errors)."&data=".serialize($_POST));
    }
    debug($_FILES);
    debug($errors);
    debug($_POST);
    die;
} else {
    // n'a pas acces à cette page
    header("Location: ../index.php");
}
