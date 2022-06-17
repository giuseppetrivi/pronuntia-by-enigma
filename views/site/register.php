<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Registrati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Inserisci tutte le informazioni negli appositi campi per registrarti alla piattaforma :</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'type')->dropdownList([
          'LOG' => 'Logopedista',
          'CAR' => 'Caregiver'
        ], [
            'id' => 'registerOptionsType',
            'onchange' => 'var e = document.getElementById("registerOptionsType");
                var typevalue = e.options[e.selectedIndex].value;
                window.location.replace("/site/register?type=" + typevalue)'
        ]) ?>

        <!-- window.location.replace("/site/register?type=" + e.options[e.selectedIndex].id) -->

        <?= $form->field($model, 'email')->input('email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'firstname')->textInput() ?>

        <?= $form->field($model, 'lastname')->textInput() ?>

        <?= $form->field($model, 'date_birth')->input('date') ?>

        <?php

            /* campi esclusivi per il logopedista */
            if ($model->type=='LOG') {
                echo $form->field($model, 'info_to_confirm')->textarea([
                    'class' => 'col-lg-5 form-control',
                    'rows' => '7',
                    'placeholder' => 'Università di laurea, anno di laurea, voto di laurea, albo dei logopedisti ecc...'
                ]);
            }
            /* campi esclusivi per il caregiver */  
            else if ($model->type=='CAR') {}         

        ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
