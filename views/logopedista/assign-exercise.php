<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;
use app\views\custom_utility_class\DateHandler;

$this->title = 'Assegna esercizio';
$this->params['breadcrumbs'][] = [
  'label' => 'Terapie', 
  'url' => ['logopedista/therapy']
];
$this->params['breadcrumbs'][] = [
  'label' => 'Dettagli terapia', 
  'url' => ['logopedista/therapy-details?idTerapia='.$model->idTerapia]
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-assign-exercise">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <?php 
    $form = ActiveForm::begin([
      'action' => ['logopedista/assign-exercise?idTerapia='.$model->idTerapia],
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

    <?= $form->field($model, 'nome_esercizio')->textInput() ?>
    <?= $form->field($model, 'link')->textInput([
      'placeholder' => 'Inserisci il link ad un file contentente l\'esercizio (presentazione, documento o altro)'
    ]) ?>
    <?= $form->field($model, 'data_scadenza')->input('date') ?>

    <div class="form-group">
      <div class="offset-lg-1 col-lg-11">
        <?= Html::submitButton('Assegna esercizio', ['class' => 'btn btn-primary']) ?>
      </div>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>