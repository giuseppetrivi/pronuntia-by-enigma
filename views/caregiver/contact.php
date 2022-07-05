<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;
use app\widgets\ChatWidgetCar;

$this->title = 'Contatta un logopedista';
$this->params['breadcrumbs'][] = $this->title;

$attore = 'caregiver';

?>
<div class="caregiver-contact">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <ul class="nav nav-tabs" id="contact-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="chat-tab" data-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="true">Conversazioni</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="form-tab" data-toggle="tab" href="#form" role="tab" aria-controls="home" aria-selected="false">Modulo di contatto</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
      <br>

      <?php
        
        if (count($messaggi_risposte)==0) {
          echo AlertNoInfo::widget([
            'content' => 'Non è presente nessuna domanda'
          ]);
        }
        else {
          echo '<div class="row">';
          foreach ($messaggi_risposte as $value) {
            echo ChatWidgetCar::widget([
              'nomeLog' => $value['nome'],
              'cognomeLog' => $value['cognome'],
              'id' => $value['id'],
              'titolo' => $value['titolo'],
              'm_contenuto' => $value['mcon'],
              'm_data_ora' => $value['mdo'],
              'r_contenuto' => $value['rcon'],
              'r_data_ora' => $value['rdo']
            ]);
          }
          echo '</div>';
        }

      ?>

    </div>

    <div class="tab-pane fade" id="form" role="tabpanel" aria-labelledby="form-tab">
      <br>
      
      <?php 
        $form = ActiveForm::begin([
          'id' => 'utente-form',
          'action' => ['caregiver/contact'],
          'method' => 'post',
          'layout' => 'horizontal',
          'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-4 form-control'],
            'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
          ],
        ]); 

      ?>

        <?php
          $array_options = [];
          foreach ($logopedisti_salvati as $value) {
            $array_options[$value['id']] = $value['nome'] . ' ' . $value['cognome'];
          }
          echo $form->field($model, 'logopedista')->dropdownList($array_options);
        ?>

        <?= $form->field($model, 'titolo')->textInput() ?>

        <?= $form->field($model, 'contenuto')->textarea([
          'rows' => '5'
        ]) ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Invia messaggio', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
    

</div>