<?php

class RequetesSQL extends RequetesPDO {

  /**
   * Récupération des films de la table film qui sont visibles et qui ont des séances pendant sept jours glissants à compter de la date du jour. 
   * @return array
   */ 
  public function getFilmsAffiche()
  {
    $this->sql = "
      SELECT f.*, g.genre_nom
      FROM film f 
      INNER JOIN genre g ON f.film_genre_id = g.genre_id 
      INNER JOIN seance s ON f.film_id = s.seance_film_id 
      WHERE f.film_statut = 1 AND s.seance_date BETWEEN '2021-10-25' AND DATE_ADD('2021-10-25', INTERVAL 6 DAY) 
        GROUP BY f.film_id 
          ORDER BY f.film_titre ASC
      "; 
    $this->params = [];
    return $this->getLignes();
  }

    /**
   * Récupération des films qui ont le statut "visible" et n'ont pas de séances pendant les sept jours glissants à compter de la date du jour.
   * @return array
   */ 
  public function getFilms()
  {
    $this->sql = "
      SELECT f.*, g.genre_nom
      FROM film f
      INNER JOIN genre g ON f.film_genre_id = g.genre_id
      WHERE f.film_statut = 1
        AND NOT EXISTS (
          SELECT 1 FROM seance s
          WHERE f.film_id = s.seance_film_id
            AND s.seance_date BETWEEN '2021-10-25' AND DATE_ADD('2021-10-25', INTERVAL 6 DAY)
        )
      ORDER BY f.film_titre ASC
    "; 
    $this->params = [];
    return $this->getLignes();
  }

  /**
   * Récupération d'un film et de son genre des tables film et genre à partir du id du film 
   * @param int $film_id   
   * @return array or boolean false (si aucun résultat)
   */ 
  public function getFilm($film_id)
  {
    $this->sql = " 
      SELECT f.*, g.*
      FROM film f
      JOIN genre g ON f.film_genre_id = g.genre_id
      JOIN film_pays fp ON fp.f_p_film_id = f.film_id
      JOIN pays p ON p.pays_id = fp.f_p_pays_id
        WHERE f.film_id = :film_id 
    ";
    $this->params = ['film_id' => $film_id];
    return $this->getLignes();
  }

    /**
   * Récupération du/des réalisateur.s d'un film à partir de son id 
   * @param int $film_id   
   * @return array or boolean false (si aucun résultat)
   */ 
  public function getRealisateur($film_id)
  {
    $this->sql    = "
      SELECT * FROM realisateur
      JOIN film_realisateur on f_r_realisateur_id = realisateur_id
      JOIN film on f_r_film_id = film_id 
      WHERE film_id = :film_id";
    $this->params = ['film_id' => $film_id];
    return $this->getLignes(self::UNE_SEULE_LIGNE);
  }

    /**
   * Récupération du/des acteur.s d'un film à partir de son id 
   * @param int $film_id   
   * @return array or boolean false (si aucun résultat)
   */ 
  public function getActeurs($film_id)
  {
    $this->sql    = "
      SELECT * FROM acteur
      JOIN film_acteur on acteur_id = f_a_acteur_id
      JOIN film on f_a_film_id = film_id 
      WHERE film_id = :film_id";
    $this->params = ['film_id' => $film_id];
    return $this->getLignes();
  }

    /**
   * Récupération du pays d'un film à partir de son id 
   * @param int $film_id   
   * @return array or boolean false (si aucun résultat)
   */ 
  public function getPays($film_id)
  {
    $this->sql    = "
      SELECT * FROM pays
      JOIN film_pays on pays_id = f_p_pays_id
      JOIN film on f_p_film_id = film_id 
      WHERE film_id = :film_id";
    $this->params = ['film_id' => $film_id];
    return $this->getLignes();
  }

    /**
   * Récupération de l'horaire d'un film à partir de son id 
   * @param int $film_id   
   * @return array or boolean false (si aucun résultat)
   */ 
  public function getHoraires($film_id)
  {
    $this->sql    = "
      SELECT * FROM seance
      WHERE seance_film_id = :film_id";
    $this->params = ['film_id' => $film_id];
    return $this->getLignes();
  }

}