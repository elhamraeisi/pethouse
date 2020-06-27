<?php
// Imports
include_once 'commun/db_connect_inc.php';
include_once 'commun/header_inc_admin.php';
include('commun/head.php');
include('nav_admin.php');
?>

<body class="bg-light">
  <div class="container">
    <div class="shadow-sm bg-white rounded my-5 mx-5 ">
      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Génériques</h2>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse">
              <a type="submit" class="btn btn-outline-light ml-3 pt-3" data-toggle="modal" data-target="#generiqueFormModal"><i class="fas fa-plus-circle pr-1"></i><span>Ajouter</span></a>
              <form action="generique_list.php" method="GET" class="has-search mt-2">
                <span class="fa fa-search form-control-feedback"></span>
                <input class="form-control rounded-pill bg-transparent border-white text-white" type="search" name="search" placeholder="Titre">
              </form>
            </div>
          </div>
        </div>
      </div>

      <?php
      try {
        // Préparation et exécution requête
        $sql = 'SELECT id AS "Code", titre AS "Titre" FROM generique';
        // chercher un generique par son nom ou prenom
        if (!empty($_GET['search']))
          $sql .= ' WHERE titre like "%' . $_GET['search'] . '%"';

        $data = $pdo->prepare($sql);
        $data->execute(); // Renvoie dataset avec colonnes et lignes

        // Crée le tableau/en-tête
        $html = '<table class="table table-striped table-responsive-lg table-light">';
        $html .= '<thead class="thead-light"><tr>';
        for ($i = 0; $i < $data->columnCount(); $i++) {
          // Affiche le nom des colonnes extraits du dataset
          $meta = $data->getColumnMeta($i);
          $html .= '<th class="text-center">' . $meta['name'] . '</th>';
        }
        $html .= '<th class="text-center">Réglages</th>';
        $html .= '</tr></thead>';

        // Crée le tableau/corps
        $html .= '<tbody>';
        while ($row = $data->fetch()) { // Pour chaque ligne du dataset
          $html .= '<tr>';
          foreach ($row as $col => $val) { // Pour chaque colonne de la ligne
            $html .= '<td align="center">' . $val . '</td>';
          }
          // Ajoute boutons MAJ et SUPPR
          $html .= '<td align="center"><a class="text-warning" href="generique_list.php?id=' . $row['Code'] . '"><i class="fas fa-edit h4 p-2"></i></a>';
          $html .= '<a class="text-danger" href="actions/generique_suppr.php?id=' . $row['Code'] . '"><i class="fas fa-trash-alt h4 p-2"></i></a></td>';
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
      <div class="modal fade" id="generiqueFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content p-0">
            <div class="modal-body p-0">
              <?php include('generique_form.php'); ?>
            </div>
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
                  location.href = this.getAttribute('href');
                }
              },
              false
            );
          }
          //Quand on ferme le modal si le parametre id se trouve dans l'url
          //on refresh la page sans le parametre id
          $('#generiqueFormModal').on('hidden.bs.modal', function() {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('id')) {
              window.location.href = 'generique_list.php';
            }
          });
          //Pour afficher automatiquement le modal de formumlaire 
          //si le parametre id se trouve dans l'url
          //exemple : generique_list.php?id=10
          var urlParams = new URLSearchParams(window.location.search);
          if (urlParams.has('id')) {
            $('#generiqueFormModal').modal('show')
          }
          //si on a le parametre 'saveSuccess' dans l'url on affiche le toast
          if (urlParams.has('saveSuccess')) {
            toastr.success("Enregistré avec succès", undefined, {
              timeOut: 2000,
              positionClass: "toast-bottom-right"
            })
          }
          //si on a le parametre 'deleteSuccess' dans l'url on affiche le toast
          if (urlParams.has('deleteSuccess')) {
            toastr.success("Supprimé avec succès", undefined, {
              timeOut: 2000,
              positionClass: "toast-bottom-right"
            })
          }
        },
        false
      );
    </script>
</body>