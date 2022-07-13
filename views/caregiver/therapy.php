<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;
use app\widgets\CardTherapyCar;

$this->title = 'Terapie';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="caregiver-therapy">

  <h1><?= Html::encode($this->title) ?></h1>
    
  <br>

  <div class="row" style="padding: 0 15px">
    <?php
      if (count($terapie)==0) {
        echo AlertNoInfo::widget([
          'content' => "Nessuna terapia iniziata dai logopedisti"
        ]);
      }
      else {
        foreach ($terapie as $value) {
          echo CardTherapyCar::widget([
            'id' => $value['terapia_id'],
            'nomeLog' => $value['log_nome'],
            'cognomeLog' => $value['log_cognome'],
            'nome' => $value['nome'],
            'cognome' => $value['cognome'],
            'data_nascita' => $value['data_nascita'],
            'data_fine' => $value['data_fine'],
            'sesso' => $value['sesso']
          ]);
        }
      }
    ?>
  </div>

</div>