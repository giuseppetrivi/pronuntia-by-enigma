<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;

$this->title = 'Dettagli questionario';
$this->params['breadcrumbs'][] = [
  'label' => 'Terapie', 
  'url' => ['logopedista/therapy']
];
$this->params['breadcrumbs'][] = [
  'label' => 'Dettagli terapia', 
  'url' => ['logopedista/therapy-details?idTerapia='.$idTerapia]
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-show-assigned-questionnaire">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <h2><?= $questionario_info['titolo'] ?></h2>
  <p><?= $questionario_info['altre_info'] ?></p>

  <br>

  <?php
    $count = 1;
    foreach ($questionario_info['quesiti'] as $value) {
      echo '<h5><b>'.$count.'.</b>&nbsp; '.$value['quesito'].'</h5>';
      echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
        .$value['risposta'].'</p>';
      $count++;
    }
  ?>

</div>