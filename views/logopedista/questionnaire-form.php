<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;

$this->title = 'Crea questionario';
$this->params['breadcrumbs'][] = [
  'label' => 'Questionari', 
  'url' => ['logopedista/questionnaries']
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-create-questionnaire">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <div class="row">
    <?= Html::beginForm(['logopedista/create-questionnaire'], 'post', [
      'class' => 'col-lg-6 col-md-9 col-sm-12'
    ]) ?>

    <h4>Informazioni basilari</h4>

    <div class="form-group">
      <label for="formGroupExampleInput">Titolo</label>
      <?= Html::textInput('titolo', '', [
        'class' => 'form-control',
        'placeholder' => 'Titolo del questionario',
        'required' => 'true'
      ]) ?>
    </div>

    <div class="form-group">
      <label for="formGroupExampleInput2">Altre informazioni</label>
      <?= Html::textarea('altre_info', '', [
        'rows' => '3',
        'class' => 'form-control',
        'placeholder' => 'Altre informazioni utili per chi compilerà il questionario',
        'required' => 'true'
      ]) ?>
    </div>

    <br>
    <h4>Quesiti</h4>

    <?php

      echo Html::input('hidden', 'num_quesiti', $num_quesiti);
      for ($i=0; $i<$num_quesiti; $i++) {
        $quesitoNum = $i+1;
        $idQuesito = 'quesito' . $quesitoNum;

        echo '<div class="form-group">
          <label for="formGroupExampleInput2">Quesito n.'.$quesitoNum.'</label>';
        echo Html::textInput($idQuesito, '', [
          'class' => 'form-control',
          'required' => 'true'

        ]);
        echo '</div>';
      }
    ?>

    <?= Html::submitButton('Crea questionario', [
      'class' => 'btn btn-primary'
    ]) ?>


    <?= Html::endForm() ?>
  </div>

  <br>
  <br>
    

</div>