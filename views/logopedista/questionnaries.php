<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use app\widgets\AlertNoInfo;

$this->title = 'Questionari';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-questionnaries">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <div class="row">
    <?= Html::beginForm(['logopedista/questionnaire-form'], 'post', [
      'class' => 'col-lg-5 col-md-8 col-sm-12'
    ]) ?>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon3">Crea nuovo questionario con</span>
      </div>

      <?= Html::input('number', 'num_quesiti', '6', [
        'class' => 'form-control',
        'aria-describedby' => 'basic-addon3',
        'required' => 'true',
        'min' => '1',
        'max' => '30'
      ]); ?>

      <div class="input-group-append">
        <span class="input-group-text" id="basic-addon3">quesiti</span>
      </div>
      <div class="input-group-append">

        <?= Html::submitButton('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
        </svg>', ['class' => 'btn btn-primary']) ?>

      </div>
    </div>

    <?= Html::endForm() ?>
  </div>
  <div class="row" style="padding: 0 15px">
    <?php
      echo Html::beginForm(['logopedista/assign-questionnaire'], 'post', [
        'class' => 'mr-3'
      ]);
      echo Html::submitButton('Assegna questionario', ['class' => 'btn btn-primary']);
      echo Html::endForm();
    ?>
  </div>

  <br>

  <div class="row">

    <?php

      if (count($questionari)==0) {
        echo AlertNoInfo::widget([
          'content' => "Nessun questionario creato"
        ]);
      }
      else {
        $rows = '';
        foreach ($questionari as $value) {
          $preferito = $value['preferiti']==1 ?
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#caa520" class="bi bi-star-fill" viewBox="0 0 16 16">
              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
            </svg>' :
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#caa520" class="bi bi-star" viewBox="0 0 16 16">
              <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
            </svg>';

          $rows .= '<tr>
            <th scope="row">'.$value['id'].'</th>
            <td>'.$value['titolo'].'</td>
            <td>'.$value['altre_info'].'</td>
            <td>'
            . Html::beginForm(['/logopedista/save-preferito'], 'post', ['class' => 'form-inline'])
            . Html::input('hidden', 'idQuestionario', $value['id'])
            . Html::input('hidden', 'preferito', $value['preferiti'])
            . Html::submitButton($preferito, [
                'class' => 'btn'
              ])
            . Html::endForm()
            . '</td>
            <td>'
              . Html::beginForm(['logopedista/show-questionnaire'], 'get')
              . Html::input('hidden', 'idQuestionario', $value['id'])
              . Html::submitButton('Vedi dettagli', ['class' => 'btn btn-light'])
              . Html::endForm()
            .'</td>
          </tr>';
        }

        echo '<table class="table">
          <thead class="thead-light">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Titolo</th>
              <th scope="col">Altre info</th>
              <th scope="col">Preferito</th>
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
    

</div>