<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <title>Erreur</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css?v=1.1">
</head>
<body>
  <main>
    <section>
      <h1>Problème technique</h1>
      <p>Nous vous prions de nous excuser pour cet incident.</p>
      <p>Message d'erreur: <?= $e->getMessage() ?></p> 
      <p>Fichier:          <?= $e->getFile() ?></p> 
    </section>
  </main>
</body>
</html>  