<?php
// Imports
include_once 'header_inc.php';
include_once 'db_connect_inc.php';
include('head.php');
include('nav_admin.php');
?>

<body class="bg-light">
  <div class="shadow-sm bg-white rounded my-5 mx-5 ">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>Liste des <b>proprietaire</b></h2>
          </div>
          <div class="col-sm-6 d-flex flex-row-reverse">
            <a type="submit" class="btn btn-outline-light ml-3 pt-3" data-toggle="modal" data-target="#proprietaireFormModal"><i class="fas fa-plus-circle pr-1"></i><span>Ajouter un proprietaire</span></a>
            <form action="proprietaire_list.php" method="GET" class="has-search mt-2">
              <span class="fa fa-search form-control-feedback"></span>
              <input class="form-control rounded-pill bg-transparent border-white text-white" type="search" name="search" placeholder="Nom ou prénom">
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php
    try {
      // Préparation et exécution requête
      $sql = 'SELECT photo AS "Photo", id AS "Code", prenom AS "Prénom", nom AS "Nom", sexe AS "Sexe", ddn AS "Né(e)", adresse AS "Adresse", tel AS "Tél", mail AS "Mail" FROM proprietaire ';
      // chercher un proprietaire par son nom ou prenom
      if (!empty($_GET['search']))
        $sql .= ' WHERE nom like "%' . $_GET['search'] . '%" OR prenom like "%' . $_GET['search'] . '%"';

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

          // Ajoute la donnée dans sa cellule ou dans une image
          if ($types[$col] === 'BLOB') {
            $html .= '<td><img src="' . ($val === null ? 'pics/profile-pic.png' : $val) . '" class="rounded-circle" style="width:5.5em;height:5.5em"></td>';
          } else {
            $html .= '<td align="center" >' . $val . '</td>';
          }
        }
        // Ajoute boutons MAJ et SUPPR
        $html .= '<td><a class="text-warning" href="proprietaire_list.php?id=' . $row['Code'] . '"><i class="fas fa-edit h4 p-2"></i></a>';
        $html .= '<a class="text-danger" href="proprietaire_suppr.php?id=' . $row['Code'] . '"><i class="fas fa-trash-alt h4 p-2"></i></a></td>';
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
    <div class="modal fade" id="proprietaireFormModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content p-0">
          <div class="modal-body p-0">
            <?php include('proprietaire_form.php'); ?>
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
          $('#proprietaireFormModal').on('hidden.bs.modal', function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('id')) {
              window.location.href = 'proprietaire_list.php';
            }
          });
          //Pour afficher automatiquement le modal de formumlaire 
          //si le parametre id se trouve dans l'url
          //exemple : proprietaire_list.php?id=10
          var urlParams = new URLSearchParams(window.location.search);
          if (urlParams.has('id')) {
            $('#proprietaireFormModal').modal('show')
          }
        },
        false
      );
    </script>
</body>