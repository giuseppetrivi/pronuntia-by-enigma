<?php

use yii\bootstrap4\Html;
use app\views\custom_utility_class\DateHandler;
use app\widgets\AccountInformation;

$this->title = 'Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-account">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>


  <div class="row">
    <div class="col-lg-5">

      <?php if ($type=='CAR') : ?>
        <?= AccountInformation::widget([
          'field_name' => 'Indirizzo email',
          'content' => $role_info['account_email']
        ]) ?>

        <?= AccountInformation::widget([
          'field_name' => 'Nome',
          'content' => $role_info['nome']
        ]) ?>

        <?= AccountInformation::widget([
          'field_name' => 'Cognome',
          'content' => $role_info['cognome']
        ]) ?>

        <?= AccountInformation::widget([
          'field_name' => 'Data di nascita',
          'content' => DateHandler::getLiteralDate($role_info['data_nascita'])
        ]) ?>

        <?= AccountInformation::widget([
          'field_name' => 'Numero di telefono',
          'content' => $role_info['num_telefono']
        ]) ?>
      <?php endif; ?>

      <?php if ($type=='LOG') : ?>
        
      <?php endif; ?>

    </div>
    <div class="col-lg-7">

      <?php 
        echo Html::beginForm(['site/modify-account'], 'post');
        echo Html::submitButton('Modifica dati account', ['class' => 'btn btn-primary']);
        echo Html::endForm(); 
      ?>
      
    </div>
  </div>

  <br>
  <br>


</div>