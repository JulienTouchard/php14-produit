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
      <form action="inc/log.php" method="POST" novalidate>

          <label for="email">Email</label>
          <input type="text" name="email" id="email" value="<?php if(!empty($data['email'])) {echo $data['email']; } ?>">
          <span class="error"><?php viewError($errors,'email'); ?></span>


          <label for="pwd">Password</label>
          <input type="text" name="pwd" id="pwd" value="<?php if(!empty($data['pwd'])) {echo $data['pwd']; } ?>">
          <span class="error"><?php viewError($errors,'pwd'); ?></span>

          <input type="submit" name="submitted" value="Se connecter">
          <span class="error"><?php viewError($errors,'invalid'); ?></span>
          
      </form>
  </div>
<?php include('inc/footer.php');