<?php
try {
  require 'includes/chargementClasses.inc.php';
  require 'includes/connexionPDO.inc.php';
  
  $requetesSQL = new RequetesSQL();
  $films = $requetesSQL->getFilms();

} catch(Exception $e) {
  require 'templates/erreur.php';
  exit; 
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Prochainement</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css?v=1.1">
  <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <div id="logo">Le Méliès</div>
    <nav>
      <ul>
        <li><a href="index.php">À l'affiche</a></li>
        <li><a href="prochainement.php">Prochainement</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section>
      <h1>PROCHAINEMENT</h1>
      <div>
        <?php foreach ($films as $film) : ?>
        <div>
          <a href="film.php?film_id=<?= $film["film_id"]; ?>"><img src="<?= $film["film_affiche"]; ?>" alt=""></a>
          <p class="legende"><?= $film["genre_nom"]; ?> - <?= $film["film_annee_sortie"]; ?> - <?= $film["film_duree"]; ?> min</p>
        </div>
        <?php endforeach; ?>
      
      </div>
    </section>
 
  </main>
</body>
</html>