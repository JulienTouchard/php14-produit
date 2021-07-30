<?php
session_start();
require('../inc/func.php');
require('../inc/pdo.php');
include('./headerBack.php');
// check admin
if (!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER") {
    header("Location: ../index.php");
    die;
}
// get id
if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    header("Location: ../produits.php");
}
// get user
$query = $pdo->prepare("SELECT * FROM produit WHERE id = $id");
$query->execute();
$data = $query->fetch();

$errors = [];
if(isset($_GET['errors'])){
    $errors = unserialize($_GET['errors']);
    $data = unserialize($_GET['data']);
}

?>
  <div class="wrapform">
      <form action="./updateDataProd.php?id=<?= $id; ?>" method="POST" novalidate enctype="multipart/form-data">

          <label for="name">Name</label>
          <input type="text" name="name" id="name" value="<?php if(!empty($data['name'])) {echo $data['name']; } ?>">
          <span class="error"><?php viewError($errors,'name'); ?></span>

          <label for="price">price</label>
          <input type="number" name="price" id="price" value="<?php if(!empty($data['price'])) {echo $data['price']; } ?>">
          <span class="error"><?php viewError($errors,'price'); ?></span>

          <label for="img">img</label>
          <input type="file" name="img" id="img">
          <span class="error"><?php viewError($errors,'img'); ?></span>
          <img src=".<?= $data['img']; ?>" alt="">

          <label for="description">description</label>
          <textarea name="description" id="description"><?php if(!empty($data['description'])) {echo $data['description']; } ?></textarea>
          <span class="error"><?php viewError($errors,'description'); ?></span>

          <input type="submit" name="submitted" value="Update">
      </form>
  </div>
<?php include('./footerBack.php');