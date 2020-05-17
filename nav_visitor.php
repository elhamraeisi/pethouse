<nav class="navbar navbar-expand-lg navbar-dark background-light-blue">
  <a class="navbar-brand" href="index.php">Pethouse</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li>
        <?php
        $sql = 'SELECT * from generique';
        $data = $pdo->prepare($sql);
        $data->execute();
        while ($row = $data->fetch()) {
          echo '<a href="index.php?idGenerique=' . $row['id'] . '" class="navbar-brand" value=' . $row['id'] . '>' . $row['titre'] . ' </a>';
        }
        ?>
      </li>
    </ul>
  </div>
</nav>