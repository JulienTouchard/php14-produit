<?php
session_start();
require('../inc/func.php');
include('./headerBack.php');
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}
$errors = [];
if(isset($_GET['errors'])){
    $errors = unserialize($_GET['errors']);
    $data = unserialize($_GET['data']);
}

?>
  <div class="wrapform">
      <form action="./newProdData.php" method="POST" novalidate enctype="multipart/form-data">

          <label for="name">Nom du produit</label>
          <input type="text" name="name" id="name" value="<?php if(!empty($data['name'])) {echo $data['name']; } ?>">
          <span class="error"><?php viewError($errors,'name'); ?></span>
    

          <label for="prix">prix</label>
          <input type="number" name="prix" id="prix" value="<?php if(!empty($data['prix'])) {echo $data['prix']; } ?>">
          <span class="error"><?php viewError($errors,'prix'); ?></span>

          <label for="img">img</label>
          <input type="file" name="img" id="img">
          <span class="error"><?php viewError($errors,'img'); ?></span>

          <label for="description">Nom</label>
          <textarea name="description" id="description" value="<?php if(!empty($data['description'])) {echo $data['description']; } ?>"></textarea>
          <span class="error"><?php viewError($errors,'description'); ?></span>

          <input type="submit" name="submitted" value="Ajouter">
      </form>
  </div>
<?php include('./footerBack.php');