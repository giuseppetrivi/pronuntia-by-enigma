<?php

use app\views\custom_utility_class\DateHandler;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;

$this->title = 'Dettagli terapia';
$this->params['breadcrumbs'][] = [
  'label' => 'Terapie', 
  'url' => ['logopedista/therapy']
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-therapy-details">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
      <h4>Info generali terapia</h4>
      <p class="mb-1">Iniziata il <?= DateHandler::getLiteralDate($terapia_info['data_inizio']) ?></p>
      <?php 
        if ($terapia_info['data_fine']!=null) {
          echo '<p>Terminata il '.DateHandler::getLiteralDate($terapia_info['data_fine']).'</p>';
        }
      ?>
    </div>

    <div class="col-lg-6 col-md-12 col-sm-12">
      <h4>Info caregiver</h4>
      <p class="mb-1"><?= $caregiver_info['nome'] ?> <?= $caregiver_info['cognome'] ?></p>
      <p><?= $caregiver_info['num_telefono'] ?></p>
    </div>

    <div class="col-lg-6 col-md-12 col-sm-12">
      <h4>Info utente</h4>
      <p class="mb-1">
        <?= $utente_info['nome'] ?> <?= $utente_info['cognome'] ?>
        nato il <?= DateHandler::getLiteralDate($utente_info['data_nascita']) ?>
      </p>
      <p>
        <?php 
          if ($utente_info['sesso']==0) {
            echo 'Femmina';
          }
          else if ($utente_info['sesso']==1) {
            echo 'Maschio';
          }
          else if ($utente_info['sesso']==2) {
            echo 'Non specificato';
          }
        ?>
        , peso <?= $utente_info['peso'] ?> kg
      </p>
    </div>

  </div>

  <br>

  <div class="row" style="padding: 0 15px">
    <h4 class="mb-2">Questionari assegnati</h4>
    <?php

      if (count($questionari_info)==0) {
        echo AlertNoInfo::widget([
          'content' => "Nessun questionario assegnato dal logopedista"
        ]);
      }
      else {
        $rows = '';
        foreach ($questionari_info as $value) {
          $completato = $value['qa_datacons']==null ? 
            Html::submitButton('Ancora da completare', ['class' => 'btn btn-secondary']) :
            Html::beginForm(['logopedista/show-assigned-questionnaire'], 'post')
            . Html::input('hidden', 'idTerapia', $terapia_info['id'])
            . Html::input('hidden', 'idQuestionarioAssegnato', $value['qa_id'])
            . Html::submitButton('Vedi risposte', ['class' => 'btn btn-primary'])
            . Html::endForm();
          $rows .= '<tr>
            <td>'.$value['titolo'].'</td>
            <td>'.$value['altre_info'].'</td>
            <td>'. $completato.'</td>
          </tr>';
        }

        echo '<table class="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">Titolo</th>
              <th scope="col">Altre info</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            '.$rows.'
          </tbody>
        </table>';
      }
    ?>
  </div>

  <br>

  <div class="row" style="padding: 0 15px">
    <h4>Esercizi</h4>
    <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0">
      <?php
        if ($terapia_info['data_fine']==null) {
          echo Html::beginForm(['logopedista/assign-exercise'], 'get', [
            'class' => 'mt-2 mb-2'
          ]);
          echo Html::input('hidden', 'idTerapia', $terapia_info['id']);
          echo Html::submitButton('Assegna esercizi', ['class' => 'btn btn-primary']);
          echo Html::endForm();
        }
      ?>
    </div>

    <?php
      if (count($esercizi_info)==0) {
        echo AlertNoInfo::widget([
          'content' => "Nessun esercizio assegnato dal logopedista"
        ]);
      }
      else {
        /*'<a href="/logopedista/" class="btn btn-primary mb-2" role="button">
                Segna come concluso
              </a>' */
        $rows = '';
        foreach ($esercizi_info as $value) {
          $rows .= '<tr>
            <td><a href="'.$value['link'].'">'.$value['nome_esercizio'].'</a></td>
            <td>'.DateHandler::getLiteralDate($value['data_assegnato']).'</td>
            <td>'.($value['data_scadenza']==null ? 
              'Nessuna' : 
              DateHandler::getLiteralDate($value['data_scadenza'])) .
            '</td>
            <td>'.($value['data_conclusione']==null ? 
              'Non ancora concluso' : 
              'Concluso il '. DateHandler::getLiteralDate($value['data_conclusione'])) .
            '</td>
          </tr>';
        }

        echo '<table class="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">Nome esercizio (clicca per aprire)</th>
              <th scope="col">Data di assegnazione</th>
              <th scope="col">Data di scadenza</th>
              <th scope="col">Concluso</th>
            </tr>
          </thead>
          <tbody>
            '.$rows.'
          </tbody>
        </table>';
      }
    ?>
  </div>


  <br>
  <br>

</div>