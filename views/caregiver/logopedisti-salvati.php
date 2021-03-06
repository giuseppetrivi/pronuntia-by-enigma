<?php

use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;
use app\widgets\CardLogopedista;

$this->title = 'Logopedisti salvati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caregiver-logopedisti">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <?php 
    echo Html::beginForm(['caregiver/search-logopedisti'], 'post', [
        'class' => 'mb-4'
      ]
    );
    echo Html::submitButton('<svg style="vertical-align: unset" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-binoculars-fill" viewBox="0 0 16 16">
      <path d="M4.5 1A1.5 1.5 0 0 0 3 2.5V3h4v-.5A1.5 1.5 0 0 0 5.5 1h-1zM7 4v1h2V4h4v.882a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V13H9v-1.5a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5V13H1V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882V4h4zM1 14v.5A1.5 1.5 0 0 0 2.5 16h3A1.5 1.5 0 0 0 7 14.5V14H1zm8 0v.5a1.5 1.5 0 0 0 1.5 1.5h3a1.5 1.5 0 0 0 1.5-1.5V14H9zm4-11H9v-.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5V3z"/>
    </svg>&nbsp Cerca un logopedista', ['class' => 'btn btn-primary']);
    echo Html::endForm(); 
  ?>


  <div class="row">

      <?php

        if (count($logopedisti_salvati)==0) {
          echo AlertNoInfo::widget([
            'content' => 'Non hai nessun logopedista salvato'
          ]);
        }
        else {
          foreach ($logopedisti_salvati as $value) {
            echo CardLogopedista::widget([
              'id' => $value['id'],
              'nome' => $value['nome'],
              'cognome' => $value['cognome'],
              'email' => $value['account_email'],
              'bio' => $value['bio'],
              'salvato' => $value['salvato']
            ]);
          }
        }

      ?>

  </div>

  <br>
  <br>

</div>