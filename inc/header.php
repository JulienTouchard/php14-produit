<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BRIEF APRES LE CONFINEMENT</title>
    <link rel="stylesheet" href="./asset/css/style.css">
</head>

<body>

    <header>
        <nav style="display:flex;justify-content:space-between;">
            <ul>
                <li><a href="index.php">Home</a></li>

                <?php if (!isset($_SESSION['name'])) { ?>
                    <!-- si ma session n'est pas active -->
                    <li><a href="registration.php">Nouvel utilisateur</a></li>
                    <li><a href="login.php">Se connecter</a></li>

                <?php } else { ?>
                    <!-- si ma session est active -->
                    <li><a href="logout.php">Se déconnecter</a></li>

                <?php }
                if (isset($_SESSION['role']) && $_SESSION['role'] === "ROLE_ADMIN") {
                ?>
                    <li><a href="admin.php">Admin</a></li>
                <?php } ?>
            </ul>
            <?php
            if (isset($_SESSION['name'])) {
                echo "<div>Bonjour " . $_SESSION['name'] . "</div>";
                echo "<img src='" . $_SESSION['avatar'] . "' width='40px'>";
            }
            ?>

        </nav>
    </header>