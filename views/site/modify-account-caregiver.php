<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Modifica account';
$this->params['breadcrumbs'][] = ['label' => 'Account', 'url' => ['site/account']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modify-account">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Modifica le informazioni del tuo account :</p>

    <?php $form = ActiveForm::begin([
        'id' => 'modify-caregiver-form',
        'action' => ['site/modify-account'],
        'method' => 'post',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-4 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'nome')->textInput() ?>

        <?= $form->field($model, 'cognome')->textInput() ?>

        <?= $form->field($model, 'data_nascita')->input('date') ?>

        <?= $form->field($model, 'num_telefono')->input('number') ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Salva modifiche', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
