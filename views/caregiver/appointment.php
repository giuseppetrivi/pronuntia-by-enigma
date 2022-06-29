<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\CardAppointment;

$this->title = 'Appuntamenti';
$this->params['breadcrumbs'][] = $this->title;

$attore = 'caregiver';

?>
<div class="caregiver-appointments">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <?php 
    echo Html::beginForm(['caregiver/appointment-form'], 'post', [
        'class' => 'mb-4'
      ]
    );
    echo Html::submitButton('<svg style="vertical-align: unset" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
      <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
    </svg>&nbsp; Prenota appuntamento', ['class' => 'btn btn-primary']);
    echo Html::endForm(); 
  ?>

  <div class="row">

    <?php

      if (count($appuntamenti)==0) {
        echo '<div class="alert alert-secondary" role="alert">
          Non c\'è nessun appuntamento prenotato.
        </div>';
      }
      else {
        foreach ($appuntamenti as $value) {
          echo CardAppointment::widget([
            'id' => $value['id'],
            'data_ora' => $value['data_ora'],
            'info' => $value['info'],
            'nomeLog' => $value['nome'],
            'cognomeLog' => $value['cognome']
          ]);
        }
      }

    ?>

  </div>
    

</div>