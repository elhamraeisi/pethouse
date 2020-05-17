<?php
// Imports
include_once 'commun/header_inc.php';
include_once 'commun/db_connect_inc.php';
include('head.php');
include('nav_admin.php');
?>

<body class="bg-light">
  <div class="shadow-sm bg-white rounded my-5 mx-5 ">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Liste des <b></b>animals</h2>
          </div>
          <div class="col-sm-6 d-flex flex-row-reverse">
            <a class="btn btn-outline-light ml-3 pt-3" data-toggle="modal" data-target="#animalFormModal"><i class="fas fa-plus-circle pr-1"></i><span>Ajouter un animal</span></a>
            <form action="admin.php" method="GET" class="has-search mt-2">
              <span class="fa fa-search form-control-feedback"></span>
              <input class="form-control rounded-pill bg-transparent border-white text-white" type="search" name="search" placeholder="Nom">
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php
    try {
      // Préparation et exécution requête
      $sql = 'SELECT photo AS "Photo", id AS "Code", nom AS "Nom", sexe AS "Sexe", couleur AS "Couleur", poids AS "Poids", disponibilite AS "Disponibilité", vaccine AS "Vacciné", identifie AS "Identifié", prix AS "Prix", ddn AS "Nés" FROM animal';
      // chercher un animal par son nom
      if (!empty($_GET['search']))
        $sql .= ' WHERE nom like "%' . $_GET['search'] . '%"';

      $data = $pdo->prepare($sql);
      $data->execute(); // Renvoie dataset avec colonnes et lignes

      // Crée le tableau/en-tête
      $html = '<table class="table table-striped table-responsive-lg table-light">';
      $html .= '<thead class="thead-light"><tr>';
      for ($i = 0; $i < $data->columnCount(); $i++) {
        // Affiche le nom des colonnes extraits du dataset
        // $html .= '<th>Colonne ' . ($i + 1) . '</th>';
        $meta = $data->getColumnMeta($i);
        $html .= '<th class="text-center">' . $meta['name'] . '</th>';
        // Stocke dans un tableau le nom de la colonne associé 
        // à son type de données
        $types[$meta['name']] = $meta['native_type'];
      }
      $html .= '<th class="text-center">Réglages</th>';

      $html .= '</tr></thead>';

      // Crée le tableau/corps
      $html .= '<tbody>';
      while ($row = $data->fetch()) { // Pour chaque ligne du dataset
        $html .= '<tr>';
        foreach ($row as $col => $val) { // Pour chaque colonne de la ligne

          if ($types[$col] === 'TINY') {
            $val = $val == true ? 'Oui' : 'Non';
          }

          // Ajoute la donnée dans sa cellule ou dans une image
          if ($types[$col] === 'BLOB') {
            $html .= '<td><img src="' . ($val === null ? 'pics/animal_generic.png' : $val) . '"style="width:8em;height:5em"></td>';
          } else {
            $html .= '<td align="center" >' . $val . '</td>';
          }
        }
        // Ajoute boutons MAJ et SUPPR
        $html .= '<td><a class="text-warning" href="admin.php?id=' . $row['Code'] . '" ><i class="fas fa-edit h4 p-2"></i></a>';
        $html .= '<a class="text-danger" href="actions/animal_suppr.php?id=' . $row['Code'] . '"><i class="fas fa-trash-alt h4 p-2"></i></a></td>';
        $html .= '</tr>';
      }
      $html .= '</tbody>';
      $html .= '</table>';
      echo $html;
      unset($pdo);
    } catch (PDOException $err) {
      echo '<p class="alert alert-danger">' . $err->getMessage() . '</p>';
    }
    ?>
    <div class="modal fade" id="animalFormModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content p-0">
          <div class="modal-body p-0">
            <?php include('animal_form.php'); ?>
          </div>
        </div>
      </div>
    </div>

    <script>
      window.addEventListener(
        'load',
        function() {

          let buttons = document.querySelectorAll('a.text-danger');
          for (let i = 0; i < buttons.length; i++) {
            buttons[i].addEventListener(
              'click',
              function(evt) {
                evt.preventDefault();
                let answer = confirm('Voulez-vous vraiment supprimer cette ligne ?');
                if (answer) {
                  location.href = evt.target.href;
                }
              },
              false
            );
          }
          //Quand on ferme le modal si le parametre id se trouve dans l'url
          //on refresh la page sans le parametre id
          $('#animalFormModal').on('hidden.bs.modal', function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('id')) {
              window.location.href = 'admin.php';
            }
          });
          //Pour afficher automatiquement le modal de formumlaire 
          //si le parametre id se trouve dans l'url
          //exemple : admin.php?id=10
          var urlParams = new URLSearchParams(window.location.search);
          if (urlParams.has('id')) {
            $('#animalFormModal').modal('show')
          }
        },
        false
      );
    </script>
</body>