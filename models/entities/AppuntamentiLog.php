<?php

namespace app\models\entities;

use Yii;
use PDO;


class AppuntamentiLog extends Appuntamenti {
  
  public function getAllAppuntamenti($dates=null) {
    $queryDataOra = '';
    foreach ($dates as $value) {
      $queryDataOra .= "AND a.data_ora>=$value ";
    }

    $idLogopedista = $this->idRole;
    $sql = "SELECT a.id, a.data_ora, a.info, c.nome, c.cognome
      FROM appuntamenti as a, caregiver as c
      WHERE a.logopedista_id=:idLog AND a.caregiver_id=c.id
        $queryDataOra
      ORDER BY a.data_ora ASC";
    return Yii::$app->db->createCommand($sql)
      ->bindParam(':idLog', $idLogopedista)
      ->queryAll();
  }



  
}

?>