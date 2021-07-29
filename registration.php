<?php
session_start();
require('inc/func.php');
include('inc/header.php');

$errors = [];
if(isset($_GET['errors'])){
    $errors = unserialize($_GET['errors']);
    $data = unserialize($_GET['data']);
}

?>
  <div class="wrapform">
      <form action="inc/register.php" method="POST" novalidate enctype="multipart/form-data">

          <label for="email">Email</label>
          <input type="text" name="email" id="email" value="<?php if(!empty($data['email'])) {echo $data['email']; } ?>">
          <span class="error"><?php viewError($errors,'email'); ?></span>


          <label for="pwd">Password</label>
          <input type="text" name="pwd" id="pwd" value="<?php if(!empty($data['pwd'])) {echo $data['pwd']; } ?>">
          <span class="error"><?php viewError($errors,'pwd'); ?></span>


          <label for="name">Nom</label>
          <input type="text" name="name" id="name" value="<?php if(!empty($data['name'])) {echo $data['name']; } ?>">
          <span class="error"><?php viewError($errors,'name'); ?></span>

          <label for="avatar">Avatar</label>
          <input type="file" name="avatar" id="avatar">
          <span class="error"><?php viewError($errors,'avatar'); ?></span>

          <label for="mentions">Accepter les mentions legales</label>
          <input type="checkbox" name="mentions" id="mentions">
          <span class="error"><?php viewError($errors,'mentions'); ?></span>
          <span class="error"><?php viewError($errors,'double'); ?></span>
          <input type="submit" name="submitted" value="Ajouter">
      </form>
  </div>
<?php include('inc/footer.php');