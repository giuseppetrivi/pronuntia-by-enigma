<?php

use yii\bootstrap4\Html;
use app\widgets\CardUtente;

$this->title = 'I miei utenti';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caregiver-utenti">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <?php 
    echo Html::beginForm(['caregiver/utente-form'], 'post', [
        'class' => 'mb-4'
      ]
    );
    echo Html::submitButton('<svg style="vertical-align: unset" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
      <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
      <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
    </svg>&nbsp; Aggiungi nuovo utente', ['class' => 'btn btn-primary']);
    echo Html::endForm(); 
  ?>

  <div class="row">

    <?php

      if (count($all_utenti)==0) {
        echo '<div class="alert alert-secondary" role="alert">
          Non hai registrato nessun utente.
        </div>';
      }
      else {
        foreach ($all_utenti as $value) {
          echo CardUtente::widget([
            'id' => $value['id'],
            'nome' => $value['nome'],
            'cognome' => $value['cognome'],
            'eta' => $value['data_nascita'],
            'peso' => $value['peso'],
            'sesso' => $value['sesso']
          ]);
        }
      }

    ?>
  </div>

  <br>
  <br>


</div>