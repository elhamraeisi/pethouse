<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body class="bg-info">
  <div id="myform">
    <div class="text-center pb-4">
      <img id="logo" src="uploads/pethouse-logo.png" class="mt-5 w-25" />
    </div>
    <div class="container">
      <div id="myform-row" class="row justify-content-center align-items-center">
        <div id="myform-column" class="col-md-6">
          <div id="myform-box" class="col-md-12">
            <form id="myform-form" class="form" action="login_action.php" method="post">
              <h2 class="text-center text-info">Connexion</h2>
              <!-- alert -->
              <?php
              if (isset($_GET['auth']) && !empty($_GET['auth']) && $_GET['auth'] === 'false') {
                echo '<div class="alert alert-danger" role="alert">Login et/ou mot de passe incorrect !</div>';
              }
              ?>
              <div class="input-group my-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="email" id="mail" name="mail" class="form-control" placeholder="Identifiant" required>
              </div>
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="Mot de passe" required>
              </div>
              <div class="form-group">
                <div class="text-center my-3">
                  <img src="captcha.php">
                </div>
                <input type="text" name="captcha" id="captcha" placeholder="Entrez le code" class="form-control noborder" required>
              </div>
              <div>
                <input type="submit" value="Se connecter" class="btn btn-success rounded-pill btn-block">
                <div class="mt-3">
                  <a href="register_form.php" class="btn btn-info rounded-pill btn-block">Inscription</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>