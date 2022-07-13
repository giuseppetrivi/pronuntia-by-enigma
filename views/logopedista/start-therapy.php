<?php

use app\views\custom_utility_class\DateHandler;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;

$this->title = 'Inizia terapia';
$this->params['breadcrumbs'][] = [
  'label' => 'Terapie', 
  'url' => ['logopedista/therapy']
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-start-therapy">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <?php 
    $form = ActiveForm::begin([
      'id' => 'utente-form',
      'action' => ['logopedista/start-therapy'],
      'method' => 'post',
      'layout' => 'horizontal',
      'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
        'inputOptions' => ['class' => 'col-lg-3 form-control'],
        'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
      ],
    ]); 

    ?>

    <?php
      $utenti = [];
      foreach ($utenti_result as $value) {
        $utenti[$value['id']] = '['.$value['car_nome'].' '.$value['car_cognome'].'] '
          . $value['nome'].' '.$value['cognome']
          . ' (nato il '.DateHandler::getLiteralDate($value['data_nascita']).')';
      }
    ?>
    <?= $form->field($model, 'idUtente')->dropdownList($utenti) ?>

    <div class="form-group">
      <div class="offset-lg-1 col-lg-11">
        <?= Html::submitButton('Crea terapia', ['class' => 'btn btn-primary']) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>