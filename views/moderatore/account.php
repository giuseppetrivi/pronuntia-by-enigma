<?php

use yii\bootstrap4\Html;

$this->title = 'Account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderatore-account">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= $_moderatore->cod_dipendente ?></p>
    <p><?= $_moderatore->nome ?></p>
    <p><?= $_moderatore->cognome ?></p>
    <p><?= $_moderatore->account_email ?></p>

    

</div>