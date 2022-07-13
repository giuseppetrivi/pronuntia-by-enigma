<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;
use app\views\custom_utility_class\DateHandler;

$this->title = 'Assegna questionario';
$this->params['breadcrumbs'][] = [
  'label' => 'Questionari', 
  'url' => ['logopedista/questionnaries']
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-assign-questionnaire">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <?php 
    $form = ActiveForm::begin([
      'id' => 'utente-form',
      'action' => ['logopedista/assign-questionnaire'],
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
      $terapie = [];
      foreach ($terapie_result as $value) {
        if ($value['data_fine']!=null) {
          continue;
        }
        $terapie[$value['terapia_id']] = '['.$value['car_nome'].' '.$value['car_cognome'].'] '
          . $value['nome'].' '.$value['cognome']
          . ' (nato il '.DateHandler::getLiteralDate($value['data_nascita']).')';
      }
    ?>
    <?= $form->field($model, 'idTerapia')->dropdownList($terapie) ?>

    <?php
      $questionari = [];
      foreach ($questionari_result as $value) {
        $questionari[$value['id']] = '('.$value['id'].') - ' . $value['titolo'];
      }
    ?>
    <?= $form->field($model, 'idQuestionario')->dropdownList($questionari) ?>

    <div class="form-group">
      <div class="offset-lg-1 col-lg-11">
        <?= Html::submitButton('Assegna questionario', ['class' => 'btn btn-primary']) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>