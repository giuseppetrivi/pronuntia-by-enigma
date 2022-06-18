<?php

use yii\bootstrap4\Html;
use app\views\custom_utility_class\DateHandler;
use app\widgets\AccountInformation;

$this->title = 'Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caregiver-account">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>


  <div class="row">
    <div class="col-lg-5">

      <?= AccountInformation::widget([
        'field_name' => 'Indirizzo email',
        'content' => $caregiver_info['account_email']
      ]) ?>

      <?= AccountInformation::widget([
        'field_name' => 'Nome',
        'content' => $caregiver_info['nome']
      ]) ?>

      <?= AccountInformation::widget([
        'field_name' => 'Cognome',
        'content' => $caregiver_info['cognome']
      ]) ?>

      <?= AccountInformation::widget([
        'field_name' => 'Data di nascita',
        'content' => DateHandler::getLiteralDate($caregiver_info['data_nascita'])
      ]) ?>

      <?= AccountInformation::widget([
        'field_name' => 'Numero di telefono',
        'content' => $caregiver_info['num_telefono']
      ]) ?>

    </div>
    <div class="col-lg-7">

      <?php 
        echo Html::beginForm(['caregiver/modify-account'], 'post');
        echo Html::submitButton('Modifica dati account', ['class' => 'btn btn-primary']);
        echo Html::endForm(); 
      ?>
      
    </div>
  </div>

  <br>
  <br>


</div>