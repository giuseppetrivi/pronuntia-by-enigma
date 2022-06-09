<?php

use yii\bootstrap4\Html;

$this->title = 'Lista di logopedisti da confermare';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderatore-account">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    foreach ($logopedisti_list as $key => $value) {
    ?>

    <p><?= $value['nome'] . ' ' . $value['cognome'] ?></p>


    <?php 
    }
    ?>
</div>


