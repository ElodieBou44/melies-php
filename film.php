<?php
try {

  $film_id = $_GET['film_id'] ?? null;

  require 'includes/chargementClasses.inc.php';
  require 'includes/connexionPDO.inc.php';
  
  $requetesSQL = new RequetesSQL();
  $film_id = $_GET['film_id']; 
  $filmSQL = $requetesSQL->getFilm($film_id);
  $film = reset($filmSQL); 
  $realisateur = $requetesSQL->getRealisateur($film_id);
  $acteurs = $requetesSQL->getActeurs($film_id);
  $horaires = $requetesSQL->getHoraires($film_id);
  $horairesBis = [];
  $pays = $requetesSQL->getPays($film_id);

  if (!$filmSQL) throw new Exception('Film inexistant.');

} catch(Exception $e) {
  require 'templates/erreur.php';
  exit; 
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= $film['film_titre'] ?></title>
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
  <h1><?= $film['film_titre'] ?></h1>

  <div>
    <img src="<?= $film['film_affiche']; ?>" alt="">
    <div class="info">
      <p><?= $film['film_resume']; ?></p>
      <hr>
      <ul>
        <li><span>Genre:</span><span><?= $film['genre_nom']; ?></span></li>
        <li><span>Année:</span><span><?= $film['film_annee_sortie']; ?></span></li>
        <li><span>Durée:</span><span><?= $film['film_duree']; ?></span></li>

        <!-- liste des réalisateurs --> 
        <li><span>Réalisation:</span> 
          <span>
            <?= $realisateur['realisateur_prenom']; ?> <?= $realisateur['realisateur_nom']; ?>
          </span>
        </li>

        <!-- liste des pays --> 
        <li><span>Pays:</span>
        <?php foreach ($pays as $pays) : ?>
          <span>  
          <?= $pays['pays_nom']; ?>
          </span>
        <?php endforeach; ?>
        </li>

        <!-- liste des acteurs --> 
        <li><span>Interprètes:</span><span>
          <?php foreach ($acteurs as $acteur) : ?>
          <?= $acteur['acteur_prenom']; ?> <?= $acteur['acteur_nom']; ?><br> 
          <?php endforeach; ?>
            </span></li>
              
      </ul>
    </div>
    <div class="ba">
          
      <video src="<?= $film["film_bande_annonce"]; ?>" controls></video>

      <!-- horaires -->  
      <section>
        <h2>Horaires</h2>
        <div id="horaires">

       <?php
        $horairesBis = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
       ?>
       <?php
        $seances_dates = []; 
        foreach($horaires as $horaire){
          $seance_date = $horaire['seance_date'];
          $seance_heure = $horaire['seance_heure']; 
          if (isset($seances_dates[$seance_date])) {
            $seances_dates[$seance_date][] = $seance_heure;
        } else {
            $seances_dates[$seance_date] = array($seance_heure);
        }
        }
       ?>
        <?php foreach ($seances_dates as $seance_date => $seance_heure) : ?>
          <div class="jour">
          <?php
            setlocale(LC_TIME, 'fr_FR.UTF-8');
            $date = $seance_date; 
            $jourSemaine = date("l", strtotime($date));
            $jourNumerique =  date("d", strtotime($date));
            $heures = []; 
            switch ($jourSemaine) {
              case "Monday":
                  $jourSemaine = "Lundi";
                  break;
              case "Tuesday":
                  $jourSemaine = "Mardi";
                  break;
              case "Wednesday":
                  $jourSemaine = "Mercredi";
                  break;
              case "Thursday":
                  $jourSemaine = "Jeudi";
                  break;
              case "Friday":
                  $jourSemaine = "Vendredi";
                  break;
              case "Saturday":
                  $jourSemaine = "Samedi";
                  break;
              case "Sunday":
                  $jourSemaine = "Dimanche";
                  break;
              default:
                  $jourSemaine = "Jour inconnu";
                  break;
          }
            $dateFormatee = ucfirst($jourSemaine) . " " . $jourNumerique;
          ?>  
          <?= $jourSemaine; ?>
          <?= $jourNumerique?>
          </div>
          <div class="heures">
            <?php foreach ($seance_heure as $heureBase) : ?>
              <?php
              $heure = substr($heureBase, 0, 5);
              ?>
              <div> <?= $heure; ?></div>  
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
        </div>                
      </section>
    </div>
  </div>  
</section>
  </main>
</body>
</html>