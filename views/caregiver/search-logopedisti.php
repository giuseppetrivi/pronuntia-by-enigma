<?php

use yii\bootstrap4\Html;
use app\views\custom_utility_class\DateHandler;
use app\widgets\CardLogopedista;

$this->title = 'Cerca un logopedista';
$this->params['breadcrumbs'][] = ['label' => 'Logopedisti salvati', 'url' => ['caregiver/logopedisti']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caregiver-search-logopedisti">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>


  <div class="row">
    <div class="col-lg-5">

        <?php 
          echo Html::beginForm(['caregiver/search-logopedisti'], 'post');

          echo '<div class="input-group mb-3">';
          echo Html::input('text', 'search', $searchkey, [
            'class' => 'form-control',
            'placeholder' => 'Cerca per cognome',
          ]);
          echo Html::submitButton('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>', [
            'class' => 'btn btn-light',
            'style' => 'border-radius: 0 0.25rem 0.25rem 0'
          ]);
          echo '</div>';
          echo Html::endForm(); 
        ?>

    </div>
    <div class="col-lg-7"></div>


    <?php

      if ($logopedisti_trovati===null) {
        echo '<div class="col-lg-12 col-md-12 col-sm-12 alert alert-secondary" role="alert">
          Digita il cognome del logopedista che cerchi nella barra di ricerca
        </div>';
      }
      else if (count($logopedisti_trovati)==0) {
        echo '<div class="col-lg-12 col-md-12 col-sm-12 alert alert-secondary" role="alert">
          Nessun risultato
        </div>';
      }
      else {
        foreach ($logopedisti_trovati as $value) {
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