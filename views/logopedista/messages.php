<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;
use app\widgets\ChatWidgetLog;

$this->title = 'Messaggi ricevuti';
$this->params['breadcrumbs'][] = $this->title;

$attore = 'caregiver';

?>
<div class="logopedista-messages">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <?php
        
    if (count($messaggi_risposte)==0) {
      echo AlertNoInfo::widget([
        'content' => 'Non è presente nessun messaggio'
      ]);
    }
    else {
      echo '<div class="row">';
      foreach ($messaggi_risposte as $value) {
        echo ChatWidgetLog::widget([
          'nomeCar' => $value['nome'],
          'cognomeCar' => $value['cognome'],
          'id' => $value['id'],
          'titolo' => $value['titolo'],
          'm_contenuto' => $value['mcon'],
          'm_data_ora' => $value['mdo'],
          'r_contenuto' => $value['rcon'],
          'r_data_ora' => $value['rdo']
        ]);
      }
      echo '</div>';
    }

  ?>
    

</div>