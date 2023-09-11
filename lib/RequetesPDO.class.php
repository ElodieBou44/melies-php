<?php

/**
 * Classe des requêtes PDO 
 *
 */
class RequetesPDO {

  protected $sql;
  protected $params; // penser à initialiser systématiquement ce tableau, en lien avec la propriété $sql

  const UNE_SEULE_LIGNE = true;

  /**
   * Récupération d'une ou plusieurs lignes de la requête SELECT dans la propriété $sql 
   * en intégrant s'il y en a, les valeurs associées aux marqueurs de la requête préparée, dans le tableau de la propriété $params
   * @param bool $uneSeuleLigne 
   * @return array|false booléen false si aucun résultat avec $uneSeuleLigne à true
   */
  public function getLignes($uneSeuleLigne = false) {
    global $oPDO;
    $oPDOStatement = $oPDO->prepare($this->sql);
    foreach ($this->params as $marqueur => $valeur) {
      // $oPDOStatement->bindValue(":$marqueur", $valeur);
      $oPDOStatement->bindParam(":$marqueur", $this->params[$marqueur]);
    } 
    $oPDOStatement->execute();
    return $uneSeuleLigne ? $oPDOStatement->fetch(PDO::FETCH_ASSOC) : $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
  }
}