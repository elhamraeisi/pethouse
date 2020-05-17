<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
  <div id="myform">
    <div class="text-center">
      <img id="logo" src="pics/pethouse-logo.png" class="mt-5" />
    </div>
    <div class="container">
      <div id="myform-row" class="row justify-content-center align-items-center mb-5">
        <div id="myform-column" class="col-md-6">
          <div id="myform-box" class="col-md-12">
            <form id="myform-form" class="form" action="register_action.php" method="post">
              <h2 class="text-center text-info">Inscription</h2>
              <!-- alert -->
              <?php
              if (isset($_GET['exists']) && !empty($_GET['exists']) && $_GET['exists'] === 'true') {
                echo '<div class="alert alert-danger" role="alert">L\'adresse mail existe déjà dans la table des abonnés !</div>';
              }
              if (isset($_GET['captcha']) && !empty($_GET['captcha']) && $_GET['captcha'] === 'false') {
                echo '<div class="alert alert-danger" role="alert">Le code est incorrect !</div>';
              }
              ?>
              <form action="register_action.php" method="post">
                <div class="form-group">
                  <label for="prenom">Prénom*</label>
                  <input type="text" id="prenom" name="prenom" class="form-control noborder" maxlength="30" pattern="[A-Za-zàâäáéèëêïîôöùûü\-]{2,30}" required>
                </div>
                <div class="form-group">
                  <label for="nom">Nom*</label>
                  <input type="text" id="nom" name="nom" class="form-control noborder" maxlength="30" pattern="[A-Za-zàâäáéèëêïîôöùûü\-]{2,30}" required>
                </div>
                <div class="form-group">
                  <label for="mail">Courriel*</label>
                  <input type="email" name="mail" id="mail" class="form-control noborder" required>
                </div>
                <div class="form-group">
                  <label for="pass">Mot de passe*</label>
                  <input type="password" name="pass" id="pass" class="form-control noborder" minlength="6" required>
                </div>
                <div class="form-group">
                  <label for="confirmation">Confirmation*</label>
                  <input name="password_confirm" type="password" id="password_confirm" class="form-control noborder" minlength="6" oninput="check(this)" required>
                  <script language='javascript' type='text/javascript'>
                    function check(input) {
                      if (input.value != document.getElementById('pass').value) {
                        input.setCustomValidity('Password Must be Matching.');
                      } else {
                        // input is valid -- reset the error message
                        input.setCustomValidity('');
                      }
                    }
                  </script>
                </div>
                <div class="form-group">
                  <div class="text-center my-3">
                    <img src="captcha.php">
                  </div>
                  <input type="text" name="captcha" id="captcha" class="form-control noborder" placeholder="Entrez le code" required>
                </div>
                <input type="submit" value="S'inscrire" class="btn btn-success rounded-pill btn-block">
              </form>
          </div>
        </div>
      </div>
    </div>
</body>

</html>