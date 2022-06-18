<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = $type=='new' ? 'Aggiungi nuovo utente' : 'Modifica utente';
$this->params['breadcrumbs'][] = ['label' => 'Utenti', 'url' => ['caregiver/utenti']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-utente">
    <h1><?= Html::encode($this->title) ?></h1>

    <br>

    <?php 
        $actionForm = $type=='new' ? 'caregiver/save-new-utente' : 'caregiver/save-modify-utente?idUtente=' . $idUtente;
        $form = ActiveForm::begin([
            'id' => 'utente-form',
            'action' => [$actionForm],
            'method' => 'post',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
            ],
        ]); 

    ?>

        <?= $form->field($model, 'nome')->textInput() ?>

        <?= $form->field($model, 'cognome')->textInput() ?>

        <?= $form->field($model, 'data_nascita')->input('date') ?>

        <?= $form->field($model, 'peso')->input('number') ?>

        <?= $form->field($model, 'sesso')->dropdownList([
            0 => 'Femmina',
            1 => 'Maschio',
            2 => 'Non spedificato'
        ]) ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton($type=='new' ? 'Salva utente' : 'Salva modifiche', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
