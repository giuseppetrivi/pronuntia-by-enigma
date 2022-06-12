<?php

use yii\bootstrap4\Html;
use app\views\custom_utility_class\DateHandler;
use app\widgets\ListGroupLogopedistaInfo;

$this->title = 'Informazioni sul Logopedista';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderatore-logopedista-info">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>


  <div class="list-group w-auto" style="word-break: break-all">
    <div class="row">
      <div class="col-lg-5">
        <?php 
          
          echo ListGroupLogopedistaInfo::widget([
            'field_name' => 'Id Logopedista',
            'content' => $logopedista_info['id']
          ]);

          echo ListGroupLogopedistaInfo::widget([
            'field_name' => 'Nome',
            'content' => $logopedista_info['nome']
          ]);

          echo ListGroupLogopedistaInfo::widget([
            'field_name' => 'Cognome',
            'content' => $logopedista_info['cognome']
          ]);
          
          echo ListGroupLogopedistaInfo::widget([
            'field_name' => 'Email',
            'content' => $logopedista_info['account_email']
          ]);

          echo ListGroupLogopedistaInfo::widget([
            'field_name' => 'Data di nascita',
            'content' => DateHandler::getLiteralDate($logopedista_info['data_nascita'])
          ]);

          echo ListGroupLogopedistaInfo::widget([
            'field_name' => 'Info aggiuntive',
            'content' => $logopedista_info['info_per_conferma']
          ]);

        ?>
      </div>
      <div class="col-lg-7">

          <div class="col-lg-12 mb-4">
            <?php 
              echo Html::beginForm(['moderatore/accept-logopedista'], 'post');
              echo Html::input('hidden', 'id', $logopedista_info['id']);
              echo Html::submitButton('Accetta registrazione', ['class' => 'btn btn-success']);
              echo Html::endForm(); 
            ?>
          </div>
          <div class="col-lg-12 mb-4">
            <?php 
              echo Html::beginForm(['/moderatore/reject-logopedista'], 'post');
              echo Html::input('hidden', 'id', $logopedista_info['id']);
              echo Html::textarea('motivo', '', [
                'rows' => '5', 
                'placeholder' => 'Motivo',
                'class' => 'form-control mb-3',
                'required' => 'true'
              ]);
              echo Html::submitButton('Respingi registrazione', ['class' => 'btn btn-light']);
              echo Html::endForm();
            ?>
          </div>
          <div class="col-lg-12 mb-4">
            <?php 
              echo Html::beginForm(['/moderatore/deny-logopedista'], 'post');
              echo Html::input('hidden', 'id', $logopedista_info['id']);
              echo Html::submitButton('Rifiuta registrazione', ['class' => 'btn btn-danger']);
              echo Html::endForm();
            ?>
          </div>
        
      </div>
    </div>
  </div>

  <br>
  <br>

  <?php
  if (count($rejection_info)>0):
  ?>

    <h5>Richieste respinte</h5>
    <br>
    <div class="list-group w-auto" style="word-break: break-all; margin-bottom:50px;">
      <div class="row">
        <div class="col-lg-9">
          <?php 

            foreach ($rejection_info as $value) {
              echo ListGroupLogopedistaInfo::widget([
                'field_name' => DateHandler::getLiteralDate($value['data']),
                'content' => $value['motivo']
              ]);
            }

          ?>
        </div>
      </div>
    </div>

  <?php
  endif
  ?>


</div>