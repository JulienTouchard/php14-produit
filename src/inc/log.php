<?php
session_start();
require('func.php');
require('pdo.php');

if (!empty($_POST['submitted'])) {
    $errors = [];
    $errors = validText($errors, $_POST['pwd'], 'pwd', 5, 8);
    $errors = validEmail($errors, $_POST['email']);

    $query = $pdo->prepare("SELECT * FROM user WHERE email = :email");
    $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    if($result){
        $user = $result;
        if (!password_verify($_POST['pwd'], $user['pwd'])) {
            $errors['invalid'] = "Votre email ou votre pwd sont incorrects!";
        }
    } else {
        $errors['invalid'] = "Votre email ou votre pwd sont incorrects!";
    }
    if(count($errors)===0){
        // tout c'est bien passé
        echo "success!!!";
        $_SESSION['name'] = $user['name'];
        $_SESSION['avatar'] = $user['avatar'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../index.php");
    } else {
        // tout ne s'est pas bien passé
        $_POST['pwd'] = "";
        header("Location: ../login.php?errors=".serialize($errors)."&data=".serialize($_POST));
    }
    

} else {
    // en cas de connection via l'url je redirige l'utilisateur
    header("Location: ../index.php");
}
