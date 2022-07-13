<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;

$this->title = 'Dettagli questionario';
$this->params['breadcrumbs'][] = [
  'label' => 'Terapie', 
  'url' => ['caregiver/therapy']
];
$this->params['breadcrumbs'][] = [
  'label' => 'Dettagli terapia', 
  'url' => ['caregiver/therapy-details?idTerapia='.$idTerapia]
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-show-questionnaire">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <h2><?= $questionario_info['titolo'] ?></h2>
  <p><?= $questionario_info['altre_info'] ?></p>

  <br>

  <?php
    echo Html::beginForm(['caregiver/answer-questionnaire'], 'post');
    echo Html::input('hidden', 'idQuestionarioAssegnato', $idQuestionarioAssegnato);
    echo Html::input('hidden', 'num_quesiti', count($questionario_info['quesiti']));

    $count = 1;
    foreach ($questionario_info['quesiti'] as $value) {
      echo '<h5 class="mb-2"><b>'.$count.'.</b>&nbsp; '.$value['quesito'].'</h5>';
      echo Html::textInput($value['id'], '', [
        'class' => 'form-control mb-3',
        'required' => 'true'
      ]);
      $count++;
    }

    echo Html::submitButton('Conferma questionario', [
      'class' => 'btn btn-primary'
    ]);
    echo Html::endForm();
  ?>

</div>